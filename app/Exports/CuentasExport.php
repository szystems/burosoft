<?php

namespace App\Exports;

use App\Models\Cuenta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\Auth;

class CuentasExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cuenta::where('empresa_id', Auth::user()->empresa_id)->orderBy('razon_social','asc')->get();
    }
}
