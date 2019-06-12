<?php
require_once __DIR__.'/../envs.php';

function fixIt()
{
    return [
        'values' => [
            'erp_name' => [
                [
                    'data' => 'HatHatHat',
                    'locale' => 'en_US',
                    'scope' => null,
                ],
            ],
        ],
    ];
}

//https://docs.akeneo.com/2.3/manipulate_pim_data/product/query.html#instantiate-a-new-product-query-builder
$searchBuilder = new \Akeneo\Pim\ApiClient\Search\SearchBuilder();
$searchBuilder->addFilter('sku', '=', 'hat');
$searchFilters = $searchBuilder->getFilters();

$count = 100000;
$products = $GLOBALS['destination']->getProductApi()->all(100, ['search' => $searchFilters]);
foreach ($products as $product) {
    try {
        $GLOBALS['destination']->getProductApi()->upsert($product['identifier'], fixIt());
    } catch (Exception $e) {
        prex($e);
    }
}

echo 'done';/**/