<?php

namespace App\Controllers;

use App\Models\Pesanan as ModelsPesanan;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Pesanan extends ResourceController
{
    use ResponseTrait;
    protected $model;

    public function __construct()
    {
        $this->model = new ModelsPesanan();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $data = $this->model->findAll();
        if (!$data) return $this->failNotFound('Tidak Ada Pesanan');
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $data = $this->model->find(['id' => $id]);
        if (!$data) return $this->failNotFound('Tidak Ada Pesanan');
        return $this->respond($data[0]);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $json = $this->request->getJSON();
        $data = [
            'nama' => $json->nama,
            'pesanan' => $json->pesanan,
            'jumlah' => $json->jumlah,
            'harga' => $json->harga,
            'status' => $json->status
        ];
        $pesanan = $this->model->insert($data);
        if (!$pesanan) return $this->fail('Gagal Membuat Pesanan');
        return $this->respondCreated($pesanan);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $json = $this->request->getJSON();
        $data = [
            'nama' => $json->nama,
            'pesanan' => $json->pesanan,
            'jumlah' => $json->jumlah,
            'harga' => $json->harga,
            'status' => $json->status
        ];
        if (!$this->model->find(['id' => $id])) return $this->fail('Data Tidak Ditemukan', 404);
        $pesanan = $this->model->update($id, $data);
        if (!$pesanan) return $this->fail('Gagal Update Pesanan', 400);
        return $this->respondUpdated($pesanan);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        if (!$this->model->find(['id' => $id])) return $this->fail('Data Tidak Ditemukan', 404);
        $pesanan = $this->model->delete($id);
        if (!$pesanan) return $this->fail('Gagal Menghapus Pesanan', 400);
        return $this->respondDeleted($pesanan);
    }
}
