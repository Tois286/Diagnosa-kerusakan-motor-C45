<?php

namespace App\Controllers;

use App\Models\DataUsersModel;
use App\Models\UserModel;

class UsersController extends BaseController
{
    public function index()
    {
        if (session()->get('role') !== 'karyawan') {
            return redirect()->to('/auth/login');
        }

        $gejalaModel = new \App\Models\GejalaModel();
        $data['gejala'] = $gejalaModel->findAll();

        $kerusakanModel = new \App\Models\KerusakanModel();
        $data['kerusakan'] = $kerusakanModel->findAll();

        $userModel = new \App\Models\UserModel();
        $guestModel = new \App\Models\DataGuestModel();
        $data['guest'] = $guestModel->findAll();
        // ambil semua user
        $data['users'] = $userModel->getUser();

        // ambil user login saja (berdasarkan session)
        $idUser = session()->get('id_user');
        $data['sesUser'] = $userModel->getUser($idUser);

        // kalau mau filter status langsung dari controller:
        $data['karyawan'] = $userModel->getUser(null, 'karyawan');
        $data['admin'] = $userModel->getUser(null, 'admin');
        $data['pelanggan'] = $userModel->getUser(null, 'pelanggan');

        $story = new \App\Models\DataHistoryModel();
        $data['history'] = $story->findAll();

        return view('content/index', $data);
    }

    public function back()
    {
        return redirect()->to('/content/admin/index');
    }
    public function save()
    {
        $db = \Config\Database::connect();

        $userData = new DataUsersModel();
        $userModel = new UserModel();

        // upload foto
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/', $namaFoto);
        }

        // mulai transaksi
        $db->transStart();

        // 1. insert ke tabel users
        $userModel->insert([
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role')
        ]);

        // 2. ambil ID terakhir (AMAN)
        $idUser = $userModel->insertID();

        // 3. insert ke tabel data_users pakai ID yang sama
        $userData->insert([
            'id_user' => $idUser, // <-- ini kuncinya
            'nama_user' => $this->request->getPost('nama'),
            'tgl_lahir' => $this->request->getPost('tgl_lahir'),
            't_tinggal' => $this->request->getPost('t_tinggal'),
            'status_pengguna' => $this->request->getPost('status_karyawan'),
            'foto' => $namaFoto
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan data');
        }

        return redirect()->to('/AdminSet')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit()
    {
        $db = \Config\Database::connect();

        $userData = new DataUsersModel();
        $userModel = new UserModel();

        // ambil ID dari form
        $id = $this->request->getPost('id_user');

        // ambil data lama (untuk hapus foto lama nanti)
        $oldData = $userData->where('id_user', $id)->first();

        // ambil file foto
        $fileFoto = $this->request->getFile('foto');

        $db->transStart();

        // =====================
        // 1. UPDATE TABEL USERS
        // =====================
        $dataUser = [
            'email' => $this->request->getPost('email'),
            'role'  => $this->request->getPost('role')
        ];

        // password optional
        if ($this->request->getPost('password')) {
            $dataUser['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }

        $userModel->update($id, $dataUser);

        // =====================
        // 2. UPDATE DATA_USER
        // =====================
        $dataDetail = [
            'nama_user'       => $this->request->getPost('nama'),
            'tgl_lahir'       => $this->request->getPost('tgl_lahir'),
            't_tinggal'       => $this->request->getPost('t_tinggal'),
            'status_pengguna' => $this->request->getPost('status_karyawan'),
        ];

        // =====================
        // HANDLE FOTO (INI KUNCI UTAMA)
        // =====================
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {

            // buat nama baru
            $namaFotoBaru = $fileFoto->getRandomName();

            // simpan ke public/uploads
            $fileFoto->move(FCPATH . 'uploads/', $namaFotoBaru);

            // hapus foto lama (jika ada)
            if (!empty($oldData['foto']) && file_exists(FCPATH . 'uploads/' . $oldData['foto'])) {
                unlink(FCPATH . 'uploads/' . $oldData['foto']);
            }

            // update hanya kalau ada foto baru
            $dataDetail['foto'] = $namaFotoBaru;
        }

        // update database
        $userData->update($id, $dataDetail);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal update data');
        }

        return redirect()->to('/AdminSet')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();

        $userData = new DataUsersModel();
        $userModel = new UserModel();

        // ambil data foto dulu (biar bisa dihapus dari folder)
        $user = $userData->where('id_user', $id)->first();

        $db->transStart();

        // 1. hapus dari tabel data_users (child dulu)
        $userData->where('id_user', $id)->delete();

        // 2. hapus dari tabel users
        $userModel->delete($id);

        $db->transComplete();

        // cek transaksi
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menghapus data');
        }

        // 3. hapus file foto (kalau ada)
        if ($user && !empty($user['foto'])) {
            $path = 'uploads/' . $user['foto'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        return redirect()->to('/AdminSet')->with('success', 'Data berhasil dihapus');
    }
}
