<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForecastingPurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->param['subtitle'] = 'Tambah Transaksi Purchase Order';
        $this->param['top_button'] = route('purchase-order.index');
        $this->param['id_barang'] = Barang::all();
        $this->param['id_satuan'] = Satuan::all();

        return view('pages.peramalan-purchase-order.index', $this->param);
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
        $forecasting = Transaksi::where('kategori','=','Purchase Order')
                                ->where('id_barang',$request->id_barang)
                                ->orderBy('tahun', 'ASC')
                                ->orderBy('bulan', 'ASC')
                                ->get();
        $data = [];
        foreach ($forecasting as $key => $value) {
            $d = [
                'periode' => $value->tahun.'-'.$value->bulan,
                'aktual' => (int)$value->total_harga,
                'smoothing pertama' => $key == 0 ? (int)$value->total_harga : 0,
                'smoothing kedua' => $key == 0 ? (int)$value->total_harga : 0,
                'at' =>  $key == 0 ? (int)$value->total_harga : 0,
                'bt' =>  $key,
                'peramalan' =>$key == 0 ? "" : "" ,
                'xtft' => $key == 0 ? "" : 0 ,

            ];
            array_push($data, $d);
        }

        $newData = [];
        $alpha = $request->alpha;
        $current_smoothing_pertama = 0;
        $current_smoothing_kedua = 0;
        $current_at = 0;
        $current_bt = 0;
        $mape = 0;
        $total_data = 0;
        $total_xtft = 0;
        $forecast = 0;
        $last_at = 0;
        $last_bt = 0;


        foreach ($data as $key => $value) {
            if ($key == 0) {
                $current_smoothing_pertama = (float)$value['smoothing pertama'];

                $current_smoothing_kedua = (float)$value['smoothing kedua'];

                $current_at = (float)$value['at'];

                $current_bt = (float)$value['bt'];

            }
            if ($key > 0) {
                $smoothing_pertama = $alpha * (int)$value['aktual'] + (1 - $alpha) * $current_smoothing_pertama;
                $data[$key]['smoothing pertama'] = $smoothing_pertama;
                $current_smoothing_pertama = $smoothing_pertama;

                $smoothing_kedua = $alpha * $data[$key]['smoothing pertama'] + (1 - $alpha) * $current_smoothing_kedua;
                $data[$key]['smoothing kedua'] = $smoothing_kedua;
                $current_smoothing_kedua = $smoothing_kedua;

                $at = (2 * $data[$key]['smoothing pertama']) - $data[$key]['smoothing kedua'];
                $data[$key]['at'] = $at;

                $bt = ( $alpha / (1-$alpha) ) * ($data[$key]['smoothing pertama'] - $data[$key]['smoothing kedua']);
                $data[$key]['bt'] = $bt;

                $peramalan = $current_at + $current_bt;
                $data[$key]['peramalan'] = $peramalan;
                $current_at = $at;
                $current_bt = $bt;

                if ($data[$key]['aktual']>0) {
                    $xtft = ((float)$data[$key]['peramalan'] - (float)$data[$key]['aktual']) / (float)$data[$key]['aktual'];
                    $data[$key]['xtft'] = abs($xtft);

                    $total_xtft += abs($xtft);
                    $total_data = count($data);
                    $mape = $total_xtft / $total_data * 100;
                }

                $last_at = end($data)['at'];
                $last_bt = end($data)['bt'];


                $last_periode = end($data)['periode'];
                $date = explode('-', $last_periode);
                $month = $date[1];
                $year = $date[0];

                $periode = $request->periode;
                $date = explode('-', $request->periode);
                $bulan = $date[1];
                $tahun = $date[0];

                $date1 = mktime(0,0,0,$month,0,$year); // m d y, use 0 for day
                $date2 = mktime(0,0,0,$bulan,0,$tahun); // m d y, use 0 for day

                $get_periode = round(($date2-$date1) / 60 / 60 / 24 / 30);

                $forecast = ((float)$last_at + (float)$last_bt) * $get_periode;
            }
        }
        return view('pages.peramalan-purchase-order.detail')
            ->with('data', $data)
            ->with('forecast', $forecast)
            ->with('mape', $mape)
            ->with('alpha', $alpha)
            ->with('periode', $periode)
            ->with('get_periode', $get_periode);
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
