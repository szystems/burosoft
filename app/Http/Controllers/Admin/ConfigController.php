<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Config;
use Illuminate\Support\Facades\File;
use DB;

class ConfigController extends Controller
{
    public function index()
    {
        $config = Config::first();
        return view('admin.config.index', \compact('config'));
    }

    public function update(Request $request)
    {
        $currency = explode(' ',trim($request->input('currency')));
        $currency_iso = ucwords($currency[0]);
        $currency_simbol = ucwords($currency[1]);

        $config = Config::first();
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
        // if($request->hasFile('advertisement_image'))
        // {
        //     $path2 = 'assets/uploads/advertisements/'.$config->advertisement_image;
        //     if(File::exists($path2))
        //     {
        //         File::delete($path2);
        //     }
        //     $file2 = $request->file('advertisement_image');
        //     $ext2 = $file2->getClientOriginalExtension();
        //     $filename2 = time().'.'.$ext2;
        //     $file2->move('assets/uploads/advertisements',$filename2);
        //     $config->advertisement_image = $filename2;
        // }
        $config->currency = $request->input('currency');
        $config->currency_iso = $currency_iso;
        $config->currency_simbol = $currency_simbol;
        // $config->tax_status = $request->input('tax_status') == TRUE ? '1':'0';
        // $config->tax = $request->input('tax');
        // $config->paypal = $request->input('paypal') == TRUE ? '1':'0';
        // $config->dbt = $request->input('dbt') == TRUE ? '1':'0';
        // $config->shipping_description = $request->input('shipping_description');
        // $config->shipping = $request->input('shipping');
        $config->email = $request->input('email');
        // $config->store = $request->input('store') == TRUE ? '1':'0';
        // $config->shopify = $request->input('shopify') == TRUE ? '1':'0';
        // $config->shopify_link = $request->input('shopify_link');
        // $config->amazon = $request->input('amazon') == TRUE ? '1':'0';
        // $config->amazon_link = $request->input('amazon_link');
        // $config->advertisement = $request->input('advertisement') == TRUE ? '1':'0';
        // $config->advertisement_link = $request->input('advertisement_link');
        $config->update();

        $request->session()->flash('alert-success', __('Configuración actualizado correctamente'));

        return view('admin.config.index', \compact('config'));
    }
}
