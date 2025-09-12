<?php

namespace App\Libraries;

class C45
{
    protected $dataset;
    protected $attributes;
    protected $target = 'hasil';
    protected $trace = [];

    public function __construct($dataset)
    {
        $this->dataset = $dataset;

        if (!empty($dataset)) {
            // Ambil semua kolom kecuali id & target
            $this->attributes = array_filter(
                array_keys($dataset[0]),
                fn($attr) => !in_array($attr, ['id_training', $this->target])
            );
        }
    }

    // Hitung entropy
    protected function entropy($data)
    {
        $total = count($data);
        if ($total == 0) return 0;

        $counts = [];
        foreach ($data as $row) {
            $label = $row[$this->target];
            if (!isset($counts[$label])) $counts[$label] = 0;
            $counts[$label]++;
        }

        $entropy = 0;
        foreach ($counts as $count) {
            $p = $count / $total;
            $entropy -= $p * log($p, 2);
        }
        return $entropy;
    }

    // Hitung gain
    protected function gain($data, $attribute)
    {
        $total = count($data);
        $entropyBefore = $this->entropy($data);

        $values = [];
        foreach ($data as $row) {
            $val = $row[$attribute];
            $values[$val][] = $row;
        }

        $entropyAfter = 0;
        foreach ($values as $subset) {
            $entropyAfter += (count($subset) / $total) * $this->entropy($subset);
        }

        $gain = $entropyBefore - $entropyAfter;

        // Simpan trace gain tiap atribut
        $this->trace['gain'][] = [
            'attribute'      => $attribute,
            'entropy_before' => round($entropyBefore, 4),
            'entropy_after'  => round($entropyAfter, 4),
            'gain'           => round($gain, 4)
        ];

        return $gain;
    }

    // Bangun pohon
    public function buildTree($data = null, $attributes = null, $depth = 0)
    {
        if ($data === null) $data = $this->dataset;
        if ($attributes === null) $attributes = $this->attributes;

        $labels = array_unique(array_column($data, $this->target));
        if (count($labels) == 1) {
            return ['label' => $labels[0]];
        }

        if (empty($attributes)) {
            $counts = array_count_values(array_column($data, $this->target));
            arsort($counts);
            return ['label' => key($counts)];
        }

        // Cari atribut terbaik
        $bestAttr = null;
        $bestGain = -INF;
        foreach ($attributes as $attr) {
            $g = $this->gain($data, $attr);
            if ($g > $bestGain) {
                $bestGain = $g;
                $bestAttr = $attr;
            }
        }

        // Catat pemilihan atribut di trace pohon
        $this->trace['tree'][] = str_repeat("—", $depth)
            . " Pilih atribut: $bestAttr (gain=" . round($bestGain, 3) . ")";

        $tree = ['attribute' => $bestAttr, 'branches' => []];
        $values = array_unique(array_column($data, $bestAttr));

        foreach ($values as $val) {
            $subset = array_filter($data, fn($row) => $row[$bestAttr] == $val);

            if (empty($subset)) {
                $counts = array_count_values(array_column($data, $this->target));
                arsort($counts);
                $tree['branches'][$val] = ['label' => key($counts)];
            } else {
                $subAttr = array_diff($attributes, [$bestAttr]);
                $tree['branches'][$val] = $this->buildTree($subset, $subAttr, $depth + 1);
            }
        }

        return $tree;
    }

    // Diagnosa user input
    public function diagnosa($input, $tree = null)
    {
        if ($tree === null) {
            $tree = $this->buildTree();
        }

        if (isset($tree['label'])) {
            return $tree['label'];
        }

        $attr = $tree['attribute'];
        // Jika gejala dipilih maka val = 1, jika tidak = 0
        $val = in_array($attr, $input) ? 1 : 0;

        if (isset($tree['branches'][$val])) {
            return $this->diagnosa($input, $tree['branches'][$val]);
        }

        return null;
    }

    // Evaluasi akurasi model dengan data uji
    public function evaluate($testData, $tree = null)
    {
        if ($tree === null) {
            $tree = $this->buildTree();
        }

        $correct = 0;
        $total   = count($testData);

        foreach ($testData as $row) {
            // Bentuk input array dari atribut yang bernilai 1
            $input = [];
            foreach ($this->attributes as $attr) {
                if ($row[$attr] == 1) {
                    $input[] = $attr;
                }
            }

            // Prediksi hasil dengan decision tree
            $predicted = $this->diagnosa($input, $tree);

            // Cek apakah sesuai dengan label sebenarnya
            if ($predicted == $row[$this->target]) {
                $correct++;
            }
        }

        return [
            'correct' => $correct,
            'total'   => $total,
            'accuracy' => $total > 0 ? round(($correct / $total) * 100, 2) : 0
        ];
    }

    public function getTrace()
    {
        return $this->trace;
    }
}
