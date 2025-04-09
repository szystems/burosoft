<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Cuentas') }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
            font-size: 9px;
        }
        th {
            background-color: #f2f2f2;
        }
        .blue { color: #0000FF; }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .header img {
            max-height: 80px;
        }
        h3, h5 {
            margin: 8px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        @if($imagen)
            <img src="{{ $imagen }}" alt="Logo">
        @endif
        <h3><u>{{ __('Cuentas') }}</u></h3>
    </div>

    <div>
        <span>{{ __('Fecha Reporte:') }}: </span>
        <span class="blue">
            @php
                $horafecha = now();
                $horafecha = $horafecha->format('d-m-Y, H:i:s')
            @endphp
            {{ $horafecha }}
        </span>
    </div>

    <h5><u>{{ __('Listado de Cuentas') }}:</u></h5>
    <table>
        <thead>
            <tr>
                <th>Cuenta</th>
                <th>{{ __('Nit/DPI') }}</th>
                <th>{{ __('Intermediario') }}</th>
                <th>{{ __('Propietario') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cuentas as $cuenta)
                <tr>
                    <td>
                        <strong>{{ $cuenta->codigo }}</strong><br>
                        <strong>{{ $cuenta->razon_social }}</strong><br>
                        {{ $cuenta->correo }}<br>
                        {{ $cuenta->telefono }}<br>
                        {{ $cuenta->otra_forma_contacto }}
                    </td>
                    <td>
                        Nit: {{ $cuenta->nit }}<br>
                        DPI: {{ $cuenta->dpi }}
                    </td>
                    <td>
                        <strong>{{ $cuenta->datos_intermediario_nombre }}</strong><br>
                        {{ $cuenta->datos_intermediario_correo }}<br>
                        {{ $cuenta->datos_intermediario_telefono }}
                    </td>
                    <td>
                        <strong>{{ $cuenta->datos_propietario_nombre }}</strong><br>
                        {{ $cuenta->datos_propietario_correo }}<br>
                        {{ $cuenta->datos_propietario_telefono }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
