<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//frontend
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\SubscriptionController;

//admin
use App\Http\Controllers\Admin\BackendController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsuarioEmpresaController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\SubsController;
use App\Http\Controllers\Admin\EmpresaController;


//empresa
use App\Http\Controllers\Empresa\ConfigEmpresaController;
use App\Http\Controllers\Empresa\EmpresaDashboardController;
use App\Http\Controllers\Empresa\EmpresaInfoController;
use App\Http\Controllers\Empresa\EmpresaUsuarioController;
use App\Http\Controllers\Empresa\CuentaController;
use App\Http\Controllers\Empresa\RubroController;
use App\Http\Controllers\Empresa\MovimientoController;
use App\Http\Controllers\Empresa\MovimientoDocumentoController;
use App\Http\Controllers\Empresa\MovimientoPagoController;
use App\Http\Controllers\Empresa\RsiController;
use App\Http\Controllers\Empresa\ExpcasoController;
use App\Http\Controllers\Empresa\PatController;
use App\Http\Controllers\Empresa\PatNombramientoController;
use App\Http\Controllers\Empresa\PatNotificacionController;
use App\Http\Controllers\Empresa\PatRequerimientoController;
use App\Http\Controllers\Empresa\PatAtencionRequerimientoController;
use App\Http\Controllers\Empresa\PatProvidenciaController;
use App\Http\Controllers\Empresa\PatRafController;
use App\Http\Controllers\Empresa\PatActaAdministrativaController;
use App\Http\Controllers\Empresa\PatExpedienteController;
use App\Http\Controllers\Empresa\PatNulidadController;
use App\Http\Controllers\Empresa\PatRctController;
use App\Http\Controllers\Empresa\VaController;
use App\Http\Controllers\Empresa\PaController;
use App\Http\Controllers\Empresa\AudienciaController;
use App\Http\Controllers\Empresa\AudienciaPaController;
use App\Http\Controllers\Empresa\EvPaController;
use App\Http\Controllers\Empresa\PpPaController;
use App\Http\Controllers\Empresa\DpmrPaController;
use App\Http\Controllers\Empresa\AdpmrPaController;
use App\Http\Controllers\Empresa\AmpmrPaController;
use App\Http\Controllers\Empresa\MpmrPaController;
use App\Http\Controllers\Empresa\AceptacionController;
use App\Http\Controllers\Empresa\AceptacionPaController;
use App\Http\Controllers\Empresa\ConstanciaPagoController;
use App\Http\Controllers\Empresa\EcPaController;
use App\Http\Controllers\Empresa\NtrrPaController;
use App\Http\Controllers\Empresa\NulidadPaController;
use App\Http\Controllers\Empresa\OcursoPaController;
use App\Http\Controllers\Empresa\ResolucionPaController;
use App\Http\Controllers\Empresa\RoPaController;
use App\Http\Controllers\Empresa\RrPaController;
use App\Http\Controllers\Empresa\RtributaPaController;
use App\Http\Controllers\Empresa\EvController;
use App\Http\Controllers\Empresa\PpController;
use App\Http\Controllers\Empresa\DpmrController;
use App\Http\Controllers\Empresa\ResolucionController;
use App\Http\Controllers\Empresa\RtributaController;
use App\Http\Controllers\Empresa\NulidadController;
use App\Http\Controllers\Empresa\EcController;
use App\Http\Controllers\Empresa\RrController;
use App\Http\Controllers\Empresa\BitacoraController;
use App\Http\Controllers\Empresa\ResumenExpedientesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//Shop Views
Route::get('/', [FrontendController::class, 'index']);

//vistas
Route::get('about', [FrontendController::class, 'about']);
Route::get('subscribe', [FrontendController::class, 'subscribe']);
Route::get('contact', [FrontendController::class, 'contact']);
Route::post('send-contact', [FrontendController::class, 'sendcontact']);

Auth::routes();

 Route::get('/home', [FrontendController::class, 'index'])->name('home');

