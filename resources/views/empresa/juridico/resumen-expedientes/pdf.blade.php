<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resumen de Expedientes</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }
        .header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header-left {
            display: table-cell;
            width: 20%;
            vertical-align: middle;
        }
        .header-center {
            display: table-cell;
            width: 60%;
            text-align: center;
            vertical-align: middle;
        }
        .header-right {
            display: table-cell;
            width: 20%;
            text-align: right;
            vertical-align: middle;
        }
        .logo {
            max-width: 80px;
            max-height: 60px;
        }
        .company-info h1 {
            margin: 0 0 5px 0;
            font-size: 18px;
            color: #333;
        }
        .company-info p {
            margin: 2px 0;
            font-size: 11px;
            color: #666;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .stat-card {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 8px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }
        .stat-number {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            display: block;
        }
        .stat-label {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
            margin-top: 3px;
        }
        .filters {
            background-color: #e9f7ff;
            padding: 8px;
            margin-bottom: 15px;
            border-left: 3px solid #007bff;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 9px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 9px;
            color: #333;
        }
        td {
            font-size: 8px;
            line-height: 1.2;
        }
        .badge {
            padding: 1px 4px;
            border-radius: 2px;
            color: white;
            font-size: 7px;
            font-weight: bold;
            display: inline-block;
        }
        .badge-success { background-color: #28a745; }
        .badge-danger { background-color: #dc3545; }
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-info { background-color: #17a2b8; }
        .badge-secondary { background-color: #6c757d; }
        .text-muted { color: #666; }
        .text-small { font-size: 7px; }
        .text-center { text-align: center; }
        .footer {
            position: fixed;
            bottom: 10mm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
        /* Optimización para caber más columnas */
        .col-exp { width: 8%; }
        .col-cuenta { width: 18%; }
        .col-programa { width: 8%; }
        .col-gerencia { width: 10%; }
        .col-estado { width: 7%; }
        .col-resultado { width: 7%; }
        .col-usuario { width: 12%; }
        .col-fecha { width: 8%; }
        .col-audiencias { width: 10%; }
        .col-tipo { width: 12%; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            @if(Auth::user()->empresa && Auth::user()->empresa->config && Auth::user()->empresa->config->logo)
                <img src="{{ public_path('assets/uploads/logos/' . Auth::user()->empresa->config->logo) }}" 
                     alt="Logo" class="logo">
            @endif
        </div>
        <div class="header-center">
            <div class="company-info">
                <h1>RESUMEN DE EXPEDIENTES</h1>
                <p><strong>{{ Auth::user()->empresa->nombre ?? 'BUROSOFT' }}</strong></p>
                <p>Generado el: {{ date('d/m/Y H:i') }}</p>
            </div>
        </div>
        <div class="header-right">
            <p class="text-small">Total de registros: {{ $expedientes->count() }}</p>
            <p class="text-small">Página generada por BuroSoft</p>
        </div>
    </div>

    <!-- Estadísticas resumen -->
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-number">{{ number_format($estadisticas['total_expedientes']) }}</span>
            <div class="stat-label">Total Expedientes</div>
        </div>
        <div class="stat-card">
            <span class="stat-number">{{ number_format($estadisticas['expedientes_activos']) }}</span>
            <div class="stat-label">Activos</div>
        </div>
        <div class="stat-card">
            <span class="stat-number">{{ number_format($estadisticas['expedientes_cerrados']) }}</span>
            <div class="stat-label">Cerrados</div>
        </div>
        <div class="stat-card">
            <span class="stat-number">{{ number_format($estadisticas['expedientes_archivo']) }}</span>
            <div class="stat-label">Archivo</div>
        </div>
    </div>

    <!-- Filtros aplicados -->
    @if($filtroEstado !== 'todos' || $filtroFecha || $filtroFechaHasta || $filtroCuenta || $filtroNoExpediente)
    <div class="filters">
        <strong>Filtros aplicados:</strong>
        @if($filtroEstado !== 'todos')
            <span>Estado: {{ ucfirst($filtroEstado) }}</span>
        @endif
        @if($filtroFecha)
            <span>Desde: {{ $filtroFecha }}</span>
        @endif
        @if($filtroFechaHasta)
            <span>Hasta: {{ $filtroFechaHasta }}</span>
        @endif
        @if($filtroCuenta)
            <span>Cuenta seleccionada</span>
        @endif
        @if($filtroNoExpediente)
            <span>Expediente: {{ $filtroNoExpediente }}</span>
        @endif
    </div>
    @endif

    <!-- Tabla de expedientes optimizada para horizontal -->
    @if($expedientes->count() > 0)
        <table>
            <thead>
                <tr>
                    <th class="col-exp">No. Expediente</th>
                    <th class="col-cuenta">Cuenta / Cliente</th>
                    <th class="col-programa">No. Programa</th>
                    <th class="col-gerencia">Gerencia</th>
                    <th class="col-tipo">Tipo Contribuyente</th>
                    <th class="col-estado">Estado</th>
                    <th class="col-resultado">Resultado</th>
                    <th class="col-usuario">Usuario</th>
                    <th class="col-fecha">Fecha</th>
                    <th class="col-audiencias">Audiencias</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expedientes as $expediente)
                <tr>
                    <td class="col-exp"><strong>{{ $expediente->no_expediente }}</strong></td>
                    <td class="col-cuenta">
                        <strong>{{ $expediente->cuenta->razon_social }}</strong>
                        <br><span class="text-small text-muted">{{ $expediente->cuenta->nit }}</span>
                    </td>
                    <td class="col-programa">{{ $expediente->no_programa }}</td>
                    <td class="col-gerencia">{{ $expediente->gerencia }}</td>
                    <td class="col-tipo text-small">{{ $expediente->tipo_contribuyente }}</td>
                    <td class="col-estado text-center">
                        @if($expediente->estado == 'Activo')
                            <span class="badge badge-success">{{ $expediente->estado }}</span>
                        @elseif($expediente->estado == 'Cerrado')
                            <span class="badge badge-danger">{{ $expediente->estado }}</span>
                        @elseif($expediente->estado == 'Archivo')
                            <span class="badge badge-warning">{{ $expediente->estado }}</span>
                        @else
                            <span class="badge badge-secondary">{{ $expediente->estado }}</span>
                        @endif
                    </td>
                    <td class="col-resultado text-center">
                        @if($expediente->resultado)
                            <span class="badge badge-info">{{ $expediente->resultado }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="col-usuario text-small">{{ $expediente->usuario->name ?? 'N/A' }}</td>
                    <td class="col-fecha text-small">{{ $expediente->created_at->format('d/m/Y') }}</td>
                    <td class="col-audiencias text-center text-small">
                        @if($expediente->audiencias->count() > 0)
                            VA: {{ $expediente->audiencias->count() }}
                        @endif
                        @if($expediente->audienciasPa->count() > 0)
                            @if($expediente->audiencias->count() > 0)<br>@endif
                            PA: {{ $expediente->audienciasPa->count() }}
                        @endif
                        @if($expediente->audiencias->count() == 0 && $expediente->audienciasPa->count() == 0)
                            <span class="text-muted">0</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 40px; color: #666;">
            <h3>No se encontraron expedientes</h3>
            <p>No hay expedientes que coincidan con los filtros aplicados.</p>
        </div>
    @endif

    <div class="footer">
        Reporte generado por BuroSoft - {{ date('d/m/Y H:i:s') }} - 
        Usuario: {{ Auth::user()->name }} - 
        Empresa: {{ Auth::user()->empresa->nombre ?? 'BUROSOFT' }}
    </div>

</body>
</html>