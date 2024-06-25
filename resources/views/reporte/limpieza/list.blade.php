<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte Limpieza</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.80em;
        }

        table {
            border-collapse: collapse;
            border-color: rgb(0, 0, 0);
            width: 100%;
        }

        td {
            padding: 3px;
            border: 1px solid rgb(37, 87, 134);
        }

        th {
            padding: 3px;
            border: 1px solid rgb(37, 87, 134);
            background: #eaf3fa;
            color: #12446b;
        }

    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td style="border: none"> <img src="../public/logo/{{ $datos_hotel->logo }}" alt="" width="80"
                        height="80"></td>
                <td style="border: none; width: 30%"></td>
                <td style="border: none">{{ $datos_hotel->nombre }} <br>
                    Dirección: {{ $datos_hotel->direccion }}</td>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                <td style="border: none"><span style="font-weight: bold"> Usuario Responsable </span> <br>
                    {{ auth()->user()->Nombre }}</td>
                <td style="border: none"><span style="font-weight: bold"> Fecha </span> <br>
                    {{ date('d/m/Y H:i:s', strtotime($fechaHora)) }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; font-weight: bold; border: none">REPORTE LIMPIEZA</td>
            </tr>
        </thead>
    </table>
    <br>
    <table>
        <thead >
            <tr>
                <th>N°</th>
                <th>PERSONAL</th>
                <th>LIMPIEZA</th>
                <th>HABITACIÓN</th>
                <th>F. ASIGNACIÓN</th>
            </tr>
        </thead>
        <tbody>
            @php($cont = 1)
            @foreach ($limpieza as $l)
               <tr>
                   <td>{{ $cont++ }}</td>
                   <td>{{ $l->nomPer }}</td>
                   <td>{{ $l->nomLim }}</td>
                   <td>{{ $l->Num_Hab }}</td>
                   <td>{{ date('d/m/Y', strtotime($l->fechaDetLim)) }} {{ $l->horaDetLim}}</td>
               </tr>
            @endforeach


        </tbody>
    </table>
</body>
</html>
