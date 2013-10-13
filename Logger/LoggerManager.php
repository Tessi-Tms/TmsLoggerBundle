<?php

/**
 * @author Nathalie De Sousa <nathalie.de.sousa@tessi.fr>
 * @author Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 */

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

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('TmsLoggerBundle:Log');
    }

    /**
     * Get Object class name
     *
     * @param LoggableInterface $loggable
     * @return string
     */
    public function getObjectClassName(LoggableInterface $loggable)
    {
        $reflection = new \ReflectionClass($loggable);

        return $reflection->getClassName();
    }

    /**
     * Get entity change set
     *
     * @param $entity
     * @return array
     */
    public function getEntityChangeSet($entity)
    {
        /*
        if ($entity instanceof ) {
            return array();
        }
        */

        $uow = $this->getEntityManager()->getUnitOfWork();
        $classMetadata = $this->getEntityManager()->getClassMetadata(get_class($entity));
        $uow->computeChangeSet($classMetadata, $entity);

        return  $uow->getEntityChangeSet($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function log(LoggableInterface $loggable, $action, $information = null)
    {
        $log = new Log($loggable, $action, $information);
        $this->getEntityManager()->persist($log);
        $this->getEntityManager()->flush();
    }

    /**
     * {@inheritdoc}
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
