<?php

namespace Tms\Bundle\LoggerBundle\Controller\Rest;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use JMS\Serializer\SerializationContext;

class ApiLogController extends FOSRestController
{
    /**
     * [GET] /logs
     * Retrieve all logs.
     *
     * @param Request $request
     */
    public function getLogsAction(Request $request)
    {
        $entities = $this->get('tms_logger.logger_manager')->getLogs();
        $context = SerializationContext::create()->setGroups(array('list'));
        $view = $this->view($entities, Codes::HTTP_OK);
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * [GET] /logs/{hash}/hash.{format}
     * Retrieve all logs associated to a hash.
     *
     * @param Request $request
     * @param string  $hash
     */
    public function getLogsHashAction(Request $request, $hash)
    {
        $logs = $this->get('tms_logger.logger_manager')->getLogs($hash);
        if (!$logs) {
            $view = $this->view(array(), Codes::HTTP_NOT_FOUND);

            return $this->handleView($view);
        }

        $context = SerializationContext::create()->setGroups(array('details'));
        $view = $this->view($logs, Codes::HTTP_OK);
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }
}
