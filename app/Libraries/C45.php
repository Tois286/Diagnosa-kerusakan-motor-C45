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
        $this->dataset = $this->normalizeDataset($dataset);

        if (!empty($this->dataset)) {
            // Ambil semua kolom kecuali id & target
            $this->attributes = array_values(array_filter(
                array_keys($this->dataset[0]),
                fn($attr) => !in_array($attr, ['id_training', $this->target])
            ));
        } else {
            $this->attributes = [];
        }
    }

    // Normalisasi dataset: pastikan setiap sel skalar (jika array -> implode)
    protected function normalizeDataset($dataset)
    {
        if (empty($dataset) || !is_array($dataset)) return [];

        $out = [];
        foreach ($dataset as $row) {
            $newRow = [];
            foreach ($row as $k => $v) {
                if (is_array($v)) {
                    // Jika nilai array, gabungkan menjadi string "1,0" atau serupa
                    $newRow[$k] = implode(',', $v);
                } else {
                    $newRow[$k] = $v;
                }
            }
            $out[] = $newRow;
        }
        return $out;
    }

    // Hitung entropy (aman terhadap p == 0)
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

        $entropy = 0.0;
        foreach ($counts as $count) {
            $p = $count / $total;
            if ($p > 0) {
                $entropy -= $p * log($p, 2);
            }
        }
        return $entropy;
    }

    // Hitung gain untuk kategori
    protected function gain($data, $attribute)
    {
        $total = count($data);
        $entropyBefore = $this->entropy($data);

        $values = [];
        foreach ($data as $row) {
            $val = $row[$attribute];
            $values[$val][] = $row;
        }

        $entropyAfter = 0.0;
        foreach ($values as $subset) {
            $entropyAfter += (count($subset) / $total) * $this->entropy(array_values($subset));
        }

        return $entropyBefore - $entropyAfter;
    }

    // Hitung SplitInfo
    protected function splitInfo($data, $splits)
    {
        $total = count($data);
        if ($total == 0) return 0;
        $splitInfo = 0.0;
        foreach ($splits as $subset) {
            $p = count($subset) / $total;
            if ($p > 0) {
                $splitInfo -= $p * log($p, 2);
            }
        }
        return $splitInfo;
    }

    // Hitung GainRatio (kategori maupun numerik jika benar-benar numeric)
    protected function gainRatio($data, $attribute)
    {
        // Cegah error kalau dataset kosong
        if (empty($data)) {
            return ['gain_ratio' => 0.0, 'threshold' => null];
        }

        // Pastikan atribut ada di baris pertama
        $firstRow = reset($data);
        if (!isset($firstRow[$attribute])) {
            return ['gain_ratio' => 0.0, 'threshold' => null];
        }

        // Deteksi nilai unik untuk atribut
        $valuesList = array_map(fn($r) => $r[$attribute], $data);
        $uniqueValues = array_values(array_unique($valuesList));

        // Tentukan apakah numeric: semua elemen numeric && lebih dari 2 nilai unik
        $allNumeric = true;
        foreach ($uniqueValues as $v) {
            if (!is_numeric($v)) {
                $allNumeric = false;
                break;
            }
        }
        $isNumeric = $allNumeric && count($uniqueValues) > 2;

        if (!$isNumeric) {
            // Atribut dianggap kategori (termasuk 0/1)
            $gain = $this->gain($data, $attribute);

            // kumpulkan subsets per nilai
            $values = [];
            foreach ($data as $row) {
                $val = $row[$attribute];
                $values[$val][] = $row;
            }

            $splitInfo = $this->splitInfo($data, $values);
            $gainRatio = ($splitInfo == 0) ? 0.0 : $gain / $splitInfo;

            if (!is_finite($gainRatio) || is_nan($gainRatio)) {
                $gainRatio = 0.0;
            }

            $this->trace['gain_ratio'][] = [
                'attribute'  => (string)$attribute,
                'type'       => 'categorical',
                'gain'       => round($gain, 6),
                'split_info' => round($splitInfo, 6),
                'gain_ratio' => round($gainRatio, 6)
            ];

            return ['gain_ratio' => $gainRatio, 'threshold' => null];
        } else {
            // Atribut numerik (lebih dari 2 nilai unik dan numeric)
            $sorted = $data;
            usort($sorted, fn($a, $b) => $a[$attribute] <=> $b[$attribute]);

            $bestGR = -INF;
            $bestThreshold = null;
            $n = count($sorted);

            for ($i = 0; $i < $n - 1; $i++) {
                $currVal = $sorted[$i][$attribute];
                $nextVal = $sorted[$i + 1][$attribute];
                if ($currVal == $nextVal) continue;

                $threshold = ($currVal + $nextVal) / 2.0;

                $left = array_values(array_filter($data, fn($row) => $row[$attribute] <= $threshold));
                $right = array_values(array_filter($data, fn($row) => $row[$attribute] > $threshold));

                $entropyBefore = $this->entropy($data);
                $entropyAfter = (count($left) / count($data)) * $this->entropy($left)
                    + (count($right) / count($data)) * $this->entropy($right);
                $gain = $entropyBefore - $entropyAfter;

                $splitInfo = $this->splitInfo($data, [$left, $right]);
                $gainRatio = ($splitInfo == 0) ? 0.0 : $gain / $splitInfo;

                if (!is_finite($gainRatio) || is_nan($gainRatio)) {
                    $gainRatio = 0.0;
                }

                if ($gainRatio > $bestGR) {
                    $bestGR = $gainRatio;
                    $bestThreshold = $threshold;
                }
            }

            if (!is_finite($bestGR) || is_nan($bestGR)) {
                $bestGR = 0.0;
            }

            $this->trace['gain_ratio'][] = [
                'attribute'  => (string)$attribute,
                'type'       => 'numeric',
                'threshold'  => $bestThreshold,
                'gain_ratio' => round($bestGR, 6)
            ];

            return ['gain_ratio' => $bestGR, 'threshold' => $bestThreshold];
        }
    }

    // Majority label helper
    protected function majorityLabel($data)
    {
        if (empty($data)) return null;
        $counts = array_count_values(array_column($data, $this->target));
        arsort($counts);
        return key($counts);
    }

    // Bangun pohon
    public function buildTree($data = null, $attributes = null, $depth = 0)
    {
        if ($data === null) $data = $this->dataset;
        if ($attributes === null) $attributes = $this->attributes;

        $data = array_values($data); // reindex

        $labels = array_unique(array_column($data, $this->target));
        if (count($labels) == 1) {
            return ['label' => $labels[0]];
        }

        if (empty($attributes)) {
            return ['label' => $this->majorityLabel($data)];
        }

        // Cari atribut terbaik dengan Gain Ratio
        $bestAttr = null;
        $bestGR = -INF;
        $bestThreshold = null;

        foreach ($attributes as $attr) {
            $result = $this->gainRatio($data, $attr);
            $gr = $result['gain_ratio'] ?? 0.0;
            if ($gr > $bestGR) {
                $bestGR = $gr;
                $bestAttr = $attr;
                $bestThreshold = $result['threshold'] ?? null;
            }
        }

        // Jika tidak ada atribut yang memberikan informasi (semua 0), kembalikan mayoritas
        if ($bestAttr === null || $bestGR <= 0) {
            return ['label' => $this->majorityLabel($data)];
        }

        // Simpan trace (teks aman)
        $this->trace['tree'][] = str_repeat("—", $depth)
            . " Pilih atribut: " . (string)$bestAttr
            . ($bestThreshold !== null ? " <= " . round($bestThreshold, 6) : "")
            . " (GainRatio=" . round($bestGR, 6) . ")";

        $tree = ['attribute' => (string)$bestAttr, 'threshold' => $bestThreshold, 'branches' => []];

        if ($bestThreshold === null) {
            // Atribut kategori
            $values = array_values(array_unique(array_column($data, $bestAttr)));
            foreach ($values as $val) {
                $subset = array_values(array_filter($data, fn($row) => $row[$bestAttr] == $val));

                if (empty($subset)) {
                    $tree['branches'][(string)$val] = ['label' => $this->majorityLabel($data)];
                } else {
                    $subAttr = array_values(array_diff($attributes, [$bestAttr]));
                    $tree['branches'][(string)$val] = $this->buildTree($subset, $subAttr, $depth + 1);
                }
            }
        } else {
            // Atribut numerik
            $left = array_values(array_filter($data, fn($row) => $row[$bestAttr] <= $bestThreshold));
            $right = array_values(array_filter($data, fn($row) => $row[$bestAttr] > $bestThreshold));

            $subAttr = array_values(array_diff($attributes, [$bestAttr]));
            $tree['branches']["<= " . round($bestThreshold, 6)] = $this->buildTree($left, $subAttr, $depth + 1);
            $tree['branches']["> " . round($bestThreshold, 6)] = $this->buildTree($right, $subAttr, $depth + 1);
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
        $threshold = $tree['threshold'] ?? null;
        $val = $input[$attr] ?? null;

        if ($threshold === null) {
            // Kategori - cast key ke string
            $key = is_array($val) ? implode(',', $val) : (string)$val;
            if (isset($tree['branches'][$key])) {
                return $this->diagnosa($input, $tree['branches'][$key]);
            }
        } else {
            if ($val !== null && is_numeric($val)) {
                if ($val <= $threshold) {
                    return $this->diagnosa($input, $tree['branches']["<= " . round($threshold, 6)]);
                } else {
                    return $this->diagnosa($input, $tree['branches']["> " . round($threshold, 6)]);
                }
            }
        }

        // Jika tidak cocok, kembalikan null atau mayoritas
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
            $input = [];
            foreach ($this->attributes as $attr) {
                $input[$attr] = $row[$attr] ?? null;
            }

            $predicted = $this->diagnosa($input, $tree);

            if ($predicted == ($row[$this->target] ?? null)) {
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
