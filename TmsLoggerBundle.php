<?php

namespace Tms\Bundle\LoggerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tms\Bundle\LoggerBundle\DependencyInjection\TmsLoggerExtension;

class TmsLoggerBundle extends Bundle
{
    public function __construct()
    {
        $this->extension = new TmsLoggerExtension();
    }
}
