<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Config;
use Illuminate\Support\Facades\File;
use DB;
use Auth;

class ConfigEmpresaController extends Controller
{
    public function index()
    {
        $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();
        return view('empresa.config.index', \compact('config'));
    }

    public function update(Request $request)
    {
        $currency = explode(' ',trim($request->input('currency')));
        $currency_iso = ucwords($currency[0]);
        $currency_simbol = ucwords($currency[1]);


        $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();
        if($request->hasFile('logo'))
        {
            $path = 'assets/uploads/logos/'.$config->logo;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('logo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/logos',$filename);
            $config->logo = $filename;
        }
        $config->currency = $request->input('currency');
        $config->currency_iso = $currency_iso;
        $config->currency_simbol = $currency_simbol;
        $config->update();

        return redirect('empresa-config')->with('status',__('Configuración actualizada Correctamente!'));
    }
}
