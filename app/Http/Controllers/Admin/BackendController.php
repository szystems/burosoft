<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use App\Models\Config;
use App\Models\Empresa;
use DB;

class BackendController extends Controller
{
    public function index()
    {
        $config = Config::where('empresa_id', 1)->first();
        // $empresa = Empresa::find(Auth::user()->empresa_id);
        // dd($empresa);
        return view('admin.index', compact('config'));
    }
}
