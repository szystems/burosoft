<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Pure css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
        integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">


    <title>{{ __('Empresas') }}</title>

</head>

<body>
    <center>
        <img align="center" src="{{ $imagen }}" alt="" height="100">
    </center>
    <h3 align="center"><u>{{ __('Empresas') }}</u></h3>
    <label>
        <font size="1">{{ __('Fecha Reporte:') }}:</font>
        <font color="blue" size="1">
            @php
                $horafecha = now();
                $horafecha = $horafecha->format('d-m-Y, H:i:s')
            @endphp
            {{ $horafecha }}
        </font>
    </label>
    <br>

    <h5><u>{{ __('Listado de Empresas') }}:</u></h5>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th>
                    <font size="1">Nombre</font>
                </th>
                <th>
                    <font size="1">{{ __('Direccion') }}</font>
                </th>
                <th>
                    <font size="1">{{ __('Licencia') }}</font>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empresas as $empresa)
                <tr>
                    <td align="left">
                        <font size="1">
                            <b>{{ $empresa->nombre }}</b>
                        </font>
                    </td>
                    <td align="left">
                        <font size="1">{{ $empresa->direccion }}</font>
                    </td>
                    <td align="center">
                        @php
                            $today = now();
                            $fecha_vencimiento = date("d/m/Y", strtotime($empresa->fecha_vencimiento));
                        @endphp
                        <font size="1" color="{{ $empresa->fecha_vencimiento >= $today ? "green" : "orange" }}">
                            {{ $fecha_vencimiento }}
                        </font>
                    </td>


                </tr>
            @endforeach

        </tbody>

    </table>


</body>

</html>
