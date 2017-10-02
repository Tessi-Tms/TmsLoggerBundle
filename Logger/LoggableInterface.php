<?php

/**
 * @author Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 */

namespace Tms\Bundle\LoggerBundle\Logger;

interface LoggableInterface
{
    /**
     * Get id.
     *
     * @return int|string Something which identify in an unique way an object
     */
    public function getId();

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt();
}
