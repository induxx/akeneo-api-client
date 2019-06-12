<?php
/*
vagrant ssh
cd pim
mysql -u akeneo_pim -p
akeneo_pim
use akeneo_pim;
SELECT ID FROM pim_versioning_version WHERE changeset LIKE '%%"hat"%%';
SELECT snapshot FROM pim_versioning_version WHERE ID = '8641';

a:40:{s:6:"family";s:11:"accessories";s:6:"groups";s:0:"";s:10:"categories";s:35:"men_hats,supplier_abibas,women_hats";s:6:"parent";s:0:"";s:13:"X_SELL-groups";s:0:"";s:15:"X_SELL-products";s:0:"";s:21:"X_SELL-product_models";s:0:"";s:13:"UPSELL-groups";s:0:"";s:15:"UPSELL-products";s:0:"";s:21:"UPSELL-product_models";s:0:"";s:19:"SUBSTITUTION-groups";s:0:"";s:21:"SUBSTITUTION-products";s:0:"";s:27:"SUBSTITUTION-product_models";s:0:"";s:11:"PACK-groups";s:0:"";s:13:"PACK-products";s:0:"";s:19:"PACK-product_models";s:0:"";s:13:"outfit-groups";s:0:"";s:15:"outfit-products";s:0:"";s:21:"outfit-product_models";s:0:"";s:10:"set-groups";s:0:"";s:12:"set-products";s:0:"";s:18:"set-product_models";s:0:"";s:11:"best_seller";s:1:"0";s:9:"clearance";s:1:"0";s:11:"collections";s:11:"spring_2018";s:27:"description-de_DE-ecommerce";s:35:"Bonnet gerippt grau und mehrfarbig.";s:21:"description-en_US-b2b";s:36:"Bonnet ribbed gray and multicolored.";s:27:"description-en_US-ecommerce";s:36:"Bonnet ribbed gray and multicolored.";s:14:"erp_name-en_US";s:3:"Hat";s:8:"imported";s:1:"0";s:10:"name-de_DE";s:6:"Mütze";s:10:"name-en_US";s:3:"Hat";s:9:"price-EUR";s:6:"199.00";s:23:"short_description-de_DE";s:35:"Bonnet gerippt grau und mehrfarbig.";s:23:"short_description-en_US";s:36:"Bonnet ribbed gray and multicolored.";s:3:"sku";s:3:"hat";s:8:"supplier";s:0:"";s:6:"weight";s:2:"98";s:11:"weight-unit";s:8:"KILOGRAM";s:7:"enabled";i:0;}

/**/
?>