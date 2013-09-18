<?php

namespace Tms\Bundle\LoggerBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LogController extends Controller
{
    /**
     * @Route("/logs.{_format}", name="tms_logger_api_logs_get", defaults={"_format"="json"})
     * @Method("GET")
     */
    public function exportLogsAction(Request $request)
    {
        $format = $request->getRequestFormat();
        die('toto');

        $logs = $this->get('tms_logger.logger_manager')->getLogs();
        $export = $this->get('idci_exporter.manager')->export($logs, $format);

        $response = new Response();
        $response->setContent($export->getContent());
        $response->headers->set(
            'Content-Type',
            sprintf('%s; charset=UTF-8', $export->getContentType())
        );

        return $response;
    }

    /**
     * @Route("/logs/{hash}.{_format}", name="tms_logger_api_logs_by_hash_get", defaults={"_format"="json"})
     * @Method("GET")
     */
    public function exportLogsByHashAction(Request $request, $hash)
    {
        $format = $request->getRequestFormat();

        $logs = $this->get('tms_logger.logger_manager')->getLogs($hash);
        $export = $this->get('idci_exporter.manager')->export($logs, $format);

        $response = new Response();
        $response->setContent($export->getContent());
        $response->headers->set(
            'Content-Type',
            sprintf('%s; charset=UTF-8', $export->getContentType())
        );

        return $response;
    }
}
