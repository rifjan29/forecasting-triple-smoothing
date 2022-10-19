<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiProfitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all();
        foreach ($barang as $key => $value) {
            $penjualan = Transaksi::select(\DB::raw("SUM(total_harga) AS total"))
                                ->where('id_barang', $value->id)
                                ->where('kategori', 'Penjualan')
                                ->first();
            $pembelian = Transaksi::select(\DB::raw("SUM(total_harga) AS total"))
                                ->where('id_barang', $value->id)
                                ->where('kategori', 'Purchase Order')
                                ->first();
            $keuntungan = Transaksi::select(\DB::raw("SUM(total_harga) AS total"))
                                ->where('id_barang', $value->id)
                                ->where('kategori', 'Profit')
                                ->first();
            $value->total_penjualan = is_null($penjualan->total) ? 0 : $penjualan->total;
            $value->total_pembelian = is_null($pembelian->total) ? 0 : $pembelian->total;
            $value->total_keuntungan = is_null($keuntungan->total) ? 0 : $keuntungan->total;

        }

        // return $barang;
        return view('pages.transaksi-profit.index')->with('profit', $barang)->with('i',(request()->input('page',1)-1)*5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{

            $this->param['transaksi'] = Transaksi::where('kategori','Profit')->where('id_barang',$id)->get();

            $this->param['id_barang'] = Barang::all();

            $this->param['id_satuan'] = Satuan::all();

            return view('pages.transaksi-profit.detail',$this->param);
        }
        catch(\Exception $e){
            return redirect()->back()->withError('Mohon maaf data masih belum terisi');
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
