<?php
require_once __DIR__.'/../envs.php';

$func = 'getAttributeApi';

$ignoreImageFields = [];
$items = $GLOBALS['origin']->{$func}()->all(100, []);
foreach ($items as $item) {
    if ($item['type'] === 'pim_catalog_image') {
        $ignoreImageFields[] = $item['code'];
    }
}

$func = 'getProductApi';

$items = $GLOBALS['origin']->{$func}()->all(100, []);
foreach ($items as $item) {
    $code = $item['identifier'];
    unset($item['identifier']);
    unset($item['values']['images']);
    foreach ($ignoreImageFields as $ignoreImageField) {
        unset($item['values'][$ignoreImageField]);
    }
    unset($item['_links']);
    echo $code."\r\n";
    try {
        $GLOBALS['destination']->{$func}()->create($code, $item);
    } catch (Exception $e) {
        try {
            $GLOBALS['destination']->{$func}()->upsert($code, $item);
        } catch (Exception $e) {
            prex($e);
        }
    }
}

echo 'done';/**/