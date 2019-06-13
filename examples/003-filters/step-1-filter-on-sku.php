<?php
require_once __DIR__.'/../envs.php';

$searchBuilder = new \Akeneo\Pim\ApiClient\Search\SearchBuilder();
$searchBuilder->addFilter('enabled', '=', true);
$searchBuilder->addFilter('sku', 'CONTAINS', 'chaquip');
$searchFilters = $searchBuilder->getFilters();

$products = $GLOBALS['origin']->getProductApi()->all(100, ['search' => $searchFilters]);
foreach ($products as $product) {
    echo $product['identifier']."\r\n";
}

echo 'done';/**/