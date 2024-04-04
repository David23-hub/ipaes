<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function isAdmin(){
        if(Auth::user()->role=="superuser"){
            return true;
        }
        return false;
    }

    public function index(){
        if(!$this->isAdmin()){
            return $this->edit(Auth::user()->id);
        }

        $users = User::all();
        return view('users.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        if(!$this->isAdmin()){
            return redirect(RouteServiceProvider::HOME);
        }

        return view('users.create');
    }
    public function store(Request $request)
    {
        if(!$this->isAdmin()){
            return redirect(RouteServiceProvider::HOME);
        }

        $req = $request->all();

        if ($request->hasFile('img')) {
            // Image is uploaded
            $image = $request->file('img');
            $imageName = time().'.'.$image->getClientOriginalExtension(); // Generate a unique name for the image
            $image->move(public_path('images'), $imageName);
        } else {
            // Image is not uploaded
            $imageName="";
        }

        $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'no_hp' => 'required',
            'password' => 'required|confirmed'
        ]);
        // $array = $request->only([
        //     'name', 'email','role', 'password', 'img'
        // ]);
        $array = [
            "name" => $req['name'],
            "email" => $req['email'],
            "role" => $req['role'],
            "password" => $req['password'],
            "no_hp" => $req['no_hp'],
            "img" => $imageName,
        ];
        $array['password'] = bcrypt($array['password']);
        $user = User::create($array);
        return redirect()->route('users.index')
            ->with('success_message', 'Berhasil menambah user baru');
    }

    public function edit($id)
    {
        // if(!$this->isAdmin()){
        //     return redirect(RouteServiceProvider::HOME);
        // }

        $user = User::find($id);
        if (!$user) return redirect()->route('users.index')
            ->with('error_message', 'User dengan id'.$id.' tidak ditemukan');

        return view('users.edit', [
            'user' => $user
        ]);
    }


    public function update(Request $request, $id)
    {
        // if(!$this->isAdmin()){
        //     return redirect(RouteServiceProvider::HOME);
        // }


        if ($request->hasFile('img')) {
            // Image is uploaded
            $image = $request->file('img');
            $imageName = time().'.'.$image->getClientOriginalExtension(); // Generate a unique name for the image
            $image->move(public_path('images'), $imageName);
        } else {
            // Image is not uploaded
            $imageName="";
        }

        $request->validate([
            // 'name' => 'required',
            // 'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required',
            'password' => 'sometimes|nullable|confirmed'
        ]);

        $user = User::find($id);
        // $user->name = $request->name;
        // $user->email = $request->email;
        $user->role = $request->role;
        $user->img = $imageName;
        if ($request->password) $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('users.index')
            ->with('success_message', 'Berhasil mengubah user');
    }

    public function destroy(Request $request, $id)
    {
        if(!$this->isAdmin()){
            return redirect(RouteServiceProvider::HOME);
        }

        $user = User::find($id);
        if ($id == $request->user()->id) return redirect()->route('users.index')
            ->with('error_message', 'Anda tidak dapat menghapus diri sendiri.');
        
        $user->deleted_at = date('Y-m-d H:i:s');
        $user->deleted_by = Auth::user()->name;
        $user->save();

        return redirect()->route('users.index')
            ->with('success_message', 'Berhasil menghapus user');
    }
}
