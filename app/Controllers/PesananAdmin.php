<?php

namespace App\Controllers;

use App\Models\Pesanan as ModelsPesanan;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class PesananAdmin extends ResourceController
{
    use ResponseTrait;
    protected $model;

    public function __construct()
    {
        $this->model = new ModelsPesanan();
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($key = null)
    {
        $status = '';
        switch ($key) {
            case 'k':
                $status = 'konfirmasi';
                break;

            case 'p':
                $status = 'proses';
                break;

            default:
                break;
        }
        $data = $this->model->where('status', $status)->findAll();
        if (!$data) return $this->failNotFound('Tidak Ada Pesanan');
        return $this->respond($data);
    }
}
