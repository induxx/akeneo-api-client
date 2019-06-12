<?php
require_once __DIR__.'/../envs.php';

//https://docs.akeneo.com/2.3/manipulate_pim_data/product/query.html#instantiate-a-new-product-query-builder
$searchBuilder = new \Akeneo\Pim\ApiClient\Search\SearchBuilder();
$searchBuilder->addFilter('brand', 'IN', ['asus']);
$searchFilters = $searchBuilder->getFilters();

$count = 5000;
$products = $GLOBALS['origin']->getProductApi()->all(100, ['search' => $searchFilters]);
foreach ($products as $product) {
    print_r($product['metadata']);die();
    echo $product['identifier']."\r\n";
}

echo 'done';