<?php
$input = [
    'families' => __DIR__.'/input/families.csv',
];
$minimal = [
    'attributes' => explode(',',
        'media_gallery_disabled_1,media_gallery_disabled_2,media_gallery_disabled_3,media_gallery_disabled_4,media_gallery_disabled_5,media_gallery_disabled_6,media_gallery_disabled_7,media_gallery_disabled_8,media_gallery_disabled_9,media_gallery_disabled_10'),
];
$output = [
    'families' => __DIR__.'/output/families.csv',
];
$rows = [
    'families' => [],
    'families-index' => 1,
    'families-positions' => [],
];

if (($handle = fopen($input['families'], 'rb')) !== false) {
    while (($data = fgetcsv($handle, 0, ';')) !== false) {
        switch ($rows['families-index']) {
            case 1:
                $rows['families-positions'] = $data;
                break;
            default:
                $changes = [];
                $row = [];
                foreach ($data as $index => $value) {
                    $property = $rows['families-positions'][$index];
                    switch ($property) {
                        case 'attributes':
                            if (array_key_exists($property, $minimal)) {
                                $values = explode(',', $value);
                                foreach ($minimal[$property] as $attribute) {
                                    if (!in_array($attribute, $values, true)) {
                                        $changes[$property][] = $attribute;
                                        $values[] = $attribute;
                                    }
                                }
                                $value = implode(',', $values);
                            }
                            break;
                    }
                    $row[$property] = $value;
                }
                if (count($changes)) {
                    echo $data[0] . "\r\n";
                    foreach($changes as $change => $what){
                        echo '    ' . $change . ': ' . implode(',', $what) . "\r\n";
                    }
                    echo "\r\n";
                }
                $rows['families'][] = $row;
                break;
        }
        $rows['families-index']++;
    }
    fclose($handle);
}

$separator = ';';
file_put_contents($output['families'], '');
$handle = fopen($output['families'], 'wb');
$first = false;
foreach ($rows['families'] as $family => $properties) {
    if (!$first) {
        fwrite($handle, implode($separator, array_keys($properties))."\n");
        $first = true;
    }
    fwrite($handle, implode($separator, array_values($properties))."\n");
}
fclose($handle);
die('done');