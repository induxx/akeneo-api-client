<?php
require_once __DIR__.'/../envs.php';

$func = 'getFamilyApi';
$funcInner = 'getFamilyVariantApi';

$items = $GLOBALS['destination']->{$func}()->all(100, []);
foreach ($items as $item) {
    $code = $item['code'];
    try {
        $itemsInner = $GLOBALS['origin']->{$funcInner}()->all($code, 100, []);
        foreach ($itemsInner as $itemInner) {
            $codeInner = $itemInner['code'];
            unset($itemInner['code']);
            unset($itemInner['_links']);
            echo $codeInner."\r\n";
            try {
                $GLOBALS['destination']->{$funcInner}()->create($code, $codeInner, $itemInner);
            } catch (Exception $e) {
                try {
                    $GLOBALS['destination']->{$funcInner}()->upsert($code, $codeInner, $itemInner);
                } catch (Exception $e) {
                    prex($e);
                }
                //prex($e);
            }
        }
    } catch (Exception $e) {
        prex($e);
    }
}

echo 'done';/**/