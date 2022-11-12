<?php

namespace App\Controllers;

use App\Models\User as ModelUser;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use CodeIgniter\RESTful\ResourceController;


class Login extends ResourceController
{
    use ResponseTrait;
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $json = $this->request->getJSON();
        $model = new ModelUser();
        $user = $model->where("username", $json->username)->first();
        if (!$user) return $this->failNotFound('Email Tidak Ditemukan');

        $verify = password_verify($json->password, $user['password']);
        if (!$verify) return $this->fail('Password Wrong');

        $key = getenv('TOKEN_CECRET');
        $iat = time();
        $exp = $iat + (60 * 60 * 24);
        $payload = [
            'iat' => $iat,
            'exp' => $exp,
            'uid' => $user['id'],
            'username' => $user['username']
        ];

        $token = JWT::encode($payload, $key, 'HS256');

        return $this->respond($token);
    }
}
