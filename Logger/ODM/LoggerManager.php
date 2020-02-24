<?php

/**
 * @author Nabil Mansouri <nabil.mansouri@tessi.fr>
 */

namespace Tms\Bundle\LoggerBundle\Logger\ODM;

use Tms\Bundle\LoggerBundle\Entity\Log;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

/**
 * LoggerManager.
 */
class LoggerManager implements LoggerInterface
{
    protected $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->managerRegistry->getManagerForClass('Tms\Bundle\LoggerBundle\Entity\Log');
    }

    /**
     * @return EntityRepository
     */
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('TmsLoggerBundle:Log');
    }

    /**
     * Get Object class name.
     *
     * @param LoggableInterface $loggable
     *
     * @return string
     */
    public function getObjectClassName(LoggableInterface $loggable)
    {
        $reflection = new \ReflectionClass($loggable);

        return $reflection->getClassName();
    }

    /**
     * Get entity change set.
     *
     * @param $entity
     *
     * @return array
     */
    public function getEntityChangeSet($entity)
    {
        $uow = $this->getEntityManager()->getUnitOfWork();
        $classMetadata = $this->getEntityManager()->getClassMetadata(get_class($entity));
        $uow->computeChangeSet($classMetadata, $entity);

        return $uow->getEntityChangeSet($entity);
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
