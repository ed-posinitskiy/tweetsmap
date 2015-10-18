<?php
/**
 * File contains class AuthenticationStorage
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Auth;

use Application\Entity\Identity;
use Doctrine\Common\Persistence\ObjectManager;
use RuntimeException;
use Zend\Session\Container;


/**
 * Class AuthenticationStorage
 *
 * @package Application\Auth
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class AuthenticationStorage
{

    const IDENTITY_KEY = 'token';

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var Container
     */
    protected $sessionContainer;

    /**
     * AuthenticationStorage constructor.
     *
     * @param ObjectManager $objectManager
     * @param Container     $sessionContainer
     */
    public function __construct(ObjectManager $objectManager, Container $sessionContainer)
    {
        $this->objectManager    = $objectManager;
        $this->sessionContainer = $sessionContainer;
    }

    /**
     * @return bool
     */
    public function hasIdentity()
    {
        if (!$this->sessionContainer->offsetExists(static::IDENTITY_KEY)) {
            return false;
        }

        return true;
    }

    /**
     * @return Identity
     */
    public function getIdentity()
    {
        if (!$this->hasIdentity()) {
            throw new RuntimeException('Identity is not defined');
        }

        $token = $this->sessionContainer->offsetGet(static::IDENTITY_KEY);

        return $this->objectManager->find(Identity::class, $token);
    }

    /**
     * @return Identity
     */
    public function createIdentity()
    {
        $token    = uniqid();
        $identity = new Identity($token);

        $this->sessionContainer->offsetSet(static::IDENTITY_KEY, $token);
        $this->objectManager->persist($identity);
        $this->objectManager->flush();

        return $identity;
    }
}