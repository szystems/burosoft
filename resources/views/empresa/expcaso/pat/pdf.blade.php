<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Pure css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
        integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">


    <title>Expediente</title>

</head>

<body>
    <center>
        <img align="center" src="{{ $imagen }}" alt="" height="100">
    </center>
    <h3 align="center"><u>Expediente</u></h3>
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
                <th align="left" colspan="6"><u>Expediente</u></th>
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
                <td>
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
                <th align="right">
                    <font size="1">Resultado:</font>
                </th>
                <td>
                    <font size="1">{{ $pat->resultado }}</font>
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

    @if ($nombramientos->count() != 0)
    <br>
    <h4><strong><u>Nombramientos</u> ({{ $nombramientos->count() }})</strong></h4>

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
                    <font size="1">Período</font>
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
                        $fecha = date('d/m/Y', strtotime($nombramiento->fecha));
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
    @endif

    @if ($notificaciones->count() != 0)
    <br>
    <h4><strong><u>Notificaciones</u> ({{ $notificaciones->count() }})</strong></h4>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th>
                    <font size="1">Fecha/Hora</font>
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
                        $fecha = date('d/m/Y', strtotime($notificacion->fecha));
                        $vencimiento_plazo = date('d/m/Y', strtotime($notificacion->vencimiento_plazo));
                    @endphp
                    <font size="1">{{ $fecha }} {{ date('H:i', strtotime($notificacion->hora)) }}</font>
                </td>
                <td align="center">
                    <font size="1" color="{{ in_array($notificacion->tipo_notificacion, ["Personalmente", "Por Otro Procedimiento Idóneo"]) ? "limegreen" : "red" }}">{{ $notificacion->tipo_notificacion }}</font>
                </td>
                <td align="center">
                    @if ($notificacion->persona_idonea == "No")
                        <font size="1" color="red">Solicitar Nulidad</font>
                        <br>
                    @endif
                    <font size="1">{{ $notificacion->recibio }}</font>
                </td>
                <td align="center">
                    <font size="1">
                        @if ($notificacion->domicilio_notificacion_es)
                            {{ $notificacion->domicilio_notificacion_es }}
                            <br>
                        @endif
                        @if ($notificacion->domicilio_notificacion_es == "Otro")
                            {{ $notificacion->domicilio_notificacion_otro }}
                            <br>
                        @endif
                        @if ($notificacion->domicilio_notificacion)
                            {{ $notificacion->domicilio_notificacion }}
                        @endif
                    </font>
                </td>
                <td align="center">
                    <font size="1">
                        {{  $notificacion->acto_notificado}}
                        @if ($notificacion->folios_notificados != "0")
                            <br>
                            FN:{{ $notificacion->folios_notificados }}
                        @endif
                    </font>
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
    @endif

    @if ($requerimientos->count() != 0)
    <br>
    <h4><strong><u>Requerimientos</u> ({{ $requerimientos->count() }})</strong></h4>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th>
                    <font size="1">No</font>
                </th>
                <th>
                    <font size="1">Fecha/Fecha Maxima</font>
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
                    <font size="1">{{ $requerimiento->no }}</font>
                </td>
                <td align="center">
                    @php
                        $fecha = date('d/m/Y', strtotime($requerimiento->fecha));
                        $fecha_maxima = date('d/m/Y', strtotime($requerimiento->fecha_maxima));
                    @endphp
                    <font size="1">{{ $fecha }}/{{ $fecha_maxima }}</font>
                </td>
                <td align="center">
                    <font size="1">
                        {{ $requerimiento->tipo_requerimiento }}
                        @if ($requerimiento->tipo_requerimiento == "Otro")
                            <br>
                            {{ $requerimiento->tipo_requerimiento_otro }}
                        @endif
                    </font>
                </td>
                <td align="center">
                    <font size="1">
                        {{  $requerimiento->lugar_atender}}
                        @if ($requerimiento->lugar_atender == "Otro")
                            <br>
                            {{ $requerimiento->lugar_atender_otro }}
                        @endif
                        <br>
                        {{ $requerimiento->domicilio }}
                    </font>
                </td>
                <td align="center">
                    <font size="1">{{ $requerimiento->plazo_atencion }}</font>
                </td>
                <td align="center">
                    <font size="1">
                        {{  $requerimiento->tipo_revision}}
                        @if ($requerimiento->tipo_revision == "Otro")
                            <br>
                            {{ $requerimiento->tipo_revision_otro }}
                        @endif
                    </font>
                </td>
                <td align="center">
                    <font size="1">{{ $requerimiento->usuario->name }}</font>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if ($atencionrequerimientos->count() != 0)
    <br>
    <h4><strong><u>Atención de Requerimientos</u> ({{ $atencionrequerimientos->count() }})</strong></h4>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th>
                    <font size="1">No</font>
                </th>
                <th>
                    <font size="1">Fecha</font>
                </th>
                <th>
                    <font size="1">Forma de Atención</font>
                </th>
                <th>
                    <font size="1">Entregado En</font>
                </th>
                <th>
                    <font size="1">Lleva Solicitud <br> / <br> Acta Administratíva</font>
                </th>
                <th>
                    <font size="1">Atendio</font>
                </th>
                <th>
                    <font size="1">Observaciones</font>
                </th>
                <th>
                    <font size="1">Usuario</font>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($atencionrequerimientos as $atencion)
            <tr>
                <td align="center">
                    <font size="1">{{ $atencion->no }}</font>
                </td>
                <td align="center">
                    @php
                        $fecha = date('d/m/Y', strtotime($atencion->fecha));
                    @endphp
                    <font size="1">{{ $fecha }}</font>
                </td>

                <td align="center">
                    <font size="1">
                        {{ $atencion->forma_atencion }}
                        @if ($atencion->forma_atencion == "Otro")
                            <br>
                            {{ $atencion->forma_atencion_otro }}
                        @endif
                    </font>
                </td>
                <td align="center">
                    <font size="1">
                        {{ $atencion->entregado_en }}
                        @if ($atencion->entregado_en == "Otros")
                            <br>
                            {{ $atencion->entregado_en_otro }}
                        @endif
                    </font>
                </td>
                <td align="center">
                    <font size="1">{{  $atencion->oficio_respuesta}} / {{  $atencion->acta_administrativa}}</font>
                </td>
                <td align="center">
                    <font size="1">{{  $atencion->quien_atendio}}</font>
                </td>
                <td align="center">
                    <font size="1">{{  $atencion->observaciones}}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $atencion->usuario->name }}</font>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if ($providencias->count() != 0)
    <br>
    <h4><strong><u>Providencia (AR)</u> ({{ $providencias->count() }})</strong></h4>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th>
                    <font size="1">Fecha</font>
                </th>
                <th>
                    <font size="1">Tipo de Providencia</font>
                </th>
                <th>
                    <font size="1">Se Admite</font>
                </th>
                <th>
                    <font size="1">Observaciones</font>
                </th>
                <th>
                    <font size="1">Usuario</font>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($providencias as $providencia)
            <tr>
                <td align="center">
                    @php
                        $fecha = date('d/m/Y', strtotime($providencia->fecha));
                    @endphp
                    <font size="1">{{ $fecha }}</font>
                </td>
                <td align="center">
                    <font size="1">
                        {{ $providencia->tipo_providencia }}
                        @if ($providencia->tipo_providencia == "Otro")
                            <br>
                            {{ $providencia->tipo_providencia_otro }}
                        @endif
                    </font>
                </td>
                <td align="center">
                    <font size="1">
                        {{  $providencia->admite}}
                        @if ($providencia->admite_otro == "Otro")
                            <br>
                            {{ $providencia->admite_otro }}
                        @endif
                    </font>
                </td>
                <td align="center">
                    <font size="1">{{ $providencia->observaciones }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $providencia->usuario->name }}</font>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if ($nulidades->count() != 0)
    <br>
    <h4><strong><u>Nulidades</u> ({{ $nulidades->count() }})</strong></h4>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th>
                    <font size="1">No</font>
                </th>
                <th>
                    <font size="1">Fecha</font>
                </th>
                <th>
                    <font size="1">Tipo de Nulidad</font>
                </th>
                <th>
                    <font size="1">Nueva Notificacion</font>
                </th>
                <th>
                    <font size="1">Usuario</font>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nulidades as $nulidad)
            <tr>
                <td align="center">
                    <font size="1">{{ $nulidad->no }}</font>
                </td>
                <td align="center">
                    @php
                        $fecha = date('d/m/Y', strtotime($nulidad->fecha));
                    @endphp
                    <font size="1">{{ $fecha }}</font>
                </td>
                <td align="center">
                    <font size="1">
                        {{ $nulidad->tipo_nulidad }}
                        @if ($nulidad->tipo_nulidad == "Otro")
                            <br>
                            {{ $nulidad->tipo_nulidad_otro }}
                        @endif
                    </font>
                </td>
                <td align="center">
                    <font size="1">
                        {{  $nulidad->nueva_notificacion}}
                    </font>
                </td>
                <td align="center">
                    <font size="1">{{ $nulidad->usuario->name }}</font>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif


    @if ($actasadministrativas->count() != 0)
    <br>
    <h4><strong><u>Actas Administrativas</u> ({{ $actasadministrativas->count() }})</strong></h4>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th>
                    <font size="1">Fecha</font>
                </th>
                <th>
                    <font size="1">¿Quiénes intervinieron?</font>
                </th>
                <th>
                    <font size="1">Tipo Acta</font>
                </th>
                <th>
                    <font size="1">Observaciones</font>
                </th>
                <th>
                    <font size="1">Usuario</font>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($actasadministrativas as $acta)
            <tr>
                <td align="center">
                    @php
                        $fecha = date('d/m/Y', strtotime($acta->fecha));
                    @endphp
                    <font size="1">{{ $fecha }}</font>
                </td>

                <td align="center">
                    <font size="1">{{  $acta->quienes_intervinieron}}</font>
                </td>
                <td align="center">
                    <font size="1">
                        {{ $acta->tipo_acta }}
                        @if ($acta->tipo_acta_otro == "Otro")
                            <br>
                            {{ $acta->tipo_acta_otro }}
                        @endif
                    </font>
                </td>
                <td align="center">
                    <font size="1">{{  $acta->observaciones}}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $acta->usuario->name }}</font>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if ($expedientes->count() != 0)
    <br>
    <h4><strong><u>Expedientes/Antecedentes</u> ({{ $expedientes->count() }})</strong></h4>
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
                        $fecha = date('d/m/Y', strtotime($expediente->fecha));
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
    @endif

    @if ($rafs->count() != 0)
    <br>
    <h4><strong><u>Providencias de Urgencia (PRAF)</u> ({{ $rafs->count() }})</strong></h4>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th>
                    <font size="1">Fecha</font>
                </th>
                <th>
                    <font size="1">Tipo de Providencia</font>
                </th>
                <th>
                    <font size="1">Se Admite</font>
                </th>
                <th>
                    <font size="1">Observaciones</font>
                </th>
                <th>
                    <font size="1">Usuario</font>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rafs as $raf)
            <tr>
                <td align="center">
                    @php
                        $fecha = date('d/m/Y', strtotime($raf->fecha));
                    @endphp
                    <font size="1">{{ $fecha }}</font>
                </td>
                <td align="center">
                    <font size="1">
                        {{ $raf->tipo_providencia }}
                        @if ($raf->tipo_providencia == "Otro")
                            <br>
                            {{ $raf->tipo_providencia_otro }}
                        @endif
                    </font>
                </td>
                <td align="center">
                    <font size="1">
                        {{  $raf->admite}}
                        @if ($raf->admite_otro == "Otro")
                            <br>
                            {{ $raf->admite_otro }}
                        @endif
                    </font>
                </td>
                <td align="center">
                    <font size="1">{{ $raf->observaciones }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $raf->usuario->name }}</font>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

</body>

</html>
