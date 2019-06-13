<?php
require_once __DIR__.'/../envs.php';

$searchBuilder = new \Akeneo\Pim\ApiClient\Search\SearchBuilder();
$searchBuilder->addFilter('sku', 'STARTS WITH', 'h');
$searchFilters = $searchBuilder->getFilters();

$count = 0;
$ignoreThese = [];
$products = $GLOBALS['destination']->getProductApi()->all(100, ['search' => $searchFilters]);
foreach ($products as $product) {
    if ($product['identifier'][0] === 'h' && !in_array($product['identifier'], $ignoreThese)) {
        $identifier = substr($product['identifier'], 1);
        echo 'Let\'s try to change \''.$product['identifier'].'\' into \''.$identifier.'\''."\n";
        $ok = true;
        try {
            $GLOBALS['destination']->getProductApi()->upsert($product['identifier'], ['identifier' => $identifier]);
        } catch (Exception $e) {
            $ok = false;
            prex($e);
        }
        if ($ok) {
            echo $count.' done'."\n";
            $count++;
        }
        if ($count >= 250) {
            die('done');
        }
    }
}

echo 'done';/**/