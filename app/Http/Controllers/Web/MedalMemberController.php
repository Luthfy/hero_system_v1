<?php

namespace App\Http\Controllers\Web;

use App\Models\Medal;
use App\DataTables\MedalMemberDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedalMemberController extends Controller
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
    public function index(MedalMemberDataTable $datatable)
    {
        return $datatable->render('medalmember.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Medal',
            'data' => null
        ];
        return view('medalmember.form', $data);
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
            'name_medal' => 'required'
        ]);

        $medal = new Medal();

        if ($request->hasFile('icon_medal'))
        {
            $request->validate([
                'icon_medal' => 'mimes:png,jpg,jpeg|max:1024'
            ]);

            $filename  = time() . '_' . $request->file('icon_medal')->getClientOriginalName();

            $filepath = $request->file('icon_medal')->storeAs('public/storage/medals', $filename);

            $medal->icon_medal = $filepath;
        }

        $medal->name_medal = $request->name_medal;
        $medal->reward_medal = $request->reward_medal;
        $medal->max_penarikan = $request->max_penarikan;
        $medal->min_saldo = $request->min_saldo;
        $medal->persyaratan_medal = $request->persyaratan_medal;
        $save = $medal->save();

        return redirect('affiliate/medalmember')->with('info', $medal->name_medal . " Berhasil Disimpan");
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
            'title' => 'Edit Medal Member',
            'data' => Medal::find($id)
        ];
        return view('medalmember.form', $data);
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
        if ($request->hasFile('icon_medal'))
        {
            $request->validate([
                'name_medal' => 'required',
                'icon_medal' => 'mimes:jpeg,jpg,png|max:1014'
            ]);

            $medal = Medal::find($id);

            if (! empty($medal->icon_medal))
            {
                unlink($medal->icon_medal);
            }

            $filename           = time() . '_' . $request->file('icon_medal')->getClientOriginalName();
            $filepath           = $request->file('icon_medal')->storeAs('public/storage/medals', $filename);
            $medal->icon_medal  = $filepath;

            $medal->name_medal          = $request->name_medal;
            $medal->reward_medal        = $request->reward_medal;
            $medal->max_penarikan       = $request->max_penarikan;
            $medal->min_saldo           = $request->min_saldo;
            $medal->persyaratan_medal   = $request->persyaratan_medal;
            $medal->save();

            return redirect('affiliate/medalmember')->with('info', $medal->name_medal . " telah diperbarui!");
        }
        else
        {
            $request->validate([
                'name_medal' => 'required'
            ]);

            $medal = Medal::find($id);
            $medal->name_medal          = $request->name_medal;
            $medal->reward_medal        = $request->reward_medal;
            $medal->max_penarikan       = $request->max_penarikan;
            $medal->min_saldo           = $request->min_saldo;
            $medal->persyaratan_medal   = $request->persyaratan_medal;
            $medal->save();

            return redirect('affiliate/medalmember')->with('info', $medal->name_medal . " telah diperbarui!");
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
        return Medal::find($id)->delete();
    }
}
