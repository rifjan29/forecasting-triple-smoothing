<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $satuan = Satuan::all();
        return view('pages.satuan.index')->with('satuan', $satuan)->with('i',(request()->input('page',1)-1)*5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['subtitle'] = 'Tambah Satuan';
        $this->param['top_button'] = route('satuan.index');

        return view('pages.satuan.create', $this->param);
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
                'satuan' => 'required', 'string|min:15|regex:/^[a-zA-Z]+$/u',
            ],
            [
                'required' => ':attribute harap diisi',
                'min' => ':attribute tidak boleh lebih dari 15 karakter',
                'regex' => 'Harus di isi dengan huruf'
            ],
            [
                'satuan' => 'Satuan',
            ]
        );

        try {
            $newSatuan = new Satuan;
            $newSatuan->satuan = $request->satuan;

            $newSatuan->save();

            return redirect('master/satuan')->withStatus('Berhasil menyimpan data.');
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
    public function show(Satuan $satuan)
    {
        return view('pages.satuan.index',compact('satuan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $satuan = Satuan::find($id);
        return view('pages.satuan.edit', compact('satuan'));
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
                'satuan' => 'required', 'string|min:15|regex:/^[a-zA-Z]+$/u',
            ],
            [
                'required' => ':attribute harap diisi',
                'min' => ':attribute tidak boleh lebih dari 15 karakter',
                'regex' => 'Harus di isi dengan huruf'
            ],
            [
                'satuan' => 'Satuan',
            ]
        );

        $updateSatuan = Satuan::find($id);
        $updateSatuan->satuan = $request->satuan;
        $updateSatuan->save();

        return redirect('master/satuan')->withSukses('Berhasil mengubah data.');
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
                Satuan::find($id)->delete();

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
