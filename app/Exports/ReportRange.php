<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ReportRange implements FromView, WithColumnFormatting, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $f1, $f2, $f3;
    public function __construct($f1, $f2, $f3){
        $this->f1 = $f1;
        $this->f2 = $f2;
        $this->f3 = $f3;

    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_NUMBER_00,
            'H' => NumberFormat::FORMAT_NUMBER_00,
            'I' => NumberFormat::FORMAT_NUMBER_00
        ];
    }

    public function view(): View{
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $start = Carbon::now()->startOfYear()->toDateString();

        $query = empty($this->f1) ? $start : $this->f1;
        $query2 = empty($this->f2) ? $fecha : $this->f2;
        $query3 = $this->f3 == 'TODO'?'':$this->f3;

        $registro = DB::table('pago as p')
            ->join('reserva as r', 'p.IdReserva', 'r.IdReserva')
            ->join('cliente as c', 'r.IdCliente','=', 'c.IdCliente')
            ->whereBetween('FechReserva', [$query, $query2])
            ->Where(function ($q)  use ($query3) {
                $q->orWhere('r.Estado', 'LIKE', '%' . $query3 . '%')
                    ->orWhere('c.Nombre', 'LIKE', '%' . $query3 . '%')
                    ->orWhere('r.Num_Hab', $query3)
                    ->orWhere('servicio', 'LIKE', '%' . $query3 . '%');
            })
            ->orderByDesc('r.IdReserva')
            ->get();

        $consumo = DB::table('consumo as c')
            ->select(DB::raw('SUM(Total) as total'), 'IdReserva')
            ->where('Estado', 'PAGADO')
            ->groupBy('IdReserva')
            // ->orderByDesc(DB::raw('SUM(2)'))
            ->get();

        return view('reporte/rango.reporteexcel', ["registro"=>$registro, "consumo"=>$consumo]);
    }
}
