<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiPurchaseOrderController extends Controller
{
    private $param;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksiPurchaseOrder = Transaksi::where('kategori','=','Purchase Order')->get();
        return view('pages.transaksi-purchase-order.index')->with('purchaseOrder', $transaksiPurchaseOrder)->with('i',(request()->input('page',1)-1)*5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['subtitle'] = 'Tambah Transaksi Purchase Order';
        $this->param['top_button'] = route('purchase-order.index');
        $this->param['id_barang'] = Barang::all();
        $this->param['id_satuan'] = Satuan::all();

        return view('pages.transaksi-purchase-order.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kategori = 'Purchase Order';
        $date = explode('-', $request->month);
        $month = $date[1];
        $year = $date[0];
        $barang = explode('-', $request->id_barang);
        $id_barang = $barang[0];
        $nama = $barang[1];


        $request->validate(
            [
                'id_barang' => 'required|not_in:0',
                'month' => 'required',
                'qty' => 'required|numeric',
                'harga' => 'required|numeric',
                'total_harga' => 'required|numeric',
            ],
            [
                'required' => ':attribute harap diisi',
                'not_in' => ':attribute harus dipilih',
                'numeric' => ':attribute harap di isi dengan angka',
            ],
            [
                'id_barang' => 'Nama Barang',
                'month' => 'Bulan',
                'qty' => 'Qty',
                'harga' => 'Harga',
                'total_harga' => 'Total Harga',

            ]
        );

        try {
            $barangSudahAda = Transaksi::where('kategori',$kategori)->where('bulan', $month)->where('tahun', $year)->where('id_barang',$request->id_barang)->first();
            if($barangSudahAda) {
                return back()->withError('Barang '.$nama .' telah diinputkan pada bulan '.$month.' dan tahun '.$year);
            }
            else {
                $newTransaksiPurchaseOrder = new Transaksi;
                $newTransaksiPurchaseOrder->id_barang = $id_barang;
                $newTransaksiPurchaseOrder->qty = $request->qty;
                $newTransaksiPurchaseOrder->harga = $request->harga;
                $newTransaksiPurchaseOrder->total_harga = $request->total_harga;
                $newTransaksiPurchaseOrder->bulan = $month;
                $newTransaksiPurchaseOrder->tahun = $year;
                $newTransaksiPurchaseOrder->kategori = $kategori;

                $newTransaksiPurchaseOrder->save();

                return redirect('transaksi/purchase-order')->withStatus('Berhasil menyimpan data.');
            }

        }
        catch(\Exception $e){
            return back()->withError($e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return back()->withError($e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
        $this->param['id_barang'] = Barang::all();
        $this->param['id_satuan'] = Satuan::all();
        return view('pages.transaksi-purchase-order.index',$this->param);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_barang = Barang::all();
        $transaksi = Transaksi::find($id);

        return view('pages.transaksi-purchase-order.edit', compact('transaksi', 'id_barang'));
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
        $kategori = 'Purchase Order';
        $date = explode('-', $request->month);
        $month = $date[1];
        $year = $date[0];
        $barang = explode('-', $request->id_barang);
        $id_barang = $barang[0];
        $nama = $barang[1];

        $request->validate(
            [
                'id_barang' => 'required|not_in:0',
                'month' => 'required',
                'qty' => 'required|numeric',
                'harga' => 'required|numeric',
                'total_harga' => 'required|numeric',
            ],
            [
                'required' => ':attribute harap diisi',
                'not_in' => ':attribute harus dipilih',
                'numeric' => ':attribute harap di isi dengan angka',
            ],
            [
                'id_barang' => 'Nama Barang',
                'month' => 'Bulan',
                'qty' => 'Qty',
                'harga' => 'Harga',
                'total_harga' => 'Total Harga',

            ]
        );
            /*
            1. kondisi utama, check apakah data berubah
            2. kondisi kedua, barang != old barang dan date != old date. maka validasi uniq
            3. kondisi ketiga, date tetap sementara barang berubah
            4. kondisi keempat, barang tetap date berubah
            */
        try {
            $updateTransaksiPurchaseOrder = Transaksi::find($id);

            if ($id_barang != $updateTransaksiPurchaseOrder->id_barang) {
                $exists = Transaksi::where('id_barang', $id_barang)->where('bulan', $month)->where('tahun', $year)->first();
                if ($exists)
                    return back()->withError('Terdapat barang pada bulan '.$month.' tahun '.$year);
                else {
                    $updateTransaksiPurchaseOrder->id_barang = $id_barang;
                }
            } if ($request->qty != $updateTransaksiPurchaseOrder->qty) {
                $updateTransaksiPurchaseOrder->qty = $request->qty;
            } if ($request->harga != $updateTransaksiPurchaseOrder->harga) {
                $updateTransaksiPurchaseOrder->harga = $request->harga;
            } if ($request->total_harga != $updateTransaksiPurchaseOrder->total_harga) {
                $updateTransaksiPurchaseOrder->total_harga = $request->total_harga;
            } if ($month != $updateTransaksiPurchaseOrder->bulan || $year != $updateTransaksiPurchaseOrder->tahun) {
                $exists = Transaksi::where('id_barang', $id_barang)
                                    ->where('bulan', $month)
                                    ->where('tahun', $year)
                                    ->first();
                if ($exists)
                    return back()->withError('Terdapat barang pada bulan '.$month.' tahun '.$year);
                else {
                    $updateTransaksiPurchaseOrder->bulan = $month;
                    $updateTransaksiPurchaseOrder->tahun = $year;
                }
            }

            $updateTransaksiPurchaseOrder->save();

            return redirect('transaksi/purchase-order')->withSukses('Berhasil menyimpan data.');

        }
        catch(\Exception $e){
            return back()->withError($e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return back()->withError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
        {
         try {
            Transaksi::find($id)->delete();

            return redirect()->back()->withWarning('Berhasil menghapus data.');
        }
        catch(\Exception $e){
            return redirect()->back()->withError($e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
