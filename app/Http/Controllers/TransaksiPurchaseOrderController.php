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
        $transaksiPurchaseOrder = Transaksi::where('kategori','=','Purchase Order')
                                            ->orderBy('tahun', 'ASC')
                                            ->orderBy('bulan', 'ASC')
                                            ->get();
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

        $barangSudahAda = Transaksi::where('kategori',$kategori)
                                ->where('bulan', $month)
                                ->where('tahun', $year)
                                ->where('id_barang',$request->id_barang)
                                ->first();

        $penjualanSudahAda = Transaksi::where('kategori','Penjualan')
                                    ->where('bulan', $month)
                                    ->where('tahun', $year)
                                    ->where('id_barang',$request->id_barang)
                                    ->first();

        $qtyFormat = (int)$request->qty;
        $qtyKurang = Transaksi::where('kategori','Penjualan')
                            ->where('bulan', $month)
                            ->where('tahun', $year)
                            ->where('id_barang',$request->id_barang)
                            ->where('qty','<=',$qtyFormat)
                            ->first();

        $hargaBeli = (int)$request->harga;
        $hargaLebih = Transaksi::where('kategori','Penjualan')
                            ->where('bulan', $month)
                            ->where('tahun', $year)
                            ->where('id_barang',$request->id_barang)
                            ->where('harga','>=',$hargaBeli)
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

                if($penjualanSudahAda) {

                    if($qtyKurang) {

                        if(!$hargaLebih) {
                            return back()->withError('Barang '.$nama .' wajib diisi dengan harga kurang dari harga Penjualan atau lebih kecil dari Rp. '.number_format($hargaLebih->harga, 2, ',', '.'));
                        } else {
                            if($profitExists) {
                                $profitExists->harga = $penjualanSudahAda->harga-$request->harga;
                                $profitExists->total_harga = $profitExists->harga*$profitExists->qty;
                                $profitExists->kategori = 'Profit';

                                $profitExists->save();

                            } else {
                                $newTransaksiProfit = new Transaksi;
                                $newTransaksiProfit->id_barang = $id_barang;
                                $newTransaksiProfit->qty = $request->qty;
                                $newTransaksiProfit->harga = $penjualanSudahAda->harga-$request->harga;
                                $newTransaksiProfit->total_harga = $newTransaksiProfit->harga*$newTransaksiProfit->qty;
                                $newTransaksiProfit->bulan = $month;
                                $newTransaksiProfit->tahun = $year;
                                $newTransaksiProfit->kategori = 'Profit';

                                $newTransaksiProfit->save();
                            }

                            $newTransaksiPurchaseOrder = new Transaksi;
                            $newTransaksiPurchaseOrder->id_barang = $id_barang;
                            $newTransaksiPurchaseOrder->qty = $request->qty;
                            $newTransaksiPurchaseOrder->harga = $request->harga;
                            $newTransaksiPurchaseOrder->total_harga = $request->total_harga;
                            $newTransaksiPurchaseOrder->bulan = $month;
                            $newTransaksiPurchaseOrder->tahun = $year;
                            $newTransaksiPurchaseOrder->kategori = $kategori;

                            $newTransaksiPurchaseOrder->save();
                        }
                    } else {
                        return back()->withError('Barang '.$nama .' wajib di isi dengan qty diatas '.$penjualanSudahAda->qty.' atau sama dengan Penjualan sebanyak '.$penjualanSudahAda->qty);
                    }
                }
                else{

                    $newTransaksiPurchaseOrder = new Transaksi;
                    $newTransaksiPurchaseOrder->id_barang = $id_barang;
                    $newTransaksiPurchaseOrder->qty = $request->qty;
                    $newTransaksiPurchaseOrder->harga = $request->harga;
                    $newTransaksiPurchaseOrder->total_harga = $request->total_harga;
                    $newTransaksiPurchaseOrder->bulan = $month;
                    $newTransaksiPurchaseOrder->tahun = $year;
                    $newTransaksiPurchaseOrder->kategori = $kategori;

                    $newTransaksiPurchaseOrder->save();

                    if(!$profitExists) {
                        $newTransaksiProfit = new Transaksi;
                        $newTransaksiProfit->id_barang = $id_barang;
                        $newTransaksiProfit->qty = $request->qty;
                        $newTransaksiProfit->harga = $request->harga;
                        $newTransaksiProfit->total_harga = $newTransaksiProfit->harga*$newTransaksiProfit->qty;
                        $newTransaksiProfit->bulan = $month;
                        $newTransaksiProfit->tahun = $year;
                        $newTransaksiProfit->kategori = 'Profit';

                        $newTransaksiProfit->save();
                    } else {
                        $profitExists->id_barang = $id_barang;
                        $profitExists->qty = $request->qty;
                        $profitExists->harga = $request->harga-$penjualanSudahAda->harga;
                        $profitExists->bulan = $month;
                        $profitExists->tahun = $year;
                        $profitExists->total_harga = $profitExists->harga*$profitExists->qty;
                        $profitExists->kategori = 'Profit';

                        $profitExists->save();
                    }

                }

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
            $updateTransaksiProfit = Transaksi::where('kategori','Profit')
                                            ->where('bulan', $updateTransaksiPurchaseOrder->bulan)
                                            ->where('tahun', $updateTransaksiPurchaseOrder->tahun)
                                            ->where('id_barang',$updateTransaksiPurchaseOrder->id_barang)
                                            ->first();

            $penjualanSudahAda = Transaksi::where('kategori','Penjualan')
                                            ->where('bulan', $updateTransaksiPurchaseOrder->bulan)
                                            ->where('tahun', $updateTransaksiPurchaseOrder->tahun)
                                            ->where('id_barang',$updateTransaksiPurchaseOrder->id_barang)
                                            ->first();

            $qtyFormat = (int)$request->qty;
            $qtyKurang = Transaksi::where('kategori','Penjualan')
                                ->where('bulan', $updateTransaksiPurchaseOrder->bulan)
                                ->where('tahun', $updateTransaksiPurchaseOrder->tahun)
                                ->where('id_barang',$updateTransaksiPurchaseOrder->id_barang)
                                ->where('qty','<=',$qtyFormat)
                                ->first();

            $hargaBeli = (int)$request->harga;
            $hargaLebih = Transaksi::where('kategori','Penjualan')
                                    ->where('bulan', $updateTransaksiPurchaseOrder->bulan)
                                    ->where('tahun', $updateTransaksiPurchaseOrder->tahun)
                                    ->where('id_barang',$updateTransaksiPurchaseOrder->id_barang)
                                    ->where('harga','>=',$hargaBeli)
                                    ->first();

            $profitExists = Transaksi::where('kategori','Profit')
                    ->where('id_barang', $id_barang)
                    ->where('bulan', $month)
                    ->where('tahun', $year)
                    ->first();

            if ($id_barang != $updateTransaksiPurchaseOrder->id_barang) {
                $exists = Transaksi::where('kategori','Purchase Order')
                                ->where('id_barang', $id_barang)
                                ->where('bulan', $month)
                                ->where('tahun', $year)
                                ->first();
                if ($exists)
                    return back()->withError('Terdapat barang pada bulan '.$month.' tahun '.$year);
                else {
                    $updateTransaksiPurchaseOrder->id_barang = $id_barang;

                    if(!$profitExists) {
                        $updateTransaksiProfit->id_barang = $id_barang;

                        $penjualanBaru = Transaksi::where('kategori','Penjualan')
                                            ->where('bulan', $month)
                                            ->where('tahun', $year)
                                            ->where('id_barang',$id_barang)
                                            ->first();

                        if ($penjualanSudahAda) {
                            $updateTransaksiProfit->harga = $request->harga;
                            $updateTransaksiProfit->total_harga = $request->qty*$updateTransaksiProfit->harga;

                        } if($penjualanBaru) {
                            $updateTransaksiProfit->harga = $request->harga-$penjualanBaru->harga;
                            $updateTransaksiProfit->total_harga = $request->qty*$updateTransaksiProfit->harga;
                        }
                    }
                }
            } if ($request->qty != $updateTransaksiPurchaseOrder->qty) {
                if($penjualanSudahAda) {
                    if(!$qtyKurang) {
                        return back()->withError('Barang '.$nama .' wajib di isi dengan qty diatas atau lebih dari sama dengan Penjualan sebanyak '.$penjualanSudahAda->qty);
                    } else {
                        $updateTransaksiPurchaseOrder->qty = $request->qty;
                        $updateTransaksiProfit->qty = $request->qty;
                    }
                } else {
                    $updateTransaksiPurchaseOrder->qty = $request->qty;
                    $updateTransaksiProfit->qty = $request->qty;
                }

            } if ($request->harga != $updateTransaksiPurchaseOrder->harga) {
                if($penjualanSudahAda) {
                    if(!$hargaLebih){
                        return back()->withError('Barang '.$nama .' wajib diisi dengan harga kurang dari harga Penjualan atau lebih kecil dari Rp. '.number_format($hargaLebih->harga, 2, ',', '.'));
                    } else {
                        $updateTransaksiPurchaseOrder->harga = $request->harga;
                        $updateTransaksiProfit->harga = $request->harga-$penjualanSudahAda->harga;
                    }
                } else {
                    $updateTransaksiPurchaseOrder->harga = $request->harga;
                    $updateTransaksiProfit->harga = $request->harga;
                }

            } if ($request->total_harga != $updateTransaksiPurchaseOrder->total_harga) {
                $updateTransaksiPurchaseOrder->total_harga = $request->total_harga;
                $updateTransaksiProfit->total_harga = $request->qty*$updateTransaksiProfit->harga;
            } if ($month != $updateTransaksiPurchaseOrder->bulan || $year != $updateTransaksiPurchaseOrder->tahun) {
                $exists = Transaksi::where('id_barang', $id_barang)
                                    ->where('kategori', 'Purchase Order')
                                    ->where('bulan', $month)
                                    ->where('tahun', $year)
                                    ->first();
                if ($exists)
                    return back()->withError('Terdapat barang pada bulan '.$month.' tahun '.$year);
                else {
                    $updateTransaksiPurchaseOrder->bulan = $month;
                    $updateTransaksiPurchaseOrder->tahun = $year;
                    $updateTransaksiProfit->bulan = $month;
                    $updateTransaksiProfit->tahun = $year;
                }
            }

            $updateTransaksiPurchaseOrder->save();
            $updateTransaksiProfit->save();

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
            $deleteTransaksiPurchaseOrder = Transaksi::find($id);

            $updateFromPenjualan = Transaksi::where('kategori','Penjualan')
                                            ->where('bulan', $deleteTransaksiPurchaseOrder->bulan)
                                            ->where('tahun', $deleteTransaksiPurchaseOrder->tahun)
                                            ->where('id_barang',$deleteTransaksiPurchaseOrder->id_barang)
                                            ->first();

            $deleteTransaksiProfit = Transaksi::where('kategori','Profit')
                                                ->where('bulan', $deleteTransaksiPurchaseOrder->bulan)
                                                ->where('tahun', $deleteTransaksiPurchaseOrder->tahun)
                                                ->where('id_barang',$deleteTransaksiPurchaseOrder->id_barang)
                                                ->first();

            if($updateFromPenjualan) {
                $deleteTransaksiProfit->id_barang = $updateFromPenjualan->id_barang;
                $deleteTransaksiProfit->qty = $updateFromPenjualan->qty;
                $deleteTransaksiProfit->harga = -$updateFromPenjualan->harga;
                $deleteTransaksiProfit->total_harga = -$updateFromPenjualan->total_harga;
                $deleteTransaksiProfit->bulan = $updateFromPenjualan->bulan;
                $deleteTransaksiProfit->tahun = $updateFromPenjualan->tahun;
                $deleteTransaksiProfit->kategori = 'Profit';

                $deleteTransaksiProfit->save();
            } else {
                $deleteTransaksiProfit->delete();
            }

            $deleteTransaksiPurchaseOrder->delete();
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
