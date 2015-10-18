<?php
/**
 * File contains class AuthenticationStorageFactory
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Auth\Factory;

use Application\Auth\AuthenticationStorage;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\Session\Container;

/**
 * Class AuthenticationStorageFactory
 *
 * @package Application\Auth\Factory
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class AuthenticationStorageFactory
{

    public function __invoke(ContainerInterface $container)
    {
        /** @var EntityManager $em */
        $em        = $container->get('Doctrine\\ORM\\EntityManager');
        $container = new Container('identity');

        return new AuthenticationStorage($em, $container);
    }

}