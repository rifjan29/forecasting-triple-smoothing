<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiPenjualanController extends Controller
{
    private $param;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksiPenjualan = Transaksi::where('kategori','=','Penjualan')
                                        ->get();
        return view('pages.transaksi-penjualan.index')
            ->with('penjualan', $transaksiPenjualan)
            ->with('i',(request()
            ->input('page',1)-1)*5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['subtitle'] = 'Tambah Transaksi Penjualan';
        $this->param['top_button'] = route('penjualan.index');
        $this->param['id_barang'] = Barang::all();
        $this->param['id_satuan'] = Satuan::all();

        return view('pages.transaksi-penjualan.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kategori = 'Penjualan';
        $date = explode('-', $request->month);
        $month = $date[1];
        $year = $date[0];
        $barang = explode('-', $request->id_barang);
        $id_barang = $barang[0];
        $nama = $barang[1];

        $barangSudahAda = Transaksi::where('kategori',$kategori)
                                ->where('bulan', $month)
                                ->where('tahun', $year)
                                ->where('id_barang',$request->id_barang)
                                ->first();

        $purchaseOrderSudahAda = Transaksi::where('kategori','Purchase Order')
                                        ->where('bulan', $month)
                                        ->where('tahun', $year)
                                        ->where('id_barang',$request->id_barang)
                                        ->first();

        $qtyFormat = (int)$request->qty;
        $qtyLebih = Transaksi::where('kategori','Purchase Order')
                            ->where('bulan', $month)
                            ->where('tahun', $year)
                            ->where('id_barang',$request->id_barang)
                            ->where('qty','>=',$qtyFormat)
                            ->first();

        $hargaJual = (int)$request->harga;
        $hargaKurang = Transaksi::where('kategori','Purchase Order')
                                ->where('bulan', $month)
                                ->where('tahun', $year)
                                ->where('id_barang',$request->id_barang)
                                ->where('harga','<=',$hargaJual)
                                ->first();

        $profitExists = Transaksi::where('kategori','Profit')
                                ->where('id_barang', $request->id_barang)
                                ->where('bulan', $month)
                                ->where('tahun', $year)
                                ->first();

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

            if($barangSudahAda) {
                return back()->withError('Barang '.$nama .' telah diinputkan pada bulan '.$month.' dan tahun '.$year);
            }
            else {

                if($purchaseOrderSudahAda) {

                    if($qtyLebih) {

                        if(!$hargaKurang) {
                            return back()->withError('Barang '.$nama .' wajib diisi dengan harga lebih dari harga Purchase Order atau lebih besar dari Rp. '.number_format($hargaKurang->harga, 2, ',', '.'));
                        } else {

                            if($profitExists) {
                                $profitExists->qty = $request->qty;
                                $profitExists->harga = $hargaJual-$purchaseOrderSudahAda->harga;
                                $profitExists->total_harga = $profitExists->harga*$profitExists->qty;

                                $profitExists->save();
                            } else {
                                $newTransaksiProfit = new Transaksi;
                                $newTransaksiProfit->id_barang = $id_barang;
                                $newTransaksiProfit->qty = $request->qty;
                                $newTransaksiProfit->harga = $hargaJual-$purchaseOrderSudahAda->harga;
                                $newTransaksiProfit->total_harga = $newTransaksiProfit->harga*$newTransaksiProfit->qty;
                                $newTransaksiProfit->bulan = $month;
                                $newTransaksiProfit->tahun = $year;
                                $newTransaksiProfit->kategori = 'Profit';

                                $newTransaksiProfit->save();
                            }

                            $newTransaksiPenjualan = new Transaksi;
                            $newTransaksiPenjualan->id_barang = $id_barang;
                            $newTransaksiPenjualan->qty = $request->qty;
                            $newTransaksiPenjualan->harga = $request->harga;
                            $newTransaksiPenjualan->total_harga = $request->total_harga;
                            $newTransaksiPenjualan->bulan = $month;
                            $newTransaksiPenjualan->tahun = $year;
                            $newTransaksiPenjualan->kategori = $kategori;

                            $newTransaksiPenjualan->save();
                        }
                    } else {
                        return back()->withError('Barang '.$nama .' wajib di isi dengan qty dibawah '.$purchaseOrderSudahAda->qty.' atau sama dengan Purchase Order sebanyak '.$purchaseOrderSudahAda->qty);
                    }
                }
                else{

                    if($profitExists) {
                        $profitExists->qty = $request->qty;
                        $profitExists->harga = $hargaJual-$purchaseOrderSudahAda->harga;
                        $profitExists->total_harga = $profitExists->harga*$profitExists->qty;

                        $profitExists->save();
                    } else {
                        $newTransaksiProfit = new Transaksi;
                        $newTransaksiProfit->id_barang = $id_barang;
                        $newTransaksiProfit->qty = $request->qty;
                        $newTransaksiProfit->harga = -$request->harga;
                        $newTransaksiProfit->total_harga = $newTransaksiProfit->harga*$newTransaksiProfit->qty;
                        $newTransaksiProfit->bulan = $month;
                        $newTransaksiProfit->tahun = $year;
                        $newTransaksiProfit->kategori = 'Profit';

                        $newTransaksiProfit->save();
                    }

                    $newTransaksiPenjualan = new Transaksi;
                    $newTransaksiPenjualan->id_barang = $id_barang;
                    $newTransaksiPenjualan->qty = $request->qty;
                    $newTransaksiPenjualan->harga = $request->harga;
                    $newTransaksiPenjualan->total_harga = $request->total_harga;
                    $newTransaksiPenjualan->bulan = $month;
                    $newTransaksiPenjualan->tahun = $year;
                    $newTransaksiPenjualan->kategori = $kategori;

                    $newTransaksiPenjualan->save();

                }

                return redirect('transaksi/penjualan')->withStatus('Berhasil menyimpan data.');
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
        return view('pages.transaksi-penjualan.index',$this->param);
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

        return view('pages.transaksi-penjualan.edit', compact('transaksi', 'id_barang'));
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
        $kategori = 'Penjualan';
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
            $updateTransaksiPenjualan = Transaksi::find($id);

            $updateTransaksiProfit = Transaksi::where('kategori','Profit')
                                            ->where('bulan', $updateTransaksiPenjualan->bulan)
                                            ->where('tahun', $updateTransaksiPenjualan->tahun)
                                            ->where('id_barang',$updateTransaksiPenjualan->id_barang)
                                            ->first();

            $purchaseOrderSudahAda = Transaksi::where('kategori','Purchase Order')
                                            ->where('bulan', $updateTransaksiPenjualan->bulan)
                                            ->where('tahun', $updateTransaksiPenjualan->tahun)
                                            ->where('id_barang',$updateTransaksiPenjualan->id_barang)
                                            ->first();

            $qtyFormatUpdate = (int)$request->qty;
            $qtyLebih = Transaksi::where('kategori','Purchase Order')
                                ->where('bulan', $updateTransaksiPenjualan->bulan)
                                ->where('tahun', $updateTransaksiPenjualan->tahun)
                                ->where('id_barang',$updateTransaksiPenjualan->id_barang)
                                ->where('qty','>=',$qtyFormatUpdate)
                                ->first();

            $hargaJualUpdate = (int)$request->harga;
            $hargaKurang = Transaksi::where('kategori','Purchase Order')
                                    ->where('bulan', $updateTransaksiPenjualan->bulan)
                                    ->where('tahun', $updateTransaksiPenjualan->tahun)
                                    ->where('id_barang',$updateTransaksiPenjualan->id_barang)
                                    ->where('harga','<=',$hargaJualUpdate)
                                    ->first();

            $profitExists = Transaksi::where('kategori','Profit')
                                    ->where('id_barang', $id_barang)
                                    ->where('bulan', $month)
                                    ->where('tahun', $year)
                                    ->first();

            if ($id_barang != $updateTransaksiPenjualan->id_barang) {
                $exists = Transaksi::where('kategori','Penjualan')
                                ->where('id_barang', $id_barang)
                                ->where('bulan', $month)
                                ->where('tahun', $year)
                                ->first();
                if ($exists)
                    return back()->withError('Terdapat barang pada bulan '.$month.' tahun '.$year);
                else {
                    $updateTransaksiPenjualan->id_barang = $id_barang;

                    if(!$profitExists) {
                        $updateTransaksiProfit->id_barang = $id_barang;

                        $purchaseOrderBaru = Transaksi::where('kategori','Purchase Order')
                                            ->where('bulan', $month)
                                            ->where('tahun', $year)
                                            ->where('id_barang',$id_barang)
                                            ->first();

                        if ($purchaseOrderSudahAda) {
                            $updateTransaksiProfit->harga = -$request->harga;
                            $updateTransaksiProfit->total_harga = $request->qty*$updateTransaksiProfit->harga;

                        } if($purchaseOrderBaru) {
                            $updateTransaksiProfit->harga = $request->harga-$purchaseOrderBaru->harga;
                            $updateTransaksiProfit->total_harga = $request->qty*$updateTransaksiProfit->harga;
                        }
                    }
                }
            } if ($request->qty != $updateTransaksiPenjualan->qty) {
                if(!$qtyLebih) {
                    return back()->withError('Barang '.$nama .' wajib di isi dengan qty dibawah atau sama dengan Purchase Order sebanyak '.$purchaseOrderSudahAda->qty);
                }
                else{
                    $updateTransaksiPenjualan->qty = $request->qty;
                    $updateTransaksiProfit->qty = $request->qty;
                }
            } if ($request->harga != $updateTransaksiPenjualan->harga) {
                if(!$hargaKurang){
                    return back()->withError('Barang '.$nama .' wajib diisi dengan harga lebih dari harga Purchase Order atau lebih besar dari Rp. '.number_format($hargaKurang->harga, 2, ',', '.'));
                } else{
                    $updateTransaksiPenjualan->harga = $request->harga;
                    $updateTransaksiProfit->harga = $request->harga-$purchaseOrderSudahAda->harga;
                }
            } if ($request->total_harga != $updateTransaksiPenjualan->total_harga) {
                $updateTransaksiPenjualan->total_harga = $request->total_harga;
                $updateTransaksiProfit->total_harga = $request->qty*$updateTransaksiProfit->harga;
            } if ($month != $updateTransaksiPenjualan->bulan || $year != $updateTransaksiPenjualan->tahun) {
                $exists = Transaksi::where('id_barang', $id_barang)
                                    ->where('kategori', 'Penjualan')
                                    ->where('bulan', $month)
                                    ->where('tahun', $year)
                                    ->first();
                if ($exists)
                    return back()->withError('Terdapat barang pada bulan '.$month.' tahun '.$year);
                else {
                    $updateTransaksiPenjualan->bulan = $month;
                    $updateTransaksiPenjualan->tahun = $year;
                    $updateTransaksiProfit->bulan = $month;
                    $updateTransaksiProfit->tahun = $year;
                }
            }

            $updateTransaksiPenjualan->save();
            $updateTransaksiProfit->save();

            return redirect('transaksi/penjualan')->withSukses('Berhasil menyimpan data.');

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
            $deleteTransaksiPenjualan = Transaksi::find($id);

            $updateFromPurchaseOrder = Transaksi::where('kategori','Purchase Order')
                                            ->where('bulan', $deleteTransaksiPenjualan->bulan)
                                            ->where('tahun', $deleteTransaksiPenjualan->tahun)
                                            ->where('id_barang',$deleteTransaksiPenjualan->id_barang)
                                            ->first();

            $deleteTransaksiProfit = Transaksi::where('kategori','Profit')
                                            ->where('bulan', $deleteTransaksiPenjualan->bulan)
                                            ->where('tahun', $deleteTransaksiPenjualan->tahun)
                                            ->where('id_barang',$deleteTransaksiPenjualan->id_barang)
                                            ->first();

            if($updateFromPurchaseOrder) {
                $deleteTransaksiProfit->id_barang = $updateFromPurchaseOrder->id_barang;
                $deleteTransaksiProfit->qty = $updateFromPurchaseOrder->qty;
                $deleteTransaksiProfit->harga = $updateFromPurchaseOrder->harga;
                $deleteTransaksiProfit->total_harga = $updateFromPurchaseOrder->total_harga;
                $deleteTransaksiProfit->bulan = $updateFromPurchaseOrder->bulan;
                $deleteTransaksiProfit->tahun = $updateFromPurchaseOrder->tahun;
                $deleteTransaksiProfit->kategori = 'Profit';

                $deleteTransaksiProfit->save();
            } else {
                $deleteTransaksiProfit->delete();
            }

            $deleteTransaksiPenjualan->delete();
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
