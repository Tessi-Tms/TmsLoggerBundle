<?php

namespace Tms\Bundle\LoggerBundle\Twig;

use Tms\Bundle\LoggerBundle\Entity\Log;
use Tms\Bundle\LoggerBundle\Logger\LoggableInterface;

class LoggerExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            'tms_logger_hash' => new \Twig_Function_Method($this, 'getHash'),
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