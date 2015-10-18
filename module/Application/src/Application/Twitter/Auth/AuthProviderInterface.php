<?php
/**
 * File contains interface AuthProviderInterface
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Auth;
use Application\Entity\TwitterBearerToken;


/**
 * Interface AuthProviderInterface
 *
 * @package Application\Twitter\Auth
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
interface AuthProviderInterface
{
    /**
     * @return bool
     */
    public function authenticate();

    /**
     * @return bool
     */
    public function isAuthenticated();

    /**
     * Resets the authentication state
     *
     * @return void
     */
    public function reset();

    /**
     * @return TwitterBearerToken
     */
    public function getToken();
}