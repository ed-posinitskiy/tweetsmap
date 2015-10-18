<?php
/**
 * File contains class AuthenticationListenerFactory
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Auth\Factory;

use Application\Auth\AuthenticationListener;
use Application\Auth\AuthenticationStorage;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

/**
 * Class AuthenticationListenerFactory
 *
 * @package Application\Auth\Factory
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class AuthenticationListenerFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return AuthenticationListener
     */
    public function __invoke(ContainerInterface $container)
    {
        /** @var EntityManager $em */
        $em = $container->get('Doctrine\\ORM\\EntityManager');

        /** @var AuthenticationStorage $storage */
        $storage = $container->get('app.auth.storage');

        return new AuthenticationListener($storage, $em);
    }
}