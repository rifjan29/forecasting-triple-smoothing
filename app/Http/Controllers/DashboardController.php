<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $totalBarang = Barang::count();
        // $totalPenjualan = Transaksi::where('kategori', 'Penjualan')->where('id_barang', '')->count();
        // $totalProfit = Transaksi::where('kategori', 'Profit')->count();
        // $totalPurchaseOrder = Transaksi::where('kategori', 'Purchase Order')->count();

        $barang = Transaksi::select(
                            'id_barang',
                            'barang.nama AS name',
                        )
                        ->join('barang', 'transaksi.id_barang', 'barang.id')
                        ->groupBy('id_barang')
                        ->groupBy('nama')
                        ->get();
        $data_barang = Transaksi::select(
                            'id_barang',
                            'barang.nama AS name',
                        )
                        ->join('barang', 'transaksi.id_barang', 'barang.id')
                        ->groupBy('id_barang')
                        ->groupBy('nama')
                        ->get();
        foreach($barang as $item) {
            $penjualan = Transaksi::select(\DB::raw('SUM(total_harga) AS total'))
                                    ->where('kategori', 'Penjualan')
                                    ->where('id_barang', $item->id_barang)
                                    ->first();
            $penjualan = $penjualan->total ? $penjualan->total : 0;

            $po = Transaksi::select(\DB::raw('SUM(total_harga) AS total'))
                                    ->where('kategori', 'Purchase Order')
                                    ->where('id_barang', $item->id_barang)
                                    ->first();
            $po = $po->total ? $po->total : 0;

            $profit = Transaksi::select(\DB::raw('SUM(total_harga) AS total'))
                                    ->where('kategori', 'Profit')
                                    ->where('id_barang', $item->id_barang)
                                    ->first();
            $profit = $profit->total ? $profit->total : 0;

            $item->data = [$penjualan, $po, $profit];
        }

        $kategori = Transaksi::select('kategori')->groupBy('kategori')->pluck('kategori');

        $this->param['id_barang'] = Barang::all();

        $data = [
            'kategori' => $kategori,
            // 'barang' => json_encode($barang),
            'barang' => $barang,
            'totalBarang' => $totalBarang,
        ];
        // return $data;

        return view('dashboard')->with($data)->with('data_barang',$data_barang);
    }

    public function TotalPenjualan(Request $request) {
        $total = Transaksi::where('kategori', 'Penjualan')->where('id_barang', $request->totalPo)->count();
        return response()->json($total);
    }

    public function TotalProfit(Request $request) {
        $total = Transaksi::where('kategori', 'Profit')->where('id_barang', $request->totalPo)->count();
        return response()->json($total);
    }

    public function TotalPurchaseOrder(Request $request) {
        $total = Transaksi::where('kategori', 'Purchase Order')->where('id_barang', $request->totalPo)->count();
        return response()->json($total);
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
        //
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
