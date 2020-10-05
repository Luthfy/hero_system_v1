<?php

namespace App\Http\Controllers\Web;

use App\DataTables\LevelMemberDataTable;
use App\Http\Controllers\Controller;
use App\Models\LevelMember;
use Illuminate\Http\Request;
use LevelMembersTableSeeder;

class LevelMemberController extends Controller
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
    public function index(LevelMemberDataTable $datatable)
    {
        return $datatable->render('levelmember.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            "title" => "Tambah Level Member",
            "data" => null
        ];

        return view('levelmember.form', $data);
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
            "name_level_member" => "required"
        ]);

        $levelmember = new LevelMember();
        $levelmember->name_level_member = $request->name_level_member;
        $levelmember->poin_level_member = $request->poin_level_member ?? 0;
        $levelmember->bonus_sponsor     = $request->bonus_sponsor ?? 0;
        $levelmember->description_level_member= $request->description_member;
        $create = $levelmember->save();

        if ($create)
        {
            return redirect('affiliate/levelmember')->with('info','Penambahan Berhasil');
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
            "title" => "Ubah Level Member",
            "data" => LevelMember::find($id)
        ];

        return view('levelmember.form', $data);
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
            "name_level_member" => "required"
        ]);

        $levelmember = LevelMember::find($id);
        $levelmember->name_level_member         = $request->name_level_member;
        $levelmember->poin_level_member         = $request->poin_level_member;
        $levelmember->bonus_sponsor             = $request->bonus_sponsor;
        $levelmember->description_level_member  = $request->description_level_member;
        $update = $levelmember->save();

        if ($update)
        {
            return redirect('affiliate/levelmember')->with('info','Perubahan Berhasil');
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
        return LevelMember::find($id)->delete();
    }
}
