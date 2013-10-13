<?php

namespace Tms\Bundle\LoggerBundle\Event\Subscriber;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tms\Bundle\LoggerBundle\Logger\LoggerInterface;
use Tms\Bundle\LoggerBundle\Event\LogEvents;
use Tms\Bundle\LoggerBundle\Event\LogEvent;

class LoggerEventSubscriber implements EventSubscriberInterface
{
    protected $logger;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     * @param EntityManager $em
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->getLogger()->getEntityManager();
    }

    /**
     * {@inheritdoc}
     */
    static public function getSubscribedEvents()
    {
        return array(
            LogEvents::POST_CREATE => array('onCreatePost', 0),
            LogEvents::PRE_UPDATE  => array('onUpdatePre', 0),
            LogEvents::PRE_DELETE  => array('onDeletePre', 0),
        );
    }

    public function onCreatePost(LogEvent $event)
    {
        $this->getLogger()->log($event->getLoggableObject(), 'create');
    }

    public function onUpdatePre(LogEvent $event)
    {
        $entity = $event->getLoggableObject();
        $this->getLogger()->log(
            $entity,
            'update',
            json_encode($this->getLogger()->getEntityChangeSet($entity))
        );
    }

    public function onDeletePre(LogEvent $event)
    {
        $this->getLogger()->log($event->getLoggableObject(), 'delete');
    }
}
