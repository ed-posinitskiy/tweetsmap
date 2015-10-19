<?php
/**
 * File contains class Auth
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Auth;

use Application\Entity\TwitterBearerToken;
use Application\Twitter\ClientInterface;
use RuntimeException;

/**
 * Class Auth
 *
 * @package Application\Twitter\Auth
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class AppAuthProvider implements AuthProviderInterface
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var string
     */
    protected $tokenUrl = '/oauth2/token';

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * AppAuthProvider constructor.
     *
     * @param ClientInterface       $client
     * @param TokenStorageInterface $tokenStorage
     * @param string                $key
     * @param string                $secret
     */
    public function __construct(ClientInterface $client, TokenStorageInterface $tokenStorage, $key, $secret)
    {
        $this->client       = $client;
        $this->key          = $key;
        $this->secret       = $secret;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @inheritdoc
     */
    public function authenticate()
    {
        if ($this->isAuthenticated()) {
            return true;
        }

        $basic   = $this->assembleBasic();
        $params  = ['grant_type' => 'client_credentials'];
        $headers = [
            'Authorization' => 'Basic ' . $basic,
            'Content-Type'  => 'application/x-www-form-urlencoded;charset=UTF-8'
        ];

        $response = $this->client->post($this->tokenUrl, $params, $headers, false);

        if ($response->isSuccess()) {
            $tokenData = $response->getBody();

            if ($tokenData['token_type'] !== 'bearer') {
                throw new RuntimeException(
                    sprintf('Token type mismatch. Expected Bearer token, got `%s`', $tokenData->token_type)
                );
            }

            $this->tokenStorage->set($basic, $tokenData['access_token']);

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function isAuthenticated()
    {
        return $this->tokenStorage->has($this->assembleBasic());
    }

    /**
     * @inheritDoc
     */
    public function reset()
    {
        $this->tokenStorage->remove($this->assembleBasic());
    }

    /**
     * @inheritDoc
     */
    public function getToken()
    {
        return $this->tokenStorage->get($this->assembleBasic());
    }

    protected function assembleBasic()
    {
        return base64_encode($this->key . ':' . $this->secret);
    }

}