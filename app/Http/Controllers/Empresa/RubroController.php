<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rubro;
use App\Http\Requests\RubroFormRequest;
use App\Models\Bitacora;
use DB;
use Illuminate\Support\Facades\Auth;

class RubroController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $queryRubro=$request->input('frubro');
            $rubros = DB::table('rubros')
            ->where('empresa_id', Auth::user()->empresa_id)
            ->where('estado', 1)
            ->where('nombre', 'LIKE', '%' . $queryRubro . '%')
            ->orderBy('nombre','asc')
            ->paginate(20);
            $filterRubros = Rubro::where('empresa_id', Auth::user()->empresa_id)->get();
            return view('empresa.rubro.index', compact('rubros','queryRubro','filterRubros'));
        }
    }

    public function show($id)
    {
        $rubro = Rubro::find($id);
        return view('empresa.rubro.show', compact('rubro'));
    }

    public function add()
    {
        return view('empresa.rubro.add');
    }

    public function insert(RubroFormRequest $request)
    {
        $rubro = new Rubro();
        $rubro->empresa_id = Auth::user()->empresa_id;
        $rubro->nombre = $request->input('nombre');
        $rubro->descripcion = $request->input('descripcion');
        $rubro->save();

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Rubro",
            'descripcion' => "Creo un nuevo rubro: ".$rubro->nombre
        ]);

        // return redirect('show-rubro/'.$rubro->id)->with('status',__('Rubro agregado exitosamente.'));
        return redirect('add-rubro')->with('status',__('Rubro agregado exitosamente.'));
    }

    public function edit($id)
    {
        $rubro = Rubro::find($id);
        return view('empresa.rubro.edit', \compact('rubro'));
    }

    public function update(RubroFormRequest $request, $id)
    {
        $rubro = Rubro::find($id);
        $rubro->nombre = $request->input('nombre');
        $rubro->descripcion = $request->input('descripcion');
        $rubro->update();

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Rubro",
            'descripcion' => "Actualizó un rubro: ".$rubro->nombre
        ]);

        return redirect('show-rubro/'.$id)->with('status',__('Rubro actualizado correctamente.'));

    }

    public function destroy($id)
    {
        $rubro = Rubro::find($id);
        $nombre = $rubro->nombre;
        $rubro->estado = 0;
        $rubro->update();

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Rubro",
            'descripcion' => "Eliminó un rubro: ".$nombre
        ]);

        return redirect('rubros')->with('status',__('Rubro eliminado correctamente.'));
    }
}
