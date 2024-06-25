<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;


class CompraListDetail implements FromView, WithColumnFormatting, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $f1, $f2;
    public function __construct($f1, $f2){

        $this->f1 = $f1;
        $this->f2 = $f2;

    }

    public function columnFormats(): array
    {
        return [
            'I' => NumberFormat::FORMAT_NUMBER_00
        ];
    }


    public function view(): View{

        $ingresos = DB::table('ingreso as i')
        ->join('proveedor as p', 'i.idpro', '=', 'p.idpro')
        ->join('detalle_ingreso as di', 'i.idingreso', '=', 'di.idingreso')
        ->select('i.idingreso', 'i.fecha', 'i.hora', 'p.nomPro', DB::raw('sum(di.cantidad*precioCompra) as total'))
        ->whereBetween('fecha', [$this->f1, $this->f2])
        ->orderBy('i.idingreso', 'desc')
        ->groupBy('i.idingreso', 'i.fecha', 'i.hora', 'p.nomPro')
        ->get();

        $detalle_ingreso = DB::table('detalle_ingreso as di')
            ->join('ingreso as i', 'di.idingreso', 'i.idingreso')
            ->join('producto as p', 'di.IdProducto', 'p.IdProducto')
            ->get();
        return view('compras.ingreso.listExcelDetail', ["ingresos"=>$ingresos, "detalle_ingreso" => $detalle_ingreso,
        "inicio" => $this->f1, "fin" => $this->f2]);

    }
}
