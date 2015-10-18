<?php
/**
 * File contains class AuthenticationListener
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Auth;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

/**
 * Class AuthenticationListener
 *
 * @package Application\Auth
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class AuthenticationListener extends AbstractListenerAggregate
{

    /**
     * @var AuthenticationStorage
     */
    protected $storage;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * AuthenticationListener constructor.
     *
     * @param AuthenticationStorage $storage
     * @param ObjectManager         $objectManager
     */
    public function __construct(AuthenticationStorage $storage, ObjectManager $objectManager)
    {
        $this->storage       = $storage;
        $this->objectManager = $objectManager;
    }

    /**
     * @inheritDoc
     */
    public function attach(EventManagerInterface $events)
    {
        $this->detach($events);

        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, [$this, 'checkIdentity']);
    }

    public function checkIdentity(MvcEvent $e)
    {
        if ($this->storage->hasIdentity() && ($identity = $this->storage->getIdentity())) {
            $identity->setLastActiveDate('now');
            $this->objectManager->persist($identity);
            $this->objectManager->flush();

            return;
        }

        $this->storage->createIdentity();
    }
}