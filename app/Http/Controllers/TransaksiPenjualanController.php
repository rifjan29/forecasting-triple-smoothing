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
        $transaksiPenjualan = Transaksi::where('kategori','=','Penjualan')->get();
        return view('pages.transaksi-penjualan.index')->with('penjualan', $transaksiPenjualan)->with('i',(request()->input('page',1)-1)*5);
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
                $newTransaksiPenjualan = new Transaksi;
                $newTransaksiPenjualan->id_barang = $id_barang;
                $newTransaksiPenjualan->qty = $request->qty;
                $newTransaksiPenjualan->harga = $request->harga;
                $newTransaksiPenjualan->total_harga = $request->total_harga;
                $newTransaksiPenjualan->bulan = $month;
                $newTransaksiPenjualan->tahun = $year;
                $newTransaksiPenjualan->kategori = $kategori;

                $newTransaksiPenjualan->save();

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

            if ($id_barang != $updateTransaksiPenjualan->id_barang) {
                $exists = Transaksi::where('id_barang', $id_barang)->where('bulan', $month)->where('tahun', $year)->first();
                if ($exists)
                    return back()->withError('Terdapat barang pada bulan '.$month.' tahun '.$year);
                else {
                    $updateTransaksiPenjualan->id_barang = $id_barang;
                }
            } if ($request->qty != $updateTransaksiPenjualan->qty) {
                $updateTransaksiPenjualan->qty = $request->qty;
            } if ($request->harga != $updateTransaksiPenjualan->harga) {
                $updateTransaksiPenjualan->harga = $request->harga;
            } if ($request->total_harga != $updateTransaksiPenjualan->total_harga) {
                $updateTransaksiPenjualan->total_harga = $request->total_harga;
            } if ($month != $updateTransaksiPenjualan->bulan || $year != $updateTransaksiPenjualan->tahun) {
                $exists = Transaksi::where('id_barang', $id_barang)
                                    ->where('bulan', $month)
                                    ->where('tahun', $year)
                                    ->first();
                if ($exists)
                    return back()->withError('Terdapat barang pada bulan '.$month.' tahun '.$year);
                else {
                    $updateTransaksiPenjualan->bulan = $month;
                    $updateTransaksiPenjualan->tahun = $year;
                }
            }
            // if ($year != $updateTransaksiPenjualan->year) {
            //     $updateTransaksiPenjualan->tahun = $year;
            // }
            // $barangSudahAda = Transaksi::where('kategori',$kategori)->where('bulan', $month)->where('tahun', $year)->where('id_barang', $id_barang)->first();

            // if ($barangSudahAda) {
            //     if ($id_barang != $id) {
            //         // barang berubah
            //         $sudahAda = Transaksi::where('kategori',$kategori)
            //                                     ->where('bulan', $month)
            //                                     ->where('tahun', $year)
            //                                     ->where('id_barang', $id_barang)
            //                                     ->first();
            //         if ($sudahAda) {
            //             return back()->withError('Telah terdapat barang pada bulan '.$month.' dan tahun '.$year);
            //         }
            //         else {
            //             $updateTransaksiPenjualan->id_barang = $id_barang;
            //         }
            //     }
            //     elseif(($id_barang == $id && $month == $barangSudahAda->bulan && $year == $barangSudahAda->tahun) && $barangSudahAda) {
            //         if ($request->qty != $barangSudahAda->qty || $request->harga != $barangSudahAda->harga) {
            //             $updateTransaksiPenjualan->qty = $request->qty;
            //             $updateTransaksiPenjualan->harga = $request->harga;
            //         }
            //         else {
            //             return back()->withError('Telah terdapat barang pada bulan '.$month.' dan tahun '.$year);
            //         }
            //     }
            //     elseif ($month != $barangSudahAda->bulan || $year != $barangSudahAda->tahun || $id_barang != $id) {
            //         // bulan & tahun berubah
            //         $sudahAda = Transaksi::where('kategori',$kategori)
            //                                     ->where('bulan', $month)
            //                                     ->where('tahun', $year)
            //                                     ->first();
            //         if (!$sudahAda) {
            //             $updateTransaksiPenjualan->bulan = $month;
            //             $updateTransaksiPenjualan->tahun = $year;
            //             $updateTransaksiPenjualan->id_barang = $id_barang;
            //         }
            //     }
            //     else {
            //         $updateTransaksiPenjualan->qty = $request->qty;
            //         $updateTransaksiPenjualan->harga = $request->harga;
            //         $updateTransaksiPenjualan->total_harga = $request->total_harga;
            //         $updateTransaksiPenjualan->kategori = $kategori;
            //     }
            // }
            // else {
            //     return 'a';
            //     $updateTransaksiPenjualan->bulan = $month;
            //     $updateTransaksiPenjualan->tahun = $year;
            //     $updateTransaksiPenjualan->id_barang = $id_barang;
            //     $updateTransaksiPenjualan->qty = $request->qty;
            //     $updateTransaksiPenjualan->harga = $request->harga;
            //     $updateTransaksiPenjualan->total_harga = $request->total_harga;
            //     $updateTransaksiPenjualan->kategori = $kategori;
            // }



            $updateTransaksiPenjualan->save();

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
