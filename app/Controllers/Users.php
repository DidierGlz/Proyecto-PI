<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    private function isAdmin(): bool
    {
        $user = session('user');
        return isset($user['role']) && $user['role'] === 'admin';
    }

    public function index()
    {
        if (! $this->isAdmin()) {
            return redirect()->to('/images')->with('errors', ['No tienes permiso para administrar usuarios.']);
        }

        $users = model(UserModel::class)->orderBy('id','desc')->findAll();
        return view('layout/header')
             . view('users/index', ['users' => $users])
             . view('layout/footer');
    }

    public function create()
    {
        if (! $this->isAdmin()) {
            return redirect()->to('/images')->with('errors', ['No tienes permiso para crear usuarios.']);
        }

        return view('layout/header')
             . view('users/form', [
                 'mode' => 'create',
                 'user' => ['id'=>'','name'=>'','login'=>'','password'=>''],
             ])
             . view('layout/footer');
    }

    public function store()
    {
    if (! $this->isAdmin()) {
        return redirect()->to('/images')->with('errors', ['No tienes permiso para crear usuarios.']);
    }

    $rules = [
        'name'     => 'required|min_length[3]',
        'login'    => 'required|min_length[3]|is_unique[user.login]',
        'password' => 'required|min_length[4]',
    ];
    if (! $this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Ojo: el campo del formulario se llama "password",
    // pero en la BD el campo es "password_hash"
    $post = $this->request->getPost(['name', 'login', 'password']);

    $data = [
        'name'          => $post['name'],
        'login'         => $post['login'],
        'password_hash' => password_hash($post['password'], PASSWORD_DEFAULT),
        'role'          => 'user',
    ];

    model(UserModel::class)->insert($data);

    return redirect()->to('/users')->with('msg', 'Usuario creado.');
}


    public function edit($id)
    {
        if (! $this->isAdmin()) {
            return redirect()->to('/images')->with('errors', ['No tienes permiso para editar usuarios.']);
        }
        $user = model(UserModel::class)->find($id);
        if (!$user) return redirect()->to('/users');

        return view('layout/header')
             . view('users/form', ['mode'=>'edit','user'=>$user])
             . view('layout/footer');
    }

public function update($id)
{
    if (! $this->isAdmin()) {
        return redirect()->to('/images')->with('errors', ['No tienes permiso para editar usuarios.']);
    }

    $user = model(UserModel::class)->find($id);
    if (!$user) {
        return redirect()->to('/users')->with('errors', ['Usuario no encontrado.']);
    }

    $rules = [
        'name'     => 'required|min_length[3]',
        'login'    => 'required|min_length[3]|is_unique[user.login,id,'.$id.']',
        'password' => 'permit_empty|min_length[4]',
    ];
    if (! $this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $post = $this->request->getPost(['name', 'login', 'password']);

    $data = [
        'name'  => $post['name'],
        'login' => $post['login'],
    ];

    if (!empty($post['password'])) {
        $data['password_hash'] = password_hash($post['password'], PASSWORD_DEFAULT);
    }

    model(UserModel::class)->update($id, $data);

    return redirect()->to('/users')->with('msg', 'Usuario actualizado.');
}


    public function delete($id)
    {
        if (! $this->isAdmin()) {
            return redirect()->to('/images')->with('errors', ['No tienes permiso para borrar usuarios.']);
        }
        model(UserModel::class)->delete($id);
        return redirect()->to('/users')->with('msg','Usuario eliminado.');
    }
}
