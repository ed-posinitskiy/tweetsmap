<?php
/**
 * File contains class HistoryTrackerFactory
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Service\Factory;

use Application\Auth\AuthenticationStorage;
use Application\Service\HistoryTracker;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

/**
 * Class HistoryTrackerFactory
 *
 * @package Application\Service\Factory
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class HistoryTrackerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var EntityManager $em */
        $em          = $container->get('Doctrine\\ORM\\EntityManager');
        /** @var AuthenticationStorage $authStorage */
        $authStorage = $container->get('app.auth.storage');

        return new HistoryTracker($authStorage, $em);
    }
}