<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use App\Http\Requests\StoretransaksiRequest;
use App\Http\Requests\UpdatetransaksiRequest;
use App\Models\product;
use App\Models\tblCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
     {
        $best= product::where('quantity_out','>=',5)->get();
        $data = product::paginate(5);
        $countKeranjang = tblCart::count();
        return view('pelanggan.page.home',[
            'title'    => 'Home', 
            'data'     => $data,
            'best'     => $best,
            'count'     => $countKeranjang,
        ]); 
     }

     public function addTocart(Request $request)
     {
        $idProduct = request->input('idProduct');
        
        $db = new tblCart;
        $product = product::find($idProduct);
        $field = [
            'idUser' => 'guest123',
            'id_barang' => $idProduct,
            'qty' => 1,
            'price' => $product->harga,

        ];
        $db::create($field);
        Alert::toast('Keranjang berhasil ditambah', 'info');
        return redirect('/');
     }
}