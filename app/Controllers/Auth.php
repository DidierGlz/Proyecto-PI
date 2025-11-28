<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\Services;

class Auth extends BaseController
{
    private string $cookieName = 'remember_ci';
    private int $cookieDays = 30;

    public function loginForm()
    {
        return view('layout/header')
             . view('auth/login')
             . view('layout/footer');
    }

    public function registerForm()
{
    return view('layout/header')
         . view('auth/register')
         . view('layout/footer');
}

public function register()
{
    $rules = [
        'name'     => 'required|min_length[3]',
        'login'    => 'required|min_length[3]|is_unique[user.login]',
        'password' => 'required|min_length[4]',
    ];

    if (! $this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $post = $this->request->getPost(['name','login','password']);

    model(UserModel::class)->insert([
        'name'          => $post['name'],
        'login'         => $post['login'],
        'password_hash' => password_hash($post['password'], PASSWORD_DEFAULT),
        // Registro SIEMPRE crea usuarios normales
        'role'          => 'user',
    ]);

    return redirect()->to('/login')->with('msg', 'Cuenta creada con éxito. Ya puedes iniciar sesión.');
}

    public function login()
    {
        $rules = [
            'login'    => 'required|min_length[3]',
            'password' => 'required|min_length[4]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $login = trim((string)$this->request->getPost('login'));
        $pwd   = (string)$this->request->getPost('password');
        $remember = (bool)$this->request->getPost('remember');

        $user = model(UserModel::class)->where('login', $login)->first();
        if (!$user || !password_verify($pwd, $user['password_hash'])) {
        return redirect()->back()->withInput()->with('errors', ['Credenciales inválidas']);
    }

        // Sesion
        session()->set('user', [
        'id'    => $user['id'],
        'name'  => $user['name'],
        'login' => $user['login'],
        'role'  => $user['role'] ?? 'user',
    ]);

        // Cookie remember firmada
        if ($remember) {
            $payload = base64_encode(json_encode(['uid' => $user['id'], 'login' => $user['login'], 'ts' => time()]));
            $key = config('Encryption')->key;
            $hmac = base64_encode(hash_hmac('sha256', $payload, $key, true));

            $response = service('response');
            $response->setCookie(
                $this->cookieName,
                "{$payload}.{$hmac}",
                60 * 60 * 24 * $this->cookieDays, // segundos
                '', '/', '', false, true           // domain, path, secure, httpOnly
            );
        }

        return redirect()->to('/users')->with('msg','Bienvenido, ' . $user['name']);
    }

    public function logout()
    {
        // quitar cookie remember
        $response = service('response');
        $response->deleteCookie($this->cookieName, '/');

        // limpiar sesión
        session()->remove('user');
        session()->destroy();

        return redirect()->to('/login')->with('msg','Sesión cerrada.');
    }
}
