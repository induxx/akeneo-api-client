<?php
require_once __DIR__.'/../vendor/autoload.php';

$clientBuilder = new \Akeneo\Pim\ApiClient\AkeneoPimClientBuilder('http://localhost:8081');
$GLOBALS['origin'] = $clientBuilder->buildAuthenticatedByPassword(
    '1_akeneo_pim',
    'akeneo_pim',
    'admin',
    'admin'
);

$clientBuilder = new \Akeneo\Pim\ApiClient\AkeneoPimClientBuilder('http://localhost:8031');
$GLOBALS['destination'] = $clientBuilder->buildAuthenticatedByPassword(
    '1_akeneo_pim',
    'akeneo_pim',
    'admin',
    'admin'
);

function prex($e)
{
    $err = print_r($e, true);
    echo 'Message: '.trim(explode('[string:Exception:private] => ',
            explode('[message:protected] => ', $err)[1])[0])."\r\n";
    echo 'Json: '.trim(substr(trim(substr(trim(explode('[2] => Array', explode('[3] => ',
            explode('[function] => sendRequest', explode('trace:Exception:private', $err)[1])[1])[1])[0]), 0,
            -1)), 0,
            -1))."\r\n";

    //echo 'Exception:'."\r\n";/**/
    //print_r($e);
    //die();
}