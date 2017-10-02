<?php

namespace Tms\Bundle\LoggerBundle\Twig;

use Tms\Bundle\LoggerBundle\Entity\Log;
use Tms\Bundle\LoggerBundle\Logger\LoggableInterface;

class LoggerExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('tms_logger_hash', array($this, 'getHash')),
        );
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
