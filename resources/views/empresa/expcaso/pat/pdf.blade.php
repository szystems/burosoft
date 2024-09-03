<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Pure css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
        integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">


    <title>PAT</title>

</head>

<body>
    <center>
        <img align="center" src="{{ $imagen }}" alt="" height="100">
    </center>
    <h3 align="center"><u>PAT</u></h3>
    <label>
        <font size="1">Fecha Reporte:</font>
        <font color="blue" size="1">
            @php
                $horafecha = new DateTime("now", new DateTimeZone('America/Guatemala'));
                $horafecha = $horafecha->format('d-m-Y, H:i:s')
            @endphp
            {{ $horafecha }} (America/Guatemala)
        </font>
    </label>

    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th align="left" colspan="6"><u>Cuenta</u></th>
            </tr>
            <tr>
                <th align="right">
                    <font size="1">Razon Social:</font>
                </th>
                <td>
                    <font size="1">{{ $cuenta->razon_social }}</font>
                </td>
                <th align="right">
                    <font size="1">NIT:</font>
                </th>
                <td>
                    <font size="1">{{ $cuenta->nit }}</font>
                </td>
                <th align="right">
                    <font size="1">DPI:</font>
                </th>
                <td>
                    <font size="1">{{ $cuenta->dpi }}</font>
                </td>
            </tr>
            <tr>
                <th align="left" colspan="6"><u>PAT (Procedimiento de Administración Tributaria)</u></th>
            </tr>
            <tr>
                <th align="right">
                    <font size="1">No.Expediente:</font>
                </th>
                <td>
                    <font size="1">{{ $pat->no_expediente }}</font>
                </td>
                <th align="right">
                    <font size="1">No.Programa:</font>
                </th>
                <td>
                    <font size="1">{{ $pat->no_programa }}</font>
                </td>
                <th align="right">
                    <font size="1">Gerencia:</font>
                </th>
                <td>
                    <font size="1">{{ $pat->gerencia }}</font>
                </td>
            </tr>
            <tr>
                <th align="right">
                    <font size="1">Tipo Contribuyente:</font>
                </th>
                <td>
                    <font size="1">{{ $pat->tipo_contribuyente }}</font>
                </td>
                <th align="right">
                    <font size="1">Estado:</font>
                </th>
                <td colspan="3">
                    <b>
                        @if($pat->estado == "Activo")
                            <font size="1" color="limegreen">{{ $pat->estado }}</font>
                        @elseif ($pat->estado == "Cerrado")
                            <font size="1" color="red">{{ $pat->estado }}</font>
                        @elseif ($pat->estado == "Archivo")
                            <font size="1" color="orange">{{ $pat->estado }}</font>
                        @endif
                    </b>
                </td>
            </tr>

        </thead>
        {{-- <tbody>
            <tr>
                <td align="center">
                    <font size="1">hola</font>
                </td>
                <td align="center">
                    <font size="1">hola 2</font>
                </td>
            </tr>
        </tbody> --}}
    </table>

    <br>
    <h4><strong><u>Nombramientos</u></strong></h4>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th>
                    <font size="1">Fecha</font>
                </th>
                <th>
                    <font size="1">No.</font>
                </th>
                <th>
                    <font size="1">Nombramientos</font>
                </th>
                <th>
                    <font size="1">Periodo</font>
                </th>
                <th>
                    <font size="1">Usuario</font>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nombramientos as $nombramiento)
            <tr>
                <td align="center">
                    @php
                        $fecha = date('d/m/Y', strtotime($nombramiento->created_at));
                    @endphp
                    <font size="1">{{ $fecha }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $nombramiento->no }}</font>
                </td>
                <td align="center">
                    <font size="1">
                        {{ $nombramiento->nombrado_1 }}
                        <br>
                        {{ $nombramiento->nombrado_2 }}
                        <br>
                        {{ $nombramiento->nombrado_3 }}
                        <br>
                        {{ $nombramiento->nombrado_4 }}
                        <br>
                        {{ $nombramiento->nombrado_5 }}
                    </font>
                </td>
                <td align="center">
                    <font size="1">{{ $nombramiento->periodo }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $nombramiento->usuario->name }}</font>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <h4><strong><u>Notificaciones</u></strong></h4>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th>
                    <font size="1">Fecha</font>
                </th>
                <th>
                    <font size="1">Tipo Notificación</font>
                </th>
                <th>
                    <font size="1">Recibió</font>
                </th>
                <th>
                    <font size="1">Domicilio Notificación</font>
                </th>
                <th>
                    <font size="1">Acto Notificado</font>
                </th>
                <th>
                    <font size="1">Plazo de Atención</font>
                </th>
                <th>
                    <font size="1">Vencimiento de Plazo</font>
                </th>
                <th>
                    <font size="1">Usuario</font>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notificaciones as $notificacion)
            <tr>
                <td align="center">
                    @php
                        $fecha = date('d/m/Y', strtotime($notificacion->created_at));
                        $vencimiento_plazo = date('d/m/Y', strtotime($notificacion->vencimiento_plazo));
                    @endphp
                    <font size="1">{{ $fecha }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $notificacion->tipo_notificacion }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $notificacion->recibio }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $notificacion->domicilio_notificacion }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $notificacion->acto_notificado }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $notificacion->plazo_atencion }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $vencimiento_plazo }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $notificacion->usuario->name }}</font>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <h4><strong><u>Requerimientos</u></strong></h4>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th>
                    <font size="1">Fecha</font>
                </th>
                <th>
                    <font size="1">No</font>
                </th>
                <th>
                    <font size="1">Tipo de Requerimiento</font>
                </th>
                <th>
                    <font size="1">Lugar Para Atender</font>
                </th>
                <th>
                    <font size="1">Plazo de Atención</font>
                </th>
                <th>
                    <font size="1">Tipo de Revision</font>
                </th>
                <th>
                    <font size="1">Usuario</font>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requerimientos as $requerimiento)
            <tr>
                <td align="center">
                    @php
                        $fecha = date('d/m/Y', strtotime($requerimiento->created_at));
                    @endphp
                    <font size="1">{{ $fecha }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $requerimiento->no }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $requerimiento->tipo_requerimiento }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $requerimiento->lugar_atender }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $requerimiento->plazo_atencion }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $requerimiento->tipo_revision }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $requerimiento->usuario->name }}</font>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <h4><strong><u>Expediente Digital</u></strong></h4>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th>
                    <font size="1">Fecha</font>
                </th>
                <th>
                    <font size="1">nombre</font>
                </th>
                <th>
                    <font size="1">Descripcion</font>
                </th>
                <th>
                    <font size="1">Usuario</font>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expedientes as $expediente)
            <tr>
                <td align="center">
                    @php
                        $fecha = date('d/m/Y', strtotime($requerimiento->created_at));
                    @endphp
                    <font size="1">{{ $fecha }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $expediente->nombre }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $expediente->descripcion }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $expediente->usuario->name }}</font>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
