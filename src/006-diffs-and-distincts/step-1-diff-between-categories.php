<?php
$input = [
    'categories-acc' => __DIR__.'/input/categories-acc.csv',
    'categories-prd' => __DIR__.'/input/categories-prd.csv',
];
$rows = [
    'categories' => [],
];

if (($handle = fopen($input['categories-prd'], 'rb')) !== false) {
    while (($data = fgetcsv($handle, 0, ';')) !== false) {
        $rows['categories'][$data[0]] = $data;
        $rows['categories-index']++;
    }
    fclose($handle);
}

if (($handle = fopen($input['categories-acc'], 'rb')) !== false) {
    while (($data = fgetcsv($handle, 0, ';')) !== false) {
        if (!(array_key_exists($data[0], $rows['categories']))) {
            echo $data[0]."\r\n";
        }
    }
    fclose($handle);
}

die('done');