<?php

namespace App\Controller;

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
    public static function logPerformance($routeName, \Symfony\Component\Stopwatch\Stopwatch $stopwatch, \Psr\Log\LoggerInterface $logger, \Symfony\Component\HttpFoundation\Request $request){
        $event = $stopwatch->stop($routeName);
        $logger->info('Completed route "'.$routeName.'". Path : '.$request->getRequestUri().'. Duration : '.$event->getDuration().' ms, Max Memory Usage : '.$event->getMemory().' octets');
    }
}
