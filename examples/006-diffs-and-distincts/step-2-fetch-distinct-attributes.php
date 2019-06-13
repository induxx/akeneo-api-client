<?php
$input = [
    'categories' => __DIR__.'/input/categories-prd.csv',
];
$rows = [
    'categories-index' => 1,
];

$attributes = [];
if (($handle = fopen($input['categories'], 'rb')) !== false) {
    while (($data = fgetcsv($handle, 0, ';')) !== false) {
        $attributes = array_unique(array_merge($attributes, explode(',', $data[3])));
        $rows['categories-index']++;
    }
    fclose($handle);
}

foreach ($attributes as $attribute) {
    if ($attribute !== '') {
        echo $attribute."\r\n";
    }
}
die('done');