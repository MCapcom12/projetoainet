<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use App\User;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user();
        return view('perfil.edit')->withId($id);
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
        //
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
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => ['string', 'max:255'],
            //'email' => ['email', 'max:255', 'unique:users'],
            //'old_password' => ['required', 'min:8', new MatchOldPassword],
            //'new_password' => ['string', 'min:8'/*'confirmed'*/],
            //'new_confirm_password' => ['required','string', 'min:8', 'same:new_password'],
            'old_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'min:8'],
            'new_confirm_password' => ['same:new_password'],
            'foto' => ['max:10000'],
        ]);

        $user = Auth::user();

        if(request()->hasFile('foto')){
            $foto = request()->file('foto')->getClientOriginalName();
            //Storage::delete('public/fotos', $user->id . '/' .  $foto, '');
            request()->file('foto')->storeAs('fotos', $user->id . '/' .  $foto, '');
            $user->update(['foto' => $foto]);
        }

        $user->name = $request->name;
        $user->nif = $request->nif;
        $user->telefone = $request->telefone;

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        $user->save();

        return redirect()->back();
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
