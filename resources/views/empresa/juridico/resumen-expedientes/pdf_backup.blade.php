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
                <img src="{{ public_path('uploads/' . Auth::user()->empresa->config->logo) }}" 
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
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 11px;
        }
        td {
            font-size: 10px;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            color: white;
            font-size: 9px;
        }
        .badge-success { background-color: #28a745; }
        .badge-danger { background-color: #dc3545; }
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-info { background-color: #17a2b8; }
        .badge-secondary { background-color: #6c757d; }
        .text-muted { color: #666; }
        .page-break { page-break-before: always; }
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RESUMEN DE EXPEDIENTES</h1>
        <p>{{ Auth::user()->empresa->nombre ?? 'BUROSOFT' }}</p>
        <p>Generado el: {{ date('d/m/Y H:i') }}</p>
    </div>

    <!-- Filtros aplicados -->
    @if($filtroEstado !== 'todos' || $filtroFecha || $filtroFechaHasta)
    <div class="filters">
        <strong>Filtros aplicados:</strong>
        @if($filtroEstado !== 'todos')
            Estado: {{ ucfirst($filtroEstado) }}
        @endif
        @if($filtroFecha)
            | Desde: {{ date('d/m/Y', strtotime($filtroFecha)) }}
        @endif
        @if($filtroFechaHasta)
            | Hasta: {{ date('d/m/Y', strtotime($filtroFechaHasta)) }}
        @endif
    </div>
    @endif

    <!-- Estadísticas generales -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ number_format($estadisticas['total_expedientes']) }}</div>
            <div class="stat-label">Total Expedientes</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ number_format($estadisticas['expedientes_activos']) }}</div>
            <div class="stat-label">Activos</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ number_format($estadisticas['expedientes_cerrados']) }}</div>
            <div class="stat-label">Cerrados</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ number_format($estadisticas['expedientes_archivo']) }}</div>
            <div class="stat-label">Archivo</div>
        </div>
    </div>

    <!-- Tabla de expedientes -->
    <h3>Listado de Expedientes ({{ $expedientes->count() }} registros)</h3>
    
    @if($expedientes->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>No. Expediente</th>
                    <th>Cliente</th>
                    <th>No. Programa</th>
                    <th>Gerencia</th>
                    <th>Estado</th>
                    <th>Resultado</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Audiencias</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expedientes as $expediente)
                <tr>
                    <td><strong>{{ $expediente->no_expediente }}</strong></td>
                    <td>
                        {{ $expediente->cuenta->razon_social }}
                        <br><small class="text-muted">{{ $expediente->cuenta->codigo }}</small>
                    </td>
                    <td>{{ $expediente->no_programa }}</td>
                    <td>{{ $expediente->gerencia }}</td>
                    <td>
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
                    <td>
                        @if($expediente->resultado)
                            <span class="badge badge-info">{{ $expediente->resultado }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $expediente->usuario->name ?? 'N/A' }}</td>
                    <td>{{ $expediente->created_at->format('d/m/Y') }}</td>
                    <td>
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
        <p class="text-muted">No se encontraron expedientes con los filtros aplicados.</p>
    @endif

    <!-- Resumen por resultado (si hay datos) -->
    @if(!empty($estadisticas['expedientes_por_resultado']) && count($estadisticas['expedientes_por_resultado']) > 0)
    <div class="page-break">
        <h3>Resumen por Resultado</h3>
        <table>
            <thead>
                <tr>
                    <th>Resultado</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($estadisticas['expedientes_por_resultado'] as $resultado => $cantidad)
                <tr>
                    <td>
                        @if($resultado)
                            {{ $resultado }}
                        @else
                            Sin resultado
                        @endif
                    </td>
                    <td><strong>{{ number_format($cantidad) }}</strong></td>
                    <td>
                        {{ $estadisticas['total_expedientes'] > 0 ? number_format(($cantidad / $estadisticas['total_expedientes']) * 100, 1) : 0 }}%
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        <p>BUROSOFT - Sistema de Gestión Jurídica | Página {PAGENO} de {nb}</p>
    </div>
</body>
</html>