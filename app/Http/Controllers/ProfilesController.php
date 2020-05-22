<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Conta;
use App\Movimento;

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
            'email' => ['email', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
            'nif' => ['nullable','int', 'digits_between:0,9'],
            'telefone' => ['nullable','int'],
            'foto' => ['max:10000', 'mimes:jpeg,png,jpg'],
        ]);

        $user = Auth::user();
        if(request()->hasFile('foto')){
            $fotoDelete = $user->foto;
            $foto = $user->id . '_' . request()->file('foto')->getClientOriginalName();
            request()->file('foto')->storeAs('fotos', $foto, '');
            $user->update(['foto' => $foto]);
            Storage::delete('fotos' . '/' . $fotoDelete);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->nif = $request->nif;
        $user->telefone = $request->telefone;

        $user->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUser(Request $request)
    {
        $id = Auth::user();
        $request->validate([
            'passwordDelete' => 'required',
        ]);

        if (Hash::check($request->passwordDelete, $id->password)) {
            //delete auth
            //$id->autorizacoes_contas()->delete();
            //DB::table('movimentos')->where('id_user', '>', 100)->dd();
            //delete dos movimentos das contas do user
            $id->movimentos()->delete();
            //delete das contas
            $id->contas()->delete();
            //delete do user
            //$id->delete();
            //User::destroy($id->id);   
            
            return redirect('/');
        }
            //error message
    }
}
