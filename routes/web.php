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

    //config Empresa
    Route::get('empresa-config', [ConfigEmpresaController::class, 'index']);
    Route::put('empresa-update-config', [ConfigEmpresaController::class, 'update']);


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

 });

 Route::fallback(function () {
    return response()->view('frontend.404');
});



