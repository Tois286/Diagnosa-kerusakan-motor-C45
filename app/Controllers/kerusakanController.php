<?php

namespace App\Controllers;

use App\Models\KerusakanModel;

class KerusakanController extends BaseController
{
    public function index()
    {
        return redirect()->to('/content/admin/index?tab=Kerusakan');
    }

    public function save()
    {
        $KerusakanModel = new KerusakanModel();

        $data = [
            'nama_kerusakan' => $this->request->getPost('nama_kerusakan'),
            'kode_kerusakan'  => $this->request->getPost('kode_kerusakan'),
            'solusi' => $this->request->getPost('solusi')
        ];

        $KerusakanModel->insert($data);

        return redirect()->to('/kerusakan')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit()
    {
        $KerusakanModel = new KerusakanModel();

        $id = $this->request->getPost('id_kerusakan');

        $data = [
            'nama_kerusakan' => $this->request->getPost('nama_kerusakan'),
            'kode_kerusakan'  => $this->request->getPost('kode_kerusakan'),
            'solusi' => $this->request->getPost('solusi')
        ];

        $KerusakanModel->update($id, $data);
        return redirect()->to('/kerusakan')->with('success', 'Data Berhasil diperbarui');
    }

    public function delete($id)
    {
        $kerusakanModel = new KerusakanModel();

        $kerusakanModel->delete($id);
        return redirect()->to('/kerusakan')->with('success', 'Data Berhasil dihapus');
    }
}
