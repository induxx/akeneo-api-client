<?php
require_once __DIR__.'/../envs.php';

$searchBuilder = new \Akeneo\Pim\ApiClient\Search\SearchBuilder();
$searchBuilder->addFilter('enabled', '=', true);
$searchBuilder->addFilter('sku', 'CONTAINS', 'chaquip');
$searchFilters = $searchBuilder->getFilters();

$ean = 1234567890123;
$products = $GLOBALS['origin']->getProductApi()->all(100, ['search' => $searchFilters]);
foreach ($products as $product) {
    //print_r($product);die();
    try {
        $ean++;
        $GLOBALS['origin']->getProductApi()->upsert($product['identifier'], pushThis("".$ean));
        echo $product['identifier'].': ok'."\r\n";
    } catch (Exception $e) {
        //print_r($e);die();
        echo $product['identifier'].': not ok'."\r\n";
    }
}

echo 'done';/**/

function pushThis($ean)
{
    return [
        'values' => [
            'ean' => [
                [
                    'data' => $ean,
                    'locale' => null,
                    'scope' => null,
                ],
            ]
        ],
    ];
}