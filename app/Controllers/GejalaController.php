<?php

namespace App\Controllers;

use App\Models\GejalaModel;
use App\Models\DataTrainingModel;

class GejalaController extends BaseController
{
    public function index()
    {
        return redirect()->to('/content/admin/index?tab=Gejala');
    }

    public function save()
    {
        $gejalaModel = new GejalaModel();
        $db = \Config\Database::connect();

        // Ambil data input
        $kode_gejala = $this->request->getPost('kode_gejala');
        $nama_gejala = $this->request->getPost('nama_gejala');

        // Simpan ke tabel gejala
        $gejalaModel->insert([
            'nama_gejala' => $nama_gejala,
            'kode_gejala' => $kode_gejala
        ]);

        // Bersihkan nama kolom
        $kodeKolom = preg_replace('/[^A-Za-z0-9_]/', '', $kode_gejala);

        // Cari kolom sebelum 'hasil'
        $columns = $db->query("SHOW COLUMNS FROM data_training")->getResultArray();

        $beforeColumn = '';
        for ($i = 0; $i < count($columns); $i++) {
            if ($columns[$i]['Field'] == 'hasil' && $i > 0) {
                $beforeColumn = $columns[$i - 1]['Field'];
                break;
            }
        }

        // Jika kolom sebelum hasil ditemukan → tambahkan setelah kolom tersebut
        if ($beforeColumn != '') {
            $sql = "ALTER TABLE data_training 
                ADD COLUMN `$kodeKolom` TINYINT(1) DEFAULT 0 
                AFTER `$beforeColumn`";
        } else {
            // Jika 'hasil' tidak ditemukan → fallback append di akhir tabel
            $sql = "ALTER TABLE data_training 
                ADD COLUMN `$kodeKolom` TINYINT(1) DEFAULT 0";
        }

        try {
            $db->query($sql);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat kolom baru: ' . $e->getMessage());
        }

        return redirect()->to('/gejala')->with('success', 'Data berhasil ditambahkan & kolom baru dibuat');
    }


    public function edit()
    {
        $gejalaModel = new GejalaModel();

        $id = $this->request->getPost('id_gejala');

        $data = [
            'nama_gejala' => $this->request->getPost('nama_gejala'),
            'kode_gejala' => $this->request->getPost('kode_gejala')
        ];

        $gejalaModel->update($id, $data);
        return redirect()->to('/gejala')->with('success', 'Data berhasil diperbarui');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $gejalaModel = new GejalaModel();

        // Ambil data gejala dulu sebelum dihapus
        $gejala = $gejalaModel->find($id);

        if (!$gejala) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Ambil nama kolom dari kode_gejala
        $kodeKolom = preg_replace('/[^A-Za-z0-9_]/', '', $gejala['kode_gejala']);

        // Cek apakah kolom benar-benar ada di database
        $check = $db->query("SHOW COLUMNS FROM data_training LIKE '$kodeKolom'")->getResult();

        if (!empty($check)) {
            // Hapus kolom dari data_training
            try {
                $db->query("ALTER TABLE data_training DROP COLUMN `$kodeKolom`");
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal menghapus kolom: ' . $e->getMessage());
            }
        }

        // Hapus data gejala dari tabel gejala
        $gejalaModel->delete($id);

        return redirect()->to('/gejala')->with('success', 'Data & kolom berhasil dihapus');
    }
}
