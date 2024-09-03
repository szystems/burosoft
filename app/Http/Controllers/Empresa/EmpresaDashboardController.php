<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Config;
use DB;

class EmpresaDashboardController extends Controller
{
    public function index()
    {
        $config = $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();
        return view('empresa.index', compact('config'));
    }
}
