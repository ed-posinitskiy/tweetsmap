<?php
/**
 * File contains class DbTokenStorage
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Auth;

use Application\Entity\TwitterBearerToken;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class DbTokenStorage
 *
 * @package Application\Twitter\Auth
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class DoctrineORMTokenStorage implements TokenStorageInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * DoctrineORMTokenStorage constructor.
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @inheritDoc
     */
    public function has($key)
    {
        $token = $this->doFind($this->encodeKey($key));

        return isset($token);
    }

    /**
     * @inheritDoc
     */
    public function set($key, $token)
    {
        $key = $this->encodeKey($key);

        /** @var TwitterBearerToken $existing */
        $existing = $this->doFind($key);

        if ($existing) {
            $existing->setToken($token);
            $tokenToSave = $existing;
        } else {
            $tokenToSave = new TwitterBearerToken($key, $token);
        }

        $this->doSave($tokenToSave);
    }

    /**
     * @inheritDoc
     */
    public function get($key)
    {
        return $this->doFind($this->encodeKey($key));
    }

    /**
     * @inheritDoc
     */
    public function remove($key)
    {
        $this->doRemove($this->encodeKey($key));
    }

    /**
     * @param stirng $key
     *
     * @return null|object
     */
    protected function doFind($key)
    {
        return $this->objectManager->find(TwitterBearerToken::class, $key);
    }

    /**
     * @param TwitterBearerToken $token
     *
     * @return DoctrineORMTokenStorage
     */
    protected function doSave(TwitterBearerToken $token)
    {
        $this->objectManager->persist($token);
        $this->objectManager->flush();

        return $this;
    }

    /**
     * @param string $key
     *
     * @return DoctrineORMTokenStorage
     */
    protected function doRemove($key)
    {
        $token = $this->doFind($key);

        if ($token) {
            $this->objectManager->remove($token);
            $this->objectManager->flush();
        }

        return $this;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    protected function encodeKey($key)
    {
        return md5($key);
    }

}