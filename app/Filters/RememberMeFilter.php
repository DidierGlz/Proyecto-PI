<?php
namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class RememberMeFilter implements FilterInterface
{
    private string $cookieName = 'remember_ci';

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if ($session->has('user')) return; // ya autenticado

        $cookie = $request->getCookie($this->cookieName);
        if (!$cookie) return;

        // cookie = base64(payload).hmac
        [$b64, $hmac] = array_pad(explode('.', (string)$cookie, 2), 2, null);
        if (!$b64 || !$hmac) return;

        $key = config('Encryption')->key;
        $calc = base64_encode(hash_hmac('sha256', $b64, $key, true));
        if (!hash_equals($calc, $hmac)) return; // firma inválida

        $payload = json_decode(base64_decode($b64), true);
        if (!is_array($payload) || empty($payload['uid']) || empty($payload['login'])) return;

        $user = model(UserModel::class)->find((int)$payload['uid']);
        if (!$user || $user['login'] !== $payload['login']) return;

        // Autologin
        $session->set('user', [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'login' => $user['login'],
        ]);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
