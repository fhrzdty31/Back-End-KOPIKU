<?php

namespace App\Controllers;

use App\Models\User as ModelUser;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Register extends ResourceController
{
    use ResponseTrait;
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        helper(['form']);
        $rules = [
            'username' => 'required|is_unique[user.username]',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]'
        ];
        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $json = $this->request->getJSON();
        $data = [
            'username' => $json->username,
            'email' => $json->email,
            'password' => password_hash($json->password, PASSWORD_BCRYPT)
        ];
        $model = new ModelUser();
        $user = $model->insert($data);
        if (!$user) return $this->fail('Gagal Register');
        return $this->respondCreated($user);
    }
}
