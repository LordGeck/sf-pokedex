<?php

namespace App\Controller;

use Symfony\Component\Stopwatch\Stopwatch;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */
class Utils
{
    /**
     * @param $routeName
     * @param Request $request
     * @param Stopwatch $stopwatch
     */
    public static function logPerformance($routeName, Stopwatch $stopwatch, LoggerInterface $logger, Request $request){
        $event = $stopwatch->stop($routeName);
        $logger->info('Completed route "'.$routeName.'". Path : '.$request->getRequestUri().'. Duration : '.$event->getDuration().' ms, Max Memory Usage : '.$event->getMemory().' octets');
    }
}
