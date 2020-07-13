<?php

namespace Tms\Bundle\LoggerBundle\Twig;

use Tms\Bundle\LoggerBundle\Entity\Log;
use Tms\Bundle\LoggerBundle\Logger\LoggableInterface;
use Tms\Bundle\LoggerBundle\Logger\LoggerInterface;

class LoggerExtension extends \Twig_Extension
{
    /**
     * Constructor.
     *
     * @param LoggerInterface $loggerManager
     */
    public function __construct(LoggerInterface $loggerManager)
    {
        $this->loggerManager = $loggerManager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('tms_logger_hash', array($this, 'getHash')),
            new \Twig_SimpleFunction('tms_logger_logs', array($this, 'getLogs')),
        );
    }

    public function getLogs(LoggableInterface $loggable)
    {
        return $this->loggerManager->getLogs($loggable);
    }

    public function getHash(LoggableInterface $loggable)
    {
        return Log::generateHash($loggable);
    }

    public function getName()
    {
        return 'tms_logger.twig.logger_extension';
    }
}