//User Dashbord
Route::middleware(['auth'])->group(function () {

    //dashboard
    Route::get('empresa-dashboard',[EmpresaDashboardController::class, 'index']);

    //Empresa Info
    Route::get('show-empresa-info/{id}', [EmpresaInfoController::class, 'show']);
    Route::get('edit-empresa-info/{id}',[EmpresaInfoController::class,'edit']);
    Route::put('update-empresa-info/{id}', [EmpresaInfoController::class, 'update']);

    //Usuarios Empresa
    Route::get('empresa-usuarios', [EmpresaUsuarioController::class, 'usuarios']);
    Route::get('show-empresa-usuario/{id}', [EmpresaUsuarioController::class, 'showusuario']);
    Route::get('edit-empresa-usuario/{id}',[EmpresaUsuarioController::class,'editusuario']);
    Route::put('update-empresa-usuario/{id}', [EmpresaUsuarioController::class, 'updateusuario']);
    Route::get('add-empresa-usuario', [EmpresaUsuarioController::class, 'addusuario']);
    Route::post('insert-empresa-usuario', [EmpresaUsuarioController::class, 'insertusuario']);
    Route::get('delete-empresa-usuario/{id}', [EmpresaUsuarioController::class, 'destroyusuario']);

    //Cuentas Empresa
    Route::get('cuentas', [CuentaController::class, 'index']);
    Route::get('show-cuenta/{id}', [CuentaController::class, 'show']);
    Route::get('edit-cuenta/{id}',[CuentaController::class,'edit']);
    Route::put('update-cuenta/{id}', [CuentaController::class, 'update']);
    Route::get('add-cuenta', [CuentaController::class, 'add']);
    Route::post('insert-cuenta', [CuentaController::class, 'insert']);
    Route::get('delete-cuenta/{id}', [CuentaController::class, 'destroy']);
    Route::get('activate-cuenta/{id}', [CuentaController::class, 'activate']);
    Route::get('pdf-cuentas', [CuentaController::class, 'pdf']);
    Route::get('exportcuentas', [CuentaController::class, 'exportexcel']);

    //Movimientos Empresa
    Route::get('movimientos', [MovimientoController::class, 'index']);
    Route::get('show-movimiento/{id}', [MovimientoController::class, 'show']);
    Route::get('edit-movimiento/{id}',[MovimientoController::class,'edit']);
    Route::put('update-movimiento/{id}', [MovimientoController::class, 'update']);
    Route::get('add-movimiento', [MovimientoController::class, 'add']);
    Route::post('insert-movimiento', [MovimientoController::class, 'insert']);
    Route::get('delete-movimiento/{id}', [MovimientoController::class, 'destroy']);
    Route::get('pdf-movimientos', [MovimientoController::class, 'pdfmovimientos']);
    Route::get('pdf-movimiento', [MovimientoController::class, 'pdfmovimiento']);
    Route::get('pdf-movimiento-cabecera/{id}', [MovimientoController::class, 'pdfmovimientocabecera']);
    Route::get('exportmovimientos', [MovimientoController::class, 'exportexcel']);
    Route::get('pdf-estadisticas-movimientos', [App\Http\Controllers\Empresa\MovimientoController::class, 'pdfestadisticas']);

    //Movimiento Documentos
    Route::post('insert-documento', [MovimientoDocumentoController::class, 'insert']);
    Route::put('update-documento/{id}', [MovimientoDocumentoController::class, 'update']);
    Route::get('delete-documento/{id}', [MovimientoDocumentoController::class, 'destroy']);

    //Movimiento Pagos
    Route::post('insert-pago', [MovimientoPagoController::class, 'insert']);
    Route::put('update-pago/{id}', [MovimientoPagoController::class, 'update']);
    Route::get('delete-pago/{id}', [MovimientoPagoController::class, 'destroy']);
    Route::get('delete-img-pago/{id}', [MovimientoPagoController::class, 'destroyimg']);
    Route::get('pdf-pago/{id}', [MovimientoPagoController::class, 'pdfpago']);

    //RSI
    Route::get('rsi', [RsiController::class, 'index']);
    Route::get('pdf-rsi', [RsiController::class, 'pdfrsi']);
    Route::get('pdf-rsi-estadisticas', [App\Http\Controllers\Empresa\RsiController::class, 'pdfRsiEstadisticas'])->middleware(['auth']);

    //Exp/Caso
    Route::get('expcaso', [ExpcasoController::class, 'index']);
    Route::get('show-expcaso/{id}', [ExpcasoController::class, 'show']);
    //PAT
    Route::get('index-pat/{id}', [PatController::class, 'index']);
    Route::get('show-pat/{id}', [PatController::class, 'show']);
    Route::post('insert-pat', [PatController::class, 'insert']);
    Route::put('update-pat/{id}', [PatController::class, 'update']);
    Route::get('delete-pat/{id}', [PatController::class, 'destroy']);
    Route::get('pdf-pat', [PatController::class, 'pdf']);
    //PAT Nombramiento
    Route::post('insert-pat-nombramiento', [PatNombramientoController::class, 'insert']);
    Route::put('update-pat-nombramiento/{id}', [PatNombramientoController::class, 'update']);
    Route::get('delete-pat-nombramiento/{id}', [PatNombramientoController::class, 'destroy']);
    //PAT Notificacion
    Route::post('insert-pat-notificacion', [PatNotificacionController::class, 'insert']);
    Route::put('update-pat-notificacion/{id}', [PatNotificacionController::class, 'update']);
    Route::get('delete-pat-notificacion/{id}', [PatNotificacionController::class, 'destroy']);
    //PAT Requerimiento
    Route::post('insert-pat-requerimiento', [PatRequerimientoController::class, 'insert']);
    Route::put('update-pat-requerimiento/{id}', [PatRequerimientoController::class, 'update']);
    Route::get('delete-pat-requerimiento/{id}', [PatRequerimientoController::class, 'destroy']);
    //PAT Atencion de Requerimiento
    Route::post('insert-pat-atencionrequerimiento', [PatAtencionRequerimientoController::class, 'insert']);
    Route::put('update-pat-atencionrequerimiento/{id}', [PatAtencionRequerimientoController::class, 'update']);
    Route::get('delete-pat-atencionrequerimiento/{id}', [PatAtencionRequerimientoController::class, 'destroy']);
    //PAT Acta Administrativa
    Route::post('insert-pat-actaadministrativa', [PatActaAdministrativaController::class, 'insert']);
    Route::put('update-pat-actaadministrativa/{id}', [PatActaAdministrativaController::class, 'update']);
    Route::get('delete-pat-actaadministrativa/{id}', [PatActaAdministrativaController::class, 'destroy']);
    //PAT Expediente
    Route::post('insert-pat-expediente', [PatExpedienteController::class, 'insert']);
    Route::put('update-pat-expediente/{id}', [PatExpedienteController::class, 'update']);
    Route::get('delete-pat-expediente/{id}', [PatExpedienteController::class, 'destroy']);
    //PAT Providencia
    Route::post('insert-pat-providencia', [PatProvidenciaController::class, 'insert']);
    Route::put('update-pat-providencia/{id}', [PatProvidenciaController::class, 'update']);
    Route::get('delete-pat-providencia/{id}', [PatProvidenciaController::class, 'destroy']);
    //PAT Providencia de Urgencia (PRAF)
    Route::post('insert-pat-raf', [PatRafController::class, 'insert']);
    Route::put('update-pat-raf/{id}', [PatRafController::class, 'update']);
    Route::get('delete-pat-raf/{id}', [PatRafController::class, 'destroy']);
    //PAT Nulidades
    Route::post('insert-pat-nulidad', [PatNulidadController::class, 'insert']);
    Route::put('update-pat-nulidad/{id}', [PatNulidadController::class, 'update']);
    Route::get('delete-pat-nulidad/{id}', [PatNulidadController::class, 'destroy']);
    //PAT RCT (Resolución del Conflicto Tributario)
    Route::post('insert-pat-rct', [PatRctController::class, 'insert']);
    Route::put('update-pat-rct/{id}', [PatRctController::class, 'update']);
    Route::get('delete-pat-rct/{id}', [PatRctController::class, 'destroy']);

    //VA
    Route::get('show-va/{id}', [VaController::class, 'show']);
    Route::get('pdf-va', [VaController::class, 'pdf']);
    Route::get('show-audiencia/{id}', [VaController::class, 'showaudiencia']);

    //PA
    Route::get('show-pa/{id}', [PaController::class, 'show']);
    Route::get('show-audiencia-pa/{id}', [PaController::class, 'showaudiencia']);

    //Audiencias PA
    Route::post('insert-audiencia-pa', [AudienciaPaController::class, 'insert']);
    Route::put('update-audiencia-pa/{id}', [AudienciaPaController::class, 'update']);
    Route::get('delete-audiencia-pa/{id}', [AudienciaPaController::class, 'destroy']);
    Route::delete('delete-audiencia-pa/{id}', [AudienciaPaController::class, 'destroy']);

    //Ev PA
    Route::post('insert-ev-pa', [EvPaController::class, 'insert']);
    Route::put('update-ev-pa/{id}', [EvPaController::class, 'update']);
    Route::get('delete-ev-pa/{id}', [EvPaController::class, 'destroy']);
    Route::delete('delete-ev-pa/{id}', [EvPaController::class, 'destroy']);

    //PP PA
    Route::post('insert-pp-pa', [PpPaController::class, 'insert']);
    Route::put('update-pp-pa/{id}', [PpPaController::class, 'update']);
    Route::get('delete-pp-pa/{id}', [PpPaController::class, 'destroy']);
    Route::delete('delete-pp-pa/{id}', [PpPaController::class, 'destroy']);

    // Rutas DPMR PA
    Route::post('insert-dpmr-pa', [DpmrPaController::class, 'insert'])->name('insert.dpmr.pa');
    Route::put('update-dpmr-pa/{id}', [DpmrPaController::class, 'update'])->name('update.dpmr.pa');
    Route::delete('delete-dpmr-pa/{id}', [DpmrPaController::class, 'destroy'])->name('delete.dpmr.pa');

    // Rutas ADPMR PA
    Route::post('insert-adpmr-pa', [AdpmrPaController::class, 'insert'])->name('insert.adpmr.pa');
    Route::put('update-adpmr-pa/{id}', [AdpmrPaController::class, 'update'])->name('update.adpmr.pa');
    Route::delete('delete-adpmr-pa/{id}', [AdpmrPaController::class, 'destroy'])->name('delete.adpmr.pa');

    // Rutas AMPMR PA
    Route::post('insert-ampmr-pa', [AmpmrPaController::class, 'insert'])->name('insert.ampmr.pa');
    Route::put('update-ampmr-pa/{id}', [AmpmrPaController::class, 'update'])->name('update.ampmr.pa');
    Route::delete('delete-ampmr-pa/{id}', [AmpmrPaController::class, 'destroy'])->name('delete.ampmr.pa');

    // Rutas Aceptación PA
    Route::post('insert-aceptacion-pa', [AceptacionPaController::class, 'insert'])->name('insert.aceptacion.pa');
    Route::put('update-aceptacion-pa/{id}', [AceptacionPaController::class, 'update'])->name('update.aceptacion.pa');
    Route::delete('delete-aceptacion-pa/{id}', [AceptacionPaController::class, 'destroy'])->name('delete.aceptacion.pa');

    // Rutas MPMR PA
    Route::post('insert-mpmr-pa', [MpmrPaController::class, 'insert'])->name('insert.mpmr.pa');
    Route::put('update-mpmr-pa/{id}', [MpmrPaController::class, 'update'])->name('update.mpmr.pa');
    Route::delete('delete-mpmr-pa/{id}', [MpmrPaController::class, 'destroy'])->name('delete.mpmr.pa');

    // Rutas EC PA
    Route::post('insert-ec-pa', [EcPaController::class, 'insert'])->name('insert.ec.pa');
    Route::put('update-ec-pa/{id}', [EcPaController::class, 'update'])->name('update.ec.pa');
    Route::delete('delete-ec-pa/{id}', [EcPaController::class, 'destroy'])->name('delete.ec.pa');

    // Rutas NTRR PA
    Route::post('insert-ntrr-pa', [NtrrPaController::class, 'insert'])->name('insert.ntrr.pa');
    Route::put('update-ntrr-pa/{id}', [NtrrPaController::class, 'update'])->name('update.ntrr.pa');
    Route::delete('delete-ntrr-pa/{id}', [NtrrPaController::class, 'destroy'])->name('delete.ntrr.pa');

    // Rutas Nulidad PA
    Route::post('insert-nulidad-pa', [NulidadPaController::class, 'insert'])->name('insert.nulidad.pa');
    Route::put('update-nulidad-pa/{id}', [NulidadPaController::class, 'update'])->name('update.nulidad.pa');
    Route::delete('delete-nulidad-pa/{id}', [NulidadPaController::class, 'destroy'])->name('delete.nulidad.pa');

    // Rutas Ocurso PA
    Route::post('insert-ocurso-pa', [OcursoPaController::class, 'insert'])->name('insert.ocurso.pa');
    Route::put('update-ocurso-pa/{id}', [OcursoPaController::class, 'update'])->name('update.ocurso.pa');
    Route::delete('delete-ocurso-pa/{id}', [OcursoPaController::class, 'destroy'])->name('delete.ocurso.pa');

    // Rutas Resolución PA
    Route::post('insert-resolucion-pa', [ResolucionPaController::class, 'insert'])->name('insert.resolucion.pa');
    Route::put('update-resolucion-pa/{id}', [ResolucionPaController::class, 'update'])->name('update.resolucion.pa');
    Route::delete('delete-resolucion-pa/{id}', [ResolucionPaController::class, 'destroy'])->name('delete.resolucion.pa');

    // Rutas RO PA
    Route::post('insert-ro-pa', [RoPaController::class, 'insert'])->name('insert.ro.pa');
    Route::put('update-ro-pa/{id}', [RoPaController::class, 'update'])->name('update.ro.pa');
    Route::delete('delete-ro-pa/{id}', [RoPaController::class, 'destroy'])->name('delete.ro.pa');

    // Rutas RR PA
    Route::post('insert-rr-pa', [RrPaController::class, 'insert'])->name('insert.rr.pa');
    Route::put('update-rr-pa/{id}', [RrPaController::class, 'update'])->name('update.rr.pa');
    Route::delete('delete-rr-pa/{id}', [RrPaController::class, 'destroy'])->name('delete.rr.pa');

    // Rutas Rtributa PA
    Route::post('insert-rtributa-pa', [RtributaPaController::class, 'insert'])->name('insert.rtributa.pa');
    Route::put('update-rtributa-pa/{id}', [RtributaPaController::class, 'update'])->name('update.rtributa.pa');
    Route::delete('delete-rtributa-pa/{id}', [RtributaPaController::class, 'destroy'])->name('delete.rtributa.pa');

    //Audiencias
    Route::post('insert-audiencia', [AudienciaController::class, 'insert']);
    Route::put('update-audiencia/{id}', [AudienciaController::class, 'update']);
    Route::get('delete-audiencia/{id}', [AudienciaController::class, 'destroy']);
    Route::delete('delete-audiencia/{id}', [AudienciaController::class, 'destroy']);

    //Ev
    Route::post('insert-ev', [EvController::class, 'insert']);
    Route::put('update-ev/{id}', [EvController::class, 'update']);
    Route::get('delete-ev/{id}', [EvController::class, 'destroy']);
    Route::delete('delete-ev/{id}', [EvController::class, 'destroy']);

    //Pp
    Route::post('insert-pp', [PpController::class, 'insert']);
    Route::put('update-pp/{id}', [PpController::class, 'update']);
    Route::get('delete-pp/{id}', [PpController::class, 'destroy']);
    Route::delete('delete-pp/{id}', [PpController::class, 'destroy']);

    //Dpmr
    Route::post('insert-dpmr', [DpmrController::class, 'insert']);
    Route::put('update-dpmr/{id}', [DpmrController::class, 'update']);
    Route::get('delete-dpmr/{id}', [DpmrController::class, 'destroy']);
    Route::delete('delete-dpmr/{id}', [DpmrController::class, 'destroy']);

    //Resolucion
    Route::post('insert-resolucion', [ResolucionController::class, 'insert']);
    Route::put('update-resolucion/{id}', [ResolucionController::class, 'update']);
    Route::get('delete-resolucion/{id}', [ResolucionController::class, 'destroy']);
    Route::delete('delete-resolucion/{id}', [ResolucionController::class, 'destroy']);

    //R-Tributa
    Route::post('insert-rtributa', [RtributaController::class, 'insert']);
    Route::put('update-rtributa/{id}', [RtributaController::class, 'update']);
    Route::get('delete-rtributa/{id}', [RtributaController::class, 'destroy']);
    Route::delete('delete-rtributa/{id}', [RtributaController::class, 'destroy']);

    //Rr
    Route::post('insert-rr', [RrController::class, 'insert']);
    Route::put('update-rr/{id}', [RrController::class, 'update']);
    Route::get('delete-rr/{id}', [RrController::class, 'destroy']);
    Route::delete('delete-rr/{id}', [RrController::class, 'destroy']);

    //Usuarios Empresa
    Route::get('bitacoras', [BitacoraController::class, 'index']);

    //Resumen de Expedientes
    Route::get('resumen-expedientes', [ResumenExpedientesController::class, 'index']);
    Route::get('resumen-expedientes/estadisticas', [ResumenExpedientesController::class, 'estadisticas']);
    Route::get('resumen-expedientes/exportar-pdf', [ResumenExpedientesController::class, 'exportarPdf']);
    Route::get('resumen-expedientes/exportar-excel', [ResumenExpedientesController::class, 'exportarExcel']);
    Route::get('show-bitacora/{id}', [BitacoraController::class, 'show']);

    //Financiero Rubros
    Route::get('rubros', [RubroController::class, 'index']);
    Route::get('show-rubro/{id}', [RubroController::class, 'show']);
    Route::get('edit-rubro/{id}',[RubroController::class,'edit']);
    Route::put('update-rubro/{id}', [RubroController::class, 'update']);
    Route::get('add-rubro', [RubroController::class, 'add']);
    Route::post('insert-rubro', [RubroController::class, 'insert']);
    Route::get('delete-rubro/{id}', [RubroController::class, 'destroy']);

    //config Empresa
    Route::get('empresa-config', [ConfigEmpresaController::class, 'index']);
    Route::put('empresa-update-config', [ConfigEmpresaController::class, 'update']);

    // Rutas para ADPMR
    Route::post('insert-adpmr', [App\Http\Controllers\Empresa\AdpmrController::class, 'insert'])->name('insert-adpmr');
    Route::put('update-adpmr/{id}', [App\Http\Controllers\Empresa\AdpmrController::class, 'update'])->name('update-adpmr');
    Route::delete('delete-adpmr/{id}', [App\Http\Controllers\Empresa\AdpmrController::class, 'destroy'])->name('delete-adpmr');

    // Rutas para NTRR
    Route::post('insert-ntrr', [App\Http\Controllers\Empresa\NtrrController::class, 'insert'])->name('insert-ntrr');
    Route::put('update-ntrr/{id}', [App\Http\Controllers\Empresa\NtrrController::class, 'update'])->name('update-ntrr');
    Route::delete('delete-ntrr/{id}', [App\Http\Controllers\Empresa\NtrrController::class, 'destroy'])->name('delete-ntrr');

    // Rutas para Ocurso
    Route::post('insert-ocurso', [App\Http\Controllers\Empresa\OcursoController::class, 'insert'])->name('insert-ocurso');
    Route::put('update-ocurso/{id}', [App\Http\Controllers\Empresa\OcursoController::class, 'update'])->name('update-ocurso');
    Route::delete('delete-ocurso/{id}', [App\Http\Controllers\Empresa\OcursoController::class, 'destroy'])->name('delete-ocurso');

    // Rutas para Resolución de Ocurso
    Route::post('insert-ro', [App\Http\Controllers\Empresa\RoController::class, 'insert'])->name('insert-ro');
    Route::put('update-ro/{id}', [App\Http\Controllers\Empresa\RoController::class, 'update'])->name('update-ro');
    Route::delete('delete-ro/{id}', [App\Http\Controllers\Empresa\RoController::class, 'destroy'])->name('delete-ro');

    // Rutas para Medidas Para Mejor Resolver
    Route::post('insert-mpmr', [App\Http\Controllers\Empresa\MpmrController::class, 'insert'])->name('insert-mpmr');
    Route::put('update-mpmr/{id}', [App\Http\Controllers\Empresa\MpmrController::class, 'update'])->name('update-mpmr');
    Route::delete('delete-mpmr/{id}', [App\Http\Controllers\Empresa\MpmrController::class, 'destroy'])->name('delete-mpmr');

    // Rutas para Atención Medidas Para Mejor Resolver
    Route::post('insert-ampmr', [App\Http\Controllers\Empresa\AmpmrController::class, 'insert'])->name('insert-ampmr');
    Route::put('update-ampmr/{id}', [App\Http\Controllers\Empresa\AmpmrController::class, 'update'])->name('update-ampmr');
    Route::delete('delete-ampmr/{id}', [App\Http\Controllers\Empresa\AmpmrController::class, 'destroy'])->name('delete-ampmr');

    // Rutas para Aceptación
    Route::post('insert-aceptacion', [AceptacionController::class, 'insert'])->name('insert-aceptacion');
    Route::put('update-aceptacion/{id}', [AceptacionController::class, 'update'])->name('update-aceptacion');
    Route::delete('delete-aceptacion/{id}', [AceptacionController::class, 'destroy'])->name('delete-aceptacion');

    // Rutas para Constancia de Pago
    Route::post('insert-constancia-pago', [ConstanciaPagoController::class, 'insert'])->name('insert-constancia-pago');
    Route::put('update-constancia-pago/{id}', [ConstanciaPagoController::class, 'update'])->name('update-constancia-pago');
    Route::delete('delete-constancia-pago/{id}', [ConstanciaPagoController::class, 'destroy'])->name('delete-constancia-pago');

    // Rutas para Nulidad
    Route::post('insert-nulidad', [NulidadController::class, 'insert'])->name('insert-nulidad');
    Route::put('update-nulidad/{id}', [NulidadController::class, 'update'])->name('update-nulidad');
    Route::delete('delete-nulidad/{id}', [NulidadController::class, 'destroy'])->name('delete-nulidad');

    // Rutas para EC (Económico Coactivo)
    Route::post('insert-ec', [EcController::class, 'insert'])->name('insert-ec');
    Route::put('update-ec/{id}', [EcController::class, 'update'])->name('update-ec');
    Route::delete('delete-ec/{id}', [EcController::class, 'destroy'])->name('delete-ec');

    // Rutas para EC (Económico Coactivo)
    Route::post('insert-ec', [EcController::class, 'insert'])->name('insert-ec');
    Route::put('update-ec/{id}', [EcController::class, 'update'])->name('update-ec');
    Route::delete('delete-ec/{id}', [EcController::class, 'destroy'])->name('delete-ec');

    //User FrontEnd
    // Route::get('my-account', [UserController::class, 'indexuser']);
    // Route::get('user-details/{id}', [UserController::class, 'showuser']);
    // Route::get('user-edit/{id}', [UserController::class, 'edituser']);
    // Route::put('user-update/{id}', [UserController::class, 'updateuser']);
    // Route::get('user-subscription/{id}', [UserController::class, 'showsubscription']);

    // //Payments
    // Route::get('checkout', [FrontendController::class, 'checkout'])->name('checkout');
    // Route::post('/payments/pay', [PaymentController::class, 'pay'])->name('pay');
    // Route::get('/payments/approval', [PaymentController::class, 'approval'])->name('approval');
    // Route::get('/payments/cancelled', [PaymentController::class, 'cancelled'])->name('cancelled');

    // //suscripciones
    // Route::post('update-status', [PaymentController::class, 'updatestatussub']);
    // Route::post('cancel-subscription', [PaymentController::class, 'cancelsub']);
    // Route::post('cancel-subscription-gratis', [PaymentController::class, 'cancelsubgratis']);

    // Route::prefix('subscribe')
    // ->name('subscribe.')
    // ->group(function() {
    //     Route::get('/', [SubscriptionController::class, 'show'])->name('show');
    //     Route::post('/', [SubscriptionController::class, 'store'])->name('store');
    //     Route::get('/approval', [SubscriptionController::class, 'approval'])->name('approval');
    //     Route::get('/cancelled', [SubscriptionController::class, 'cancelled'])->name('cancelled');

    // });

});

