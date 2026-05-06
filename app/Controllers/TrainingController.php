<?php

namespace App\Controllers;

use App\Models\DataTrainingModel;
use App\Models\GejalaModel;
use App\Models\KerusakanModel;

class TrainingController extends BaseController
{
    public function index()
    {
       return redirect()->to('/content/admin/index?tab=hasil')
            ->with('success', 'Data berhasil ditambahkan'); 
    }

    public function lihat($id)
    {
        $dataT = new DataTrainingModel();
        $dataK = new KerusakanModel();
        $dataG = new GejalaModel();

        // ============================
        // 1. Ambil data training
        // ============================
        $training = $dataT->find($id);

        if (!$training) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                "Data training dengan ID $id tidak ditemukan."
            );
        }

        // ============================
        // 2. Ambil data kerusakan
        // ============================
        $kodeKerusakan = $training['hasil'];

        $kerusakan = $dataK->where('kode_kerusakan', $kodeKerusakan)->first();

        if (!$kerusakan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                "Kerusakan dengan kode $kodeKerusakan tidak ditemukan."
            );
        }

        // ============================
        // 3. Ambil gejala bernilai 1
        // ============================
        $gejalaAda = [];

        foreach ($training as $kolom => $nilai) {
            if ($kolom == 'id_training' || $kolom == 'hasil') continue;

            if ($nilai == 1) {
                $g = $dataG->where('kode_gejala', $kolom)->first();
                if ($g) {
                    $gejalaAda[] = $g;
                }
            }
        }

        // ============================
        // 4. Kirim semua data ke halaman hasil
        // ============================
        return redirect()->to('/content/admin/index?tab=Hasil')
            ->with('training', $training)
            ->with('kerusakan', $kerusakan)
            ->with('gejalaAda', $gejalaAda);
    }
}
