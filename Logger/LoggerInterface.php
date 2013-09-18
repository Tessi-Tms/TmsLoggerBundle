<?php

namespace Tms\Bundle\LoggerBundle\Logger;

/**
 * 
 */
interface LoggerInterface
{
	/**
	 * Log
	 * 
	 * @param LoggableInterface $object
	 * @param string $action
	 * @param string $information
	 */
	public function log(LoggableInterface $object, $action, $information = null);
	
	/**
	 * Return Logs
	 * @param unknown_type $search
	 */
	public function getLogs($search = null);
}
