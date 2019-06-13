<?php
$input = [
    'products' => __DIR__.'/input/BR-PIM-ARTIKELSTAM-ori.TXT',
];
$headers = 'sku;barcode_1;supplier_1_order_code;title_short;supplier_1;supplier_1_purchase_price_net;price_trading;price_sale-nl_NL;price_advice;vat_code_NL;threshold_quantity;supplier_1_amount_order_factor';
$output = [
    'products' => __DIR__.'/output/br-import.csv',
];
$rows = [
    'products' => [],
    'products-index' => 1,
    'products-positions' => explode(';', $headers),
];

if (($handle = fopen($input['products'], 'rb')) !== false) {
    while (($data = fgetcsv($handle, 0, ';')) !== false) {
        $row = [];
        foreach ($data as $index => $value) {
            $row[$rows['products-positions'][$index]] = $value;
        }
        switch ($row['vat_code_NL']) {
            case 'H':
                $row['vat_code_NL'] = 2;
                break;
            case 'L':
                $row['vat_code_NL'] = 4;
                break;
            default:
                $row['vat_code_NL'] = 0;
        }
        $rows['products'][] = $row;
    }
    fclose($handle);
}

$separator = ';';
file_put_contents($output['products'], '');
$handle = fopen($output['products'], 'wb');
$first = false;
foreach ($rows['products'] as $product => $properties) {
    if (!$first) {
        fwrite($handle, implode($separator, array_keys($properties))."\n");
        $first = true;
    }
    fwrite($handle, implode($separator, array_values($properties))."\n");
}
fclose($handle);
die('done');