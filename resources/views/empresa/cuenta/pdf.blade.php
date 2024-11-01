<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Pure css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
        integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">


    <title>{{ __('Cuentas') }}</title>

</head>

<body>
    <center>
        <img align="center" src="{{ $imagen }}" alt="" height="100">
    </center>
    <h3 align="center"><u>{{ __('Cuentas') }}</u></h3>
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

    <h5><u>{{ __('Listado de Cuentas') }}:</u></h5>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th>
                    <font size="1">Cuenta</font>
                </th>
                <th>
                    <font size="1">{{ __('Nit/DPI') }}</font>
                </th>
                <th>
                    <font size="1">{{ __('Intermediario') }}</font>
                </th>
                <th>
                    <font size="1">{{ __('Propietario') }}</font>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cuentas as $cuenta)
                <tr>
                    <td align="left">
                        <font size="1">
                            <small>
                                <strong>{{ $cuenta->codigo }}</strong>
                                <br>
                                <strong>{{ $cuenta->razon_social }}</strong>
                                <br>
                                {{ $cuenta->correo}}
                                <br>
                                {{ $cuenta->telefono }}
                                <br>
                                {{ $cuenta->otra_forma_contacto }}
                            </small>
                        </font>
                    </td>
                    <td align="left">
                        <font size="1">
                            <small>
                                Nit: {{ $cuenta->nit }}
                                <br>
                                DPI: {{ $cuenta->dpi }}
                            </small>
                        </font>
                    </td>
                    <td align="left">
                        <font size="1">
                            <small>
                                <strong>{{ $cuenta->datos_intermediario_nombre }}</strong>
                                <br>
                                {{ $cuenta->datos_intermediario_correo}}
                                <br>
                                {{ $cuenta->datos_intermediario_telefono }}
                            </small>
                        </font>
                    </td>
                    <td align="left">
                        <font size="1">
                            <small>
                                <strong>{{ $cuenta->datos_propietario_nombre }}</strong>
                                <br>
                                {{ $cuenta->datos_propietario_correo}}
                                <br>
                                {{ $cuenta->datos_propietario_telefono }}
                            </small>
                        </font>
                    </td>


                </tr>
            @endforeach

        </tbody>

    </table>


</body>

</html>
