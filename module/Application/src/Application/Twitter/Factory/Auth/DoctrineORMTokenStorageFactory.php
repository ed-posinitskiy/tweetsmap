<?php
/**
 * File contains class DoctrineORMTokenStorage
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Factory\Auth;

use Application\Twitter\Auth\DoctrineORMTokenStorage;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

/**
 * Class DoctrineORMTokenStorage
 *
 * @package Application\Twitter\Factory\Auth
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class DoctrineORMTokenStorageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var EntityManager $em */
        $em = $container->get('Doctrine\\ORM\\EntityManager');

        return new DoctrineORMTokenStorage($em);
    }
}