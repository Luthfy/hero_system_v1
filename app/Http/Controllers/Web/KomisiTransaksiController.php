<?php

namespace App\Http\Controllers\Web;

use App\Models\KomisiTransaksi;
use App\DataTables\KomisiTransaksiDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KomisiTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KomisiTransaksiDataTable $datatable)
    {
        return $datatable->render('komisitransaksi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Form Komisi Transaksi',
            'data' => null
        ];

        return view('komisitransaksi.form', $data);
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
            'jenis_komisi' => 'required'
        ]);

        $komisi = KomisiTransaksi::create($request->all());

        if ($komisi) {
            return redirect('affiliate/komisitransaksi')->with('info', $request->jenis_komisi . " telah ditambahkan");
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
            'title' => 'Ubah Komisi Transaksi',
            'data' => KomisiTransaksi::find($id)
        ];
        return view('komisitransaksi.form', $data);
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
            'jenis_komisi' => 'required'
        ]);

        $komisi = KomisiTransaksi::find($id);
        $komisi->jenis_komisi = $request->jenis_komisi;
        $komisi->besaran_komisi = $request->besaran_komisi;
        $komisi->jenis_besaran = $request->jenis_pesaran;
        $update = $komisi->save();

        if ($update) {
            return redirect('affiliate/komisitransaksi')->with('info', $request->jenis_komisi . " telah diperbarui");
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
        return KomisiTransaksi::find($id)->delete();
    }
}
