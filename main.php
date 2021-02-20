<?php

use React\EventLoop\Factory;
use Rx\Observable;
use Rx\Observer\CallbackObserver;
use Rx\Scheduler;

require_once __DIR__ . '/vendor/autoload.php';

$loop = Factory::create();

//You only need to set the default scheduler once
Scheduler::setDefaultFactory(function() use($loop){
    return new Scheduler\EventLoopScheduler($loop);
});

$fruits = ['apple', 'banana', 'orange', 'raspberry'];

$observer = new CallbackObserver(
    function($value) { printf('%s', $value); },
    null,
    function() { print('Completed'); }
);

Observable::fromArray($fruits)
    ->map(function($value) {
        return strlen($value);
    })
    ->subscribe($observer);

$loop->run();
