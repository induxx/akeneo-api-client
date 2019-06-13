<?php
$input = [
    'all' => __DIR__.'/input/GDSN_and_Shared_Code_Lists_3p1p7_i22Aug2018.csv',
    'gdsn' => __DIR__.'/input/GDSN picklists.csv',
];
$output = [
    'attributes' => __DIR__.'/output/attributes.csv',
    'google' => __DIR__.'/output/google.csv',
    'options' => __DIR__.'/output/options.csv',
];
$rows = [
    'attributes' => ['code;label-nl_BE;label-fr_BE;localizable;scopable;sort_order'],
    'attributes-index' => 0,
    'google' => [],
    'options' => ['code;label-nl_BE;label-fr_BE;attribute;sort_order'],
    'options-index' => 0,
];
$separator = ';';

$first = true;
if (($handle = fopen($input['gdsn'], 'rb')) !== false) {
    while (($data = fgetcsv($handle, 0, ';', '"')) !== false) {
        if (!$first) {
            $code = strtoupper($data[1]);
            $mapping[$code] = str_replace('.', '_', $data[0]);
        }
        $first = false;
    }
    fclose($handle);
}

$first = true;
if (($handle = fopen($input['all'], 'rb')) !== false) {
    while (($data = fgetcsv($handle, 0, ';', '"')) !== false) {
        if (!$first) {
            $code = strtoupper($data[1]);
            if (array_key_exists($code, $mapping)) {
                $code = $mapping[$code];
                if (!$data[2]) {
                    //$rows['attributes'][] = $code.$separator.$data[0].$separator.$data[0].$separator.'0'.$separator.'0'.$separator.$rows['attributes-index'];
                    $rows['attributes'][] = $code.$separator.$data[1].$separator.$data[1].$separator.'0'.$separator.'0'.$separator.$rows['attributes-index'];
                    $rows['attributes-index']++;
                    //$rows['google'][] = $data[1].$separator.$data[0].$separator.$data[0];
                    $rows['google'][] = $code;
                    $rows['options-index'] = 0;
                } else {
                    $rows['google'][] = $data[2].$separator.$data[3].$separator.$data[3];
                    $rows['options'][] = $data[2].$separator.$data[3].$separator.$data[3].$separator.$code.$separator.$rows['options-index'];
                    $rows['options-index']++;
                }
            }
        }
        $first = false;
    }
    fclose($handle);
}

file_put_contents($output['attributes'], '');
$handle = fopen($output['attributes'], 'wb');
foreach ($rows['attributes'] as $attribute => $properties) {
    fwrite($handle, $properties."\n");
}
fclose($handle);

file_put_contents($output['google'], '');
$handle = fopen($output['google'], 'wb');
foreach ($rows['google'] as $google => $properties) {
    fwrite($handle, $properties."\n");
}
fclose($handle);

file_put_contents($output['options'], '');
$handle = fopen($output['options'], 'wb');
foreach ($rows['options'] as $option => $properties) {
    fwrite($handle, $properties."\n");
}
fclose($handle);
die('done');