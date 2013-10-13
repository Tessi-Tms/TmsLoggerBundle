<?php

namespace Tms\Bundle\LoggerBundle\Event;

/**
 * LogEvents
 *
 * @author Gabriel Bondaz <gabriel.bondaz@idci-consulting.fr>
 */
final class LogEvents
{
    /**
     * @var string
     */
    const PRE_CREATE = 'tms_logger.log.pre_create';
    const POST_CREATE = 'tms_logger.log.post_create';

    const PRE_UPDATE = 'tms_logger.log.pre_update';
    const POST_UPDATE = 'tms_logger.log.post_update';

    const PRE_DELETE = 'tms_logger.log.pre_delete';
    const POST_DELETE = 'tms_logger.log.post_delete';
}
