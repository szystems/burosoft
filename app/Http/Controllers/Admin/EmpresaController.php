<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Config;
use App\Http\Requests\EmpresaFormRequest;
use Illuminate\Support\Facades\File;
use DB;
use PDF;
use App\Exports\EmpresasExport;
use Maatwebsite\Excel\Facades\Excel;
class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $queryEmpresa=$request->input('fempresa');
            $empresas = DB::table('empresas')
            ->where('estado', '=', 1)
            ->where(function ($query) use ($queryEmpresa) {
            $query->where('nombre', 'LIKE', '%' . $queryEmpresa . '%')
                ->orWhere('email', 'LIKE', '%' . $queryEmpresa . '%')
                ->orWhere('telefono', 'LIKE', '%' . $queryEmpresa . '%')
                ->orWhere('celular', 'LIKE', '%' . $queryEmpresa . '%');
            })
            ->orderBy('fecha_vencimiento','asc')
            ->paginate(20);
            $filterEmpresas = Empresa::all();
            return view('admin.empresa.index', compact('empresas','queryEmpresa','filterEmpresas'));
        }
    }

    public function show($id)
    {
        $empresa = Empresa::find($id);
        $config = Config::where('empresa_id', $empresa->id)->first();
        return view('admin.empresa.show', compact('empresa', 'config'));
    }

    public function add()
    {
        return view('admin.empresa.add');
    }

    public function insert(EmpresaFormRequest $request)
    {
        $empresa = new Empresa();
        $fecha_vencimiento = $request->get('fecha_vencimiento');
        $fecha_vencimiento = date("Y-m-d", strtotime($fecha_vencimiento));
        if($request->hasFile('fotografia'))
        {
            $file = $request->file('fotografia');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/empresas',$filename);
            $empresa->fotografia = $filename;
        }
        $empresa->nombre = $request->input('nombre');
        $empresa->direccion = $request->input('direccion');
        $empresa->telefono = $request->input('telefono');
        $empresa->celular = $request->input('celular');
        $empresa->email = $request->input('email');
        $empresa->descripcion = $request->input('descripcion');
        $empresa->fecha_vencimiento = $fecha_vencimiento;
        $empresa->estado = 1;
        $empresa->save();

        $config = new Config();
        $config->empresa_id = $empresa->id;
        $config->currency = 'GTQ Q';
        $config->currency_iso = 'GTQ';
        $config->currency_simbol = 'Q';
        $config->gracia = $request->input('gracia');
        $config->save();

        // return redirect('empresas')->with('status', __('Empresa agregada exitosamente.'));
        return redirect('show-empresa/'.$empresa->id)->with('status',__('Empresa agregada exitosamente.'));
    }

    public function edit($id)
    {
        $config = Config::where('empresa_id', $id)->first();
        $empresa = Empresa::find($id);
        return view('admin.empresa.edit', \compact('empresa', 'config'));
    }

    public function update(EmpresaFormRequest $request, $id)
    {
        $empresa = Empresa::find($id);
        $fecha_vencimiento = $request->get('fecha_vencimiento');
        $fecha_vencimiento = date("Y-m-d", strtotime($fecha_vencimiento));
        if($request->hasFile('fotografia'))
        {
            $path = 'assets/uploads/empresas/'.$empresa->fotografia;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('fotografia');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/empresas',$filename);
            $empresa->fotografia = $filename;
        }
        $empresa->nombre = $request->input('nombre');
        $empresa->direccion = $request->input('direccion');
        $empresa->telefono = $request->input('telefono');
        $empresa->celular = $request->input('celular');
        $empresa->email = $request->input('email');
        $empresa->descripcion = $request->input('descripcion');
        $empresa->fecha_vencimiento = $fecha_vencimiento;
        $empresa->update();

        $config = Config::where('empresa_id', $empresa->id)->first();
        $config->gracia = $request->input('gracia');
        $config->update();

        return redirect('show-empresa/'.$id)->with('status',__('Empresa actualizada correctamente.'));

    }

    public function destroy($id)
    {
        $empresa = Empresa::find($id);
        $empresa->estado = 0;
        $empresa->update();
        return redirect('empresas')->with('status',__('Empresa eliminada correctamente.'));
    }

    public function pdf(Request $request)
    {
        if ($request)
        {

            $empresas = Empresa::where('estado',1)->orderBy('nombre','asc')->get();
            $verpdf = "Browser";
            $nompdf = date('m/d/Y g:ia');
            $path = public_path('assets/uploads/');

            $config = Config::first();

            $currency = $config->currency_simbol;

            if ($config->logo == null)
            {
                $logo = null;
                $imagen = null;
            }
            else
            {
                    $logo = $config->logo;
                    $imagen = public_path('assets/uploads/logos/'.$logo);
            }


            $config = Config::first();

            if ( $verpdf == "Download" )
            {
                $pdf = PDF::loadView('admin.empresa.pdf',['empresas'=>$empresas,'path'=>$path,'config'=>$config,'imagen'=>$imagen,'currency'=>$currency]);

                return $pdf->download ('Empresas: '.$nompdf.'.pdf');
            }
            if ( $verpdf == "Browser" )
            {
                $pdf = PDF::loadView('admin.empresa.pdf',['empresas'=>$empresas,'path'=>$path,'config'=>$config,'imagen'=>$imagen,'currency'=>$currency]);

                return $pdf->stream ('Empresas: '.$nompdf.'.pdf');
            }
        }
    }

    public function exportexcel(Request $request)
    {
        return Excel::download(new EmpresasExport, 'users.xlsx');
    }
}
