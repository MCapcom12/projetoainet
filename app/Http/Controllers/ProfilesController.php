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
            'nif' => ['nullable','required', 'unique:users','int', 'digits_between:0,9'],
            'telefone' => ['nullable','string', 'regex:/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.0-9]*$/i'],
            'foto' => ['max:10000'],

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
            $id->autorizacoes_contas()->detach();

            foreach ($id->contas()->withTrashed()->get() as $conta) {
                $conta->movimentos()->withTrashed()->forceDelete();
                $conta->utilizadores_autorizados()->detach();
            }
            //delete das contas
            $id->contas()->withTrashed()->forceDelete();

            //delete de foto de user
            Storage::delete('fotos' . '/' . $id->foto);

            //delete do user
            $id->delete();
            
            return redirect('/');
        }
            return redirect()->back()
                    ->with('alert-msg', 'Password Errada!')
                    ->with('alert-type', 'danger');
    }
}
