<?php

/**
 * @author Nathalie De Sousa <nathalie.de.sousa@tessi.fr>
 * @author Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author Nabil Mansouri <nabil.mansouri@tessi.fr>
 */

namespace Tms\Bundle\LoggerBundle\Logger;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Tms\Bundle\LoggerBundle\Entity\Log;
use Tms\Bundle\SecurityBundle\Security\User\TmsOAuthUser;
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
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @param ManagerRegistry       $managerRegistry Instance of ManagerRegistry
     * @param TokenStorageInterface $tokenStorage    Instance of TokenStorageInterface
     */
    public function __construct(ManagerRegistry $managerRegistry, TokenStorageInterface $tokenStorage)
    {
        $this->managerRegistry = $managerRegistry;
        $this->tokenStorage = $tokenStorage;
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

        return $reflection->getName();
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
        $log->setUser($this->getCurrentUser());

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

    /**
     * @return string|null
     */
    private function getCurrentUser()
    {
        $token = $this->tokenStorage->getToken();
        if (null !== $token && $token->getUser() instanceof TmsOAuthUser) {
            $user = $token->getUser();
            return $user->getDisplayName();
        }

        return null;
    }
}
