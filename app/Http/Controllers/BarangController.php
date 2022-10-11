<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all();
        // return $barang;
        return view('pages.barang.index')->with('barang', $barang)->with('i',(request()->input('page',1)-1)*5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['subtitle'] = 'Tambah Barang';
        $this->param['top_button'] = route('barang.index');
        $this->param['id_satuan'] = Satuan::all();

        return view('pages.barang.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'nama' => 'required',
                'id_satuan' => 'required|not_in:0'
            ],
            [
                'required' => ':attribute harap diisi',
                'min' => ':attribute tidak boleh lebih dari 15 karakter',
                'not_in' => ':attribute harus dipilih'
            ],
            [
                'nama' => 'Nama Barang',
                'id_satuan' => 'Satuan'
            ]
        );

        try {
            $newBarang = new Barang;
            $newBarang->nama = $request->nama;
            $newBarang->id_satuan = $request->id_satuan;

            $newBarang->save();

            return redirect('master/barang')->withStatus('Berhasil menyimpan data.');
        }
        catch(\Exception $e){
            return redirect()->back()->withError($e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError($e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        $this->param['id_satuan'] = Satuan::all();
        return view('pages.barang.index',compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_satuan = Satuan::all();
        $barang = Barang::find($id);

        return view('pages.barang.edit', compact('barang', 'id_satuan'));
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
        $this->validate($request,
            [
                'nama' => 'required',
                'id_satuan' => 'required|not_in:0'
            ],
            [
                'required' => ':attribute harap diisi',
                'min' => ':attribute tidak boleh lebih dari 15 karakter',
                'not_in' => ':attribute harus dipilih'
            ],
            [
                'nama' => 'Nama Barang',
                'id_satuan' => 'Satuan'
            ]
        );

        $updateBarang = Barang::find($id);
        $updateBarang->nama = $request->nama;
        $updateBarang->id_satuan = $request->id_satuan;

        $updateBarang->save();

        return redirect('master/barang')->withSukses('Berhasil mengubah data.');
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
            Barang::find($id)->delete();

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
