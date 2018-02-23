<?php

namespace Anax\Database;

use \Anax\Common\ConfigureInterface;
use \Anax\Common\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * Namespaced exception.
 */
class DatabaseConfigure extends Database implements ConfigureInterface, InjectionAwareInterface
{
    use ConfigureTrait {
        configure as protected loadConfiguration;
    }

    use InjectionAwareTrait;



    /**
     * Load and apply configurations.
     *
     * @param array|string $what is an array with key/value config options
     *                           or a file to be included which returns such
     *                           an array.
     *
     * @return void
     */
    public function configure($what)
    {
        $this->loadConfiguration($what);
        parent::setOptions($this->config);
    }
}
