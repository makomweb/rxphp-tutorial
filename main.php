<?php

use React\EventLoop\Factory;
use Rx\Observable;
use Rx\Observer\CallbackObserver;
use Rx\Scheduler;
use Rx\Scheduler\EventLoopScheduler;

require_once __DIR__ . '/vendor/autoload.php';

$loop = Factory::create();

//You only need to set the default scheduler once
Scheduler::setDefaultFactory(function() use($loop){
    return new EventLoopScheduler($loop);
});

$fruits = ['apple', 'banana', 'orange', 'raspberry'];

Observable::fromArray($fruits)
    ->subscribe(
        function($value) {
            if (strcmp($value, 'orange') === 0) {
                throw new Exception('Oranges are not allowed!');
            }
            printf('%s: %d' . PHP_EOL, $value, strlen($value));
        },
        function (Exception $error) {
            printf('error: %s' . PHP_EOL, $error->getMessage());
            print('(completed)' . PHP_EOL);
        },
        function() {
            print('completed'. PHP_EOL);
        }
    );

$loop->run();