//Admin Dashboard
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard',[BackendController::class, 'index']);

    //Admin Users
    Route::get('users', [DashboardController::class, 'users']);
    Route::get('show-user/{id}', [DashboardController::class, 'showuser']);
    Route::get('add-user', [DashboardController::class, 'adduser']);
    Route::post('insert-user', [DashboardController::class, 'insertuser']);
    Route::get('edit-user/{id}',[DashboardController::class,'edituser']);
    Route::put('update-user/{id}', [DashboardController::class, 'updateuser']);
    Route::get('delete-user/{id}', [DashboardController::class, 'destroyuser']);
    Route::get('pdf-user', [DashboardController::class, 'pdf']);

    //Empresas
    Route::get('empresas', [EmpresaController::class, 'index']);
    Route::get('show-empresa/{id}', [EmpresaController::class, 'show']);
    Route::get('add-empresa', [EmpresaController::class, 'add']);
    Route::post('insert-empresa',[EmpresaController::class,'insert']);
    Route::get('edit-empresa/{id}',[EmpresaController::class,'edit']);
    Route::put('update-empresa/{id}', [EmpresaController::class, 'update']);
    Route::get('delete-empresa/{id}', [EmpresaController::class, 'destroy']);
    Route::get('pdf-empresas', [EmpresaController::class, 'pdf']);
    Route::get('exportempresas', [EmpresaController::class, 'exportexcel']);

    //Empresas Users
    Route::get('usuarios', [UsuarioEmpresaController::class, 'usuarios']);
    Route::get('show-usuario/{id}', [UsuarioEmpresaController::class, 'showusuario']);
    Route::get('add-usuario', [UsuarioEmpresaController::class, 'addusuario']);
    Route::post('insert-usuario', [UsuarioEmpresaController::class, 'insertusuario']);
    Route::get('edit-usuario/{id}',[UsuarioEmpresaController::class,'editusuario']);
    Route::put('update-usuario/{id}', [UsuarioEmpresaController::class, 'updateusuario']);
    Route::get('delete-usuario/{id}', [UsuarioEmpresaController::class, 'destroyusuario']);
    Route::get('pdf-usuario', [UsuarioEmpresaController::class, 'pdf']);

    // //Subscriptions
    // Route::get('index-subscriptions', [SubsController::class, 'index']);
    // Route::post('insert-subscription', [SubsController::class, 'insert']);
    // Route::put('update-subscription/{id}', [SubsController::class, 'update']);
    // Route::get('delete-subscription/{id}', [SubsController::class, 'destroy']);

    //config
    Route::get('config', [ConfigController::class, 'index']);
    Route::put('update-config', [ConfigController::class, 'update']);
    Route::put('update-licencias', [ConfigController::class, 'updatelicencias']);

 });

//  Route::fallback(function () {
//     return response()->view('frontend.404');
// });



