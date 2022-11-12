<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Home extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $responses = [
            'status' => 200
        ];
        return $this->respond($responses);
    }
}
