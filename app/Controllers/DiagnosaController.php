<?php

namespace App\Controllers;

use App\Models\DataTrainingModel;
use App\Models\GejalaModel;
use App\Models\KerusakanModel;
use App\Libraries\C45;

class DiagnosaController extends BaseController
{
    protected $gejalaModel;
    protected $dataTrainingModel;
    protected $kerusakanModel;

    public function __construct()
    {
        $this->gejalaModel = new GejalaModel();
        $this->dataTrainingModel = new DataTrainingModel();
        $this->kerusakanModel = new KerusakanModel();
    }

    public function index()
    {
        $data['gejala'] = $this->gejalaModel->findAll();
        return view('diagnosa/form', $data);
    }

    public function proses()
    {
        $gejalaTerpilih = $this->request->getPost('gejala');

        if (empty($gejalaTerpilih)) {
            return redirect()->back()->with('error', 'Silakan pilih minimal satu gejala.');
        }

        // Ambil semua data training
        $dataset = $this->dataTrainingModel->findAll();

        // Buat instance C45
        $c45 = new C45($dataset);

        // Bangun pohon
        $tree = $c45->buildTree();
        $trace = $c45->getTrace();

        // =======================
        // 1. Diagnosa user input
        // =======================
        $hasilPrediksi = $c45->diagnosa($gejalaTerpilih, $tree);

        $hasilKerusakan = $this->kerusakanModel
            ->where('kode_kerusakan', $hasilPrediksi)
            ->first();

        // Ambil nama gejala terpilih
        $gejalaList = $this->gejalaModel->findAll();
        $mapGejala = [];
        foreach ($gejalaList as $g) {
            $mapGejala[$g['kode_gejala']] = $g['nama_gejala'];
        }

        $namaGejalaTerpilih = [];
        foreach ($gejalaTerpilih as $g) {
            $namaGejalaTerpilih[] = $mapGejala[$g] ?? $g;
        }

        // =======================
        // 2. Evaluasi akurasi
        // =======================
        $evaluasi = $c45->evaluate($dataset, $tree);

        // =======================
        // 3. Simpan semua ke session
        // =======================
        session()->set([
            'tree'           => $tree,
            'trace'          => $trace,
            'gejalaTerpilih' => $namaGejalaTerpilih,
            'hasil'          => $hasilKerusakan,
            'evaluasi'       => $evaluasi
        ]);

        return redirect()->to('/content/admin/index?tab=HasilDiagnosa');
    }
}
