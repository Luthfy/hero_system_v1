<?php

namespace App\Http\Controllers\Web;

use App\Models\BonusGenerasi;
use App\DataTables\BonusGenerasiDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BonusGenerasiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BonusGenerasiDataTable $datatable)
    {
        return $datatable->render('bonusgenerasi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Bonus Generasi',
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
            'level_generasi' => 'required'
        ]);

        $bonus = BonusGenerasi::create($request->all());

        if ($bonus) {
            return redirect('affiliate/bonusgenerasi')->with('info', 'Level ' . $request->level_generasi . ' telah ditambahkan');
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
            'title' => 'Ubah Bonus Generasi',
            'data' => BonusGenerasi::find($id)
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
            'level_generasi' => 'required'
        ]);

        $bonus = BonusGenerasi::find($id);
        $bonus->level_generasi = $request->level_generasi;
        $bonus->bonus_persen =  $request->bonus_persen;
        $update = $bonus->save();

        if ($update) {
            return redirect('affiliate/bonusgenerasi')->with('info', 'Level ' . $request->level_generasi . ' telah diperbarui');
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
        return BonusGenerasi::find($id)->delete();
    }
}
