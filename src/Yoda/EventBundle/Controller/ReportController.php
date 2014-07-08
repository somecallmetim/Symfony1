<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 7/7/14
 * Time: 6:19 PM
 */

namespace Yoda\EventBundle\Controller;


use Symfony\Component\HttpFoundation\Response;
use Yoda\EventBundle\Reporting\EventReportManager;

class ReportController extends Controller
{
    public function updatedEventsAction()
    {
        //once service is called, if a controller tries to create a new instance of that service,
        //the original service is used instead
        $reportManager = $this->container->get('yoda_event.reporting.event_report_manager');
        $content = $reportManager->getRecentlyUpdatedReport();

        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/csv');

        return $response;
    }


} 