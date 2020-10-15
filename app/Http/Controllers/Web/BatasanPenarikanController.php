<?php

namespace App\Http\Controllers\Web;

use App\DataTables\BatasanPenarikanDataTable;
use App\Http\Controllers\Controller;
use App\Models\BatasanPenarikan;
use Illuminate\Http\Request;

class BatasanPenarikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BatasanPenarikanDataTable $datatable)
    {
        return $datatable->render('batasanpenarikan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Batasan Penarikan',
            'data' => null
        ];
        return view('batasanpenarikan.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_batasan' => 'required',
        ]);
        $batasan = BatasanPenarikan::create($request->all());

        if ($batasan) {
            return redirect('affiliate/batasanpenarikan')->with('info', $request->jenis_batasan . ' telah disimpan');
        }
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
        $data = [
            "title" => 'Ubah Batasan Penarikan',
            "data" => BatasanPenarikan::find($id)
        ];
        return view('batasanpenarikan.form', $data);
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
        $request->validate([
            'jenis_batasan' => 'required',
        ]);

        $batasan = BatasanPenarikan::find($id);
        $batasan->jenis_batasan = $request->jenis_batasan;
        $batasan->besaran_batasan = $request->besaran_batasan;
        $batasan->estimasi_waktu_batasan = $request->estimasi_waktu_batasan;
        $update = $batasan->save();

        if ($update) {
            return redirect('affiliate/batasanpenarikan')->with('info', $batasan->jenis_batasan . ' telah diperbarui');
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
        return BatasanPenarikan::find($id)->delete();
    }
}
