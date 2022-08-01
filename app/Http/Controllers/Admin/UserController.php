<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileFormRequest;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function profile()
    {
        return view('site.profile.profile');
    }

    public function profileUpdate(UpdateProfileFormRequest $request)
    {
        $user = auth()->user();
        $data = $request->all();

        if ($data['password'] != null) {
            $data['password'] = bcrypt($data['password']);
        }else {
            unset($data['password']);//tiro o password do array
        }
        // ================= parte do upload da imagem ===================
        $data['image'] = $user->image;
        //se foi informado uma imagem e se ela é valida
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($user->image) { //verifica se já tem uma imagem formada
                $newName = explode(".",$user->image);//pega o nome dela
                $name = $newName[0];
            }else {
                $name = $user->id.Str::kebab($user->name);//se já tiver pega o id mais o nome do usuario
            }
            $extenstion = $request->image->extension();
            $nameFile = "{$name}.{$extenstion}";
            $data['image'] = $nameFile;

            //salvando imagem
            $upload = $request->image->storeAs('users',$nameFile);
            if (!$upload) {
                return redirect()
                        ->back()
                        ->with('error','Falha ao fazer o upload da imagem');
            }
        }

        $update = auth()->user()->update($data);
        if ($update) {
            return redirect()->route('profile')->with('success','Sucesso ao atualizar!');
        }
        return redirect()->back()->with('error','Falha ao atualizar o perfil!');
    }
}
