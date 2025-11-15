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

        $entropyAfter = 0;
        foreach ($values as $subset) {
            $entropyAfter += (count($subset) / $total) * $this->entropy($subset);
        }

        return $entropyBefore - $entropyAfter;
    }

    // Hitung SplitInfo
    protected function splitInfo($data, $splits)
    {
        $total = count($data);
        $splitInfo = 0;
        foreach ($splits as $subset) {
            $p = count($subset) / $total;
            if ($p > 0) {
                $splitInfo -= $p * log($p, 2);
            }
        }
        return $splitInfo;
    }

    // Hitung GainRatio (untuk kategori maupun numerik)
    // Hitung GainRatio (untuk kategori maupun numerik)
    protected function gainRatio($data, $attribute)
    {
        // Cegah error kalau dataset kosong
        if (empty($data)) {
            return ['gain_ratio' => 0, 'threshold' => null];
        }

        // Ambil baris pertama secara aman
        $firstRow = reset($data);
        if (!isset($firstRow[$attribute])) {
            return ['gain_ratio' => 0, 'threshold' => null];
        }

        $isNumeric = is_numeric($firstRow[$attribute]);

        if (!$isNumeric) {
            // --- Atribut kategori ---
            $total = count($data);
            $gain = $this->gain($data, $attribute);

            $values = [];
            foreach ($data as $row) {
                $val = $row[$attribute];
                $values[$val][] = $row;
            }

            $splitInfo = $this->splitInfo($data, $values);
            $gainRatio = ($splitInfo == 0) ? 0 : $gain / $splitInfo;

            $this->trace['gain_ratio'][] = [
                'attribute'  => $attribute,
                'type'       => 'categorical',
                'gain'       => round($gain, 4),
                'split_info' => round($splitInfo, 4),
                'gain_ratio' => round($gainRatio, 4)
            ];

            return ['gain_ratio' => $gainRatio, 'threshold' => null];
        } else {
            // --- Atribut numerik ---
            $sorted = $data;
            usort($sorted, fn($a, $b) => $a[$attribute] <=> $b[$attribute]);

            $bestGR = -INF;
            $bestThreshold = null;

            for ($i = 0; $i < count($sorted) - 1; $i++) {
                $currVal = $sorted[$i][$attribute];
                $nextVal = $sorted[$i + 1][$attribute];
                if ($currVal == $nextVal) continue;

                $threshold = ($currVal + $nextVal) / 2;

                $left = array_filter($data, fn($row) => $row[$attribute] <= $threshold);
                $right = array_filter($data, fn($row) => $row[$attribute] > $threshold);

                $entropyBefore = $this->entropy($data);
                $entropyAfter = (count($left) / count($data)) * $this->entropy($left)
                    + (count($right) / count($data)) * $this->entropy($right);
                $gain = $entropyBefore - $entropyAfter;

                $splitInfo = $this->splitInfo($data, [$left, $right]);
                $gainRatio = ($splitInfo == 0) ? 0 : $gain / $splitInfo;

                if ($gainRatio > $bestGR) {
                    $bestGR = $gainRatio;
                    $bestThreshold = $threshold;
                }
            }

            $this->trace['gain_ratio'][] = [
                'attribute'  => $attribute,
                'type'       => 'numeric',
                'threshold'  => $bestThreshold,
                'gain_ratio' => round($bestGR, 4)
            ];

            return ['gain_ratio' => $bestGR, 'threshold' => $bestThreshold];
        }
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

        // Cari atribut terbaik dengan Gain Ratio
        $bestAttr = null;
        $bestGR = -INF;
        $bestThreshold = null;

        foreach ($attributes as $attr) {
            $result = $this->gainRatio($data, $attr);
            if ($result['gain_ratio'] > $bestGR) {
                $bestGR = $result['gain_ratio'];
                $bestAttr = $attr;
                $bestThreshold = $result['threshold'];
            }
        }

        $this->trace['tree'][] = str_repeat("—", $depth)
            . " Pilih atribut: $bestAttr"
            . ($bestThreshold !== null ? " <= $bestThreshold" : "")
            . " (GainRatio=" . round($bestGR, 3) . ")";

        $tree = ['attribute' => $bestAttr, 'threshold' => $bestThreshold, 'branches' => []];

        if ($bestThreshold === null) {
            // Atribut kategori
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
        } else {
            // Atribut numerik
            $left = array_filter($data, fn($row) => $row[$bestAttr] <= $bestThreshold);
            $right = array_filter($data, fn($row) => $row[$bestAttr] > $bestThreshold);

            $subAttr = array_diff($attributes, [$bestAttr]);
            $tree['branches']["<= $bestThreshold"] = $this->buildTree($left, $subAttr, $depth + 1);
            $tree['branches']["> $bestThreshold"] = $this->buildTree($right, $subAttr, $depth + 1);
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

        if ($threshold === null) {
            // Kategori
            $val = $input[$attr] ?? null;
            if (isset($tree['branches'][$val])) {
                return $this->diagnosa($input, $tree['branches'][$val]);
            }
        } else {
            // Numerik
            $val = $input[$attr] ?? null;
            if ($val !== null) {
                if ($val <= $threshold) {
                    return $this->diagnosa($input, $tree['branches']["<= $threshold"]);
                } else {
                    return $this->diagnosa($input, $tree['branches']["> $threshold"]);
                }
            }
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
            $input = [];
            foreach ($this->attributes as $attr) {
                $input[$attr] = $row[$attr];
            }

            $predicted = $this->diagnosa($input, $tree);

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
