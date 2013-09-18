<?php

namespace Tms\Bundle\LoggerBundle\Logger;

use Tms\Bundle\LoggerBundle\Entity\Log;

/**
 * LoggerManager
 */
class LoggerManager implements LoggerInterface
{
    protected $entityManager;
    
    /**
     * Constructor
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('TmsLoggerBundle:Log');
    }

    /**
     * @see Tms\Bundle\LoggerBundle\Logger.LoggerInterface::log()
     */
    public function log(LoggableInterface $object, $action, $information = null)
    {
        $log = new Log($object, $action, $information);
        $this->getEntityManager()->persist($log);
        $this->getEntityManager()->flush();
    }

    public function getObjectClassName(LoggableInterface $loggable)
    {
        $reflection = new \ReflectionClass($loggable);

        return $reflection->getClassName();
    }

    /**
     * @see Tms\Bundle\LoggerBundle\Logger.LoggerInterface::getLogs()
     */
    public function getLogs($hashOrLogi = null)
    {
        if (!$hashOrLogi) {
            return $this->getRepository()->findAll();
        }

        if ($hashOrLogi instanceof LoggableInterface) {
            return $this->getRepository()->findBy(array(
                'objectId' => $hashOrLogi->getId(),
                'objectClassName' => $this->getObjectClassName($hashOrLogi),
            ));
        }

        return $this->getRepository()->findBy(array('hash' => $hashOrLogi));
    }
}