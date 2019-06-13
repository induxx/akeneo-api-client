<?php
$input = [
    'families' => __DIR__.'/input/families.csv',
];
$minimal = [
    'attributes' => explode(',',
        'barcode_1,barcode_2,barcode_3,barcode_4,barcode_5,title_short,dropshipment,fifo,packing_instructions,pallet_article,place_in_store_hall,place_in_store_zone,price_trading,shipping_category,shipping_ready,split_after_picking,type_product,type_retail,bundle_composition,compatibility_list,visibility,show_separately,threshold_quantity,vat_code_BE,vat_code_DE,vat_code_ES,vat_code_FR,vat_code_GB,vat_code_IT,vat_code_NL,vat_code_PL,vat_code_SE,supplier_1,supplier_1_amount_order_factor,supplier_1_amount_order_min,supplier_1_deliverability,supplier_1_order_code,supplier_1_preferred,supplier_1_purchase_price_net,supplier_1_wms_barcode_1,supplier_1_wms_barcode_1_amount,supplier_1_wms_barcode_2,supplier_1_wms_barcode_2_amount,supplier_1_wms_barcode_3,supplier_1_wms_barcode_3_amount,supplier_1_wms_barcode_4,supplier_1_wms_barcode_4_amount,supplier_1_wms_barcode_5,supplier_1_wms_barcode_5_amount,supplier_2,supplier_2_amount_order_factor,supplier_2_amount_order_min,supplier_2_deliverability,supplier_2_order_code,supplier_2_preferred,supplier_2_purchase_price_net,supplier_2_wms_barcode_1,supplier_2_wms_barcode_1_amount,supplier_2_wms_barcode_2,supplier_2_wms_barcode_2_amount,supplier_2_wms_barcode_3,supplier_2_wms_barcode_3_amount,supplier_2_wms_barcode_4,supplier_2_wms_barcode_4_amount,supplier_2_wms_barcode_5,supplier_2_wms_barcode_5_amount,supplier_3,supplier_3_amount_order_factor,supplier_3_amount_order_min,supplier_3_deliverability,supplier_3_order_code,supplier_3_preferred,supplier_3_purchase_price_net,supplier_3_wms_barcode_1,supplier_3_wms_barcode_1_amount,supplier_3_wms_barcode_2,supplier_3_wms_barcode_2_amount,supplier_3_wms_barcode_3,supplier_3_wms_barcode_3_amount,supplier_3_wms_barcode_4,supplier_3_wms_barcode_4_amount,supplier_3_wms_barcode_5,supplier_3_wms_barcode_5_amount,supplier_4,supplier_4_amount_order_factor,supplier_4_amount_order_min,supplier_4_deliverability,supplier_4_order_code,supplier_4_preferred,supplier_4_purchase_price_net,supplier_4_wms_barcode_1,supplier_4_wms_barcode_1_amount,supplier_4_wms_barcode_2,supplier_4_wms_barcode_2_amount,supplier_4_wms_barcode_3,supplier_4_wms_barcode_3_amount,supplier_4_wms_barcode_4,supplier_4_wms_barcode_4_amount,supplier_4_wms_barcode_5,supplier_4_wms_barcode_5_amount,supplier_5,supplier_5_amount_order_factor,supplier_5_amount_order_min,supplier_5_deliverability,supplier_5_order_code,supplier_5_preferred,supplier_5_purchase_price_net,supplier_5_wms_barcode_1,supplier_5_wms_barcode_1_amount,supplier_5_wms_barcode_2,supplier_5_wms_barcode_2_amount,supplier_5_wms_barcode_3,supplier_5_wms_barcode_3_amount,supplier_5_wms_barcode_4,supplier_5_wms_barcode_4_amount,supplier_5_wms_barcode_5,supplier_5_wms_barcode_5_amount'),
    'requirements-ecommerce' => explode(',',
        'barcode_1,is_active,price_sale'),
];
$output = [
    'families' => __DIR__.'/output/families-with-reqs.csv',
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
                        case 'requirements-ecommerce':
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