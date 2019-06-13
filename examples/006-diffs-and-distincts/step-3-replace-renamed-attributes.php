<?php
$bools = [
    'exclude-labels' => false,
];
$input = [
    'categories-acc' => __DIR__.'/input/categories-acc.csv',
    'categories-prd' => __DIR__.'/input/categories-prd.csv',
    'mapping' => __DIR__.'/input/mapping.csv',
];
$output = [
    'categories' => __DIR__.'/output/categories.csv',
];
$rows = [
    'categories' => [],
    'categories-index' => 1,
    'categories-positions' => [],
];

$mapping = [];
if (($handle = fopen($input['mapping'], 'rb')) !== false) {
    while (($data = fgetcsv($handle, 0, ';')) !== false) {
        if ($data[0] !== '') {
            $mapping[$data[0]] = $data[1];
        }
    }
}

$attributes = [];
if (($handle = fopen($input['categories-prd'], 'rb')) !== false) {
    while (($data = fgetcsv($handle, 0, ';')) !== false) {
        switch ($rows['categories-index']) {
            case 1:
                if ($bools['exclude-labels']) {
                    unset($data[1], $data[2]);
                }
                $rows['categories-positions'] = array_merge($data, ['disabledByParent', 'enabled']);
                break;
            default:
                if ($bools['exclude-labels']) {
                    unset($data[1], $data[2]);
                }
                if ($data[3] !== '') {
                    $new = [];
                    $attributes = explode(',', $data[3]);
                    foreach ($attributes as $attribute) {
                        $new[] = $mapping[$attribute];
                    }
                    $data[3] = implode(',', $new);
                }
                $rows['categories'][] = array_merge($data, ['0', '1']);
                break;
        }
        $rows['categories-index']++;
    }
    fclose($handle);
}

$separator = ';';
file_put_contents($output['categories'], '');
$handle = fopen($output['categories'], 'wb');
$first = false;
foreach ($rows['categories'] as $category => $properties) {
    if (!$first) {
        fwrite($handle, implode($separator, $rows['categories-positions'])."\n");
        $first = true;
    }
    fwrite($handle, implode($separator, $properties)."\n");
}
fclose($handle);
die('done');