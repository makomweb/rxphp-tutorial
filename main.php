<?php

use Rx\Observable;
use Rx\Observer\CallbackObserver;

require_once __DIR__ . '/vendor/autoload.php';

$fruits = ['apple', 'banana', 'orange', 'raspberry'];

$observer = new CallbackObserver(
    function($value) { printf('%s\n', $value); },
    null,
    function() { print('Completed\n'); }
);

Observable::fromArray($fruits)
    ->map(function($value) {
        return strlen($value);
    })
    ->subscribe($observer);

