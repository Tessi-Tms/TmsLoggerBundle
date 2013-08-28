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

    /**
     * {@inheritDoc}
     */
	public function log(LoggableInterface $object, $action, $information = null)
	{
		$log = new Log($object, $action, $information);
		$this->getEntityManager()->persist($log);
		$this->getEntityManager()->flush();
	}
}