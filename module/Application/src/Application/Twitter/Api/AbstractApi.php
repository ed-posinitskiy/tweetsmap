<?php
/**
 * File contains class AbstractApi
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Api;

use Application\Twitter\Auth\AuthProviderInterface;
use Application\Twitter\ClientInterface;
use RuntimeException;


/**
 * Class AbstractApi
 *
 * @package Application\Twitter\Api
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
abstract class AbstractApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var AuthProviderInterface
     */
    protected $authProvider;

    /**
     * AbstractApi constructor.
     *
     * @param ClientInterface       $client
     * @param AuthProviderInterface $authProvider
     */
    public function __construct(ClientInterface $client, AuthProviderInterface $authProvider)
    {
        $this->client       = $client;
        $this->authProvider = $authProvider;
    }

    /**
     * @return \Application\Entity\TwitterBearerToken
     */
    protected function getAuthHeader()
    {
        if (!$this->authProvider->isAuthenticated()) {
            if (!$this->authProvider->authenticate()) {
                throw new RuntimeException('Authentication failed');
            }
        }

        return ['Authorization' => 'Bearer ' . $this->authProvider->getToken()->getToken()];
    }
}