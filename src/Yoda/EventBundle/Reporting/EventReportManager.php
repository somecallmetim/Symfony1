<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 7/7/14
 * Time: 6:42 PM
 */

namespace Yoda\EventBundle\Reporting;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Monolog\Logger;

class EventReportManager
{

    private $em;
    private $logger;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    public function getRecentlyUpdatedReport()
    {
        $this->logInfo('Generating the recently updated events CSV!!!');
        $events = $this->em
            ->getRepository('EventBundle:Event')
            ->getRecentlyUpdatedEvents();

        $rows = array();
        foreach($events as $event){
            $data = array($event->getId(), $event->getName(), $event->getTime()->format('Y-m-d H:i:s'));

            $rows[] = implode(',', $data);
        }

        return implode("\n", $rows);
    }

    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }

    private function logInfo($msg)
    {
        if ($this->logger){
            $this->logger->info($msg);
        }
    }
} 