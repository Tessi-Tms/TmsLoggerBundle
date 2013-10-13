<?php

namespace Tms\Bundle\LoggerBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Tms\Bundle\LoggerBundle\Logger\LoggableInterface;

/**
 * LogEvent
 *
 * @author Gabriel Bondaz <gabriel.bondaz@idci-consulting.fr>
 */
class LogEvent extends Event
{
    protected $loggableObject;

    /**
     * Contructor
     * 
     * @param LoggableInterface $loggableObject
     */
    public function __construct(LoggableInterface $loggableObject)
    {
        $this->loggableObject = $loggableObject;
    }

    /**
     * @return LoggableInterface
     */
    public function getLoggableObject()
    {
        return $this->loggableObject;
    }
}
