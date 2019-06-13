<?php
require_once __DIR__.'/../envs.php';

$func = 'getAssociationTypeApi';

$items = $GLOBALS['origin']->{$func}()->all(100, []);
foreach ($items as $item) {
    $code = $item['code'];
    unset($item['code']);
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