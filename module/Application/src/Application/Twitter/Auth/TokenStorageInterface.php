<?php
/**
 * File contains interface TokenStorageInterface
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Auth;


/**
 * Interface TokenStorageInterface
 *
 * @package Application\Twitter\Auth
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
interface TokenStorageInterface
{

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * @param string $key
     * @param string $token
     *
     * @return void
     */
    public function set($key, $token);

    /**
     * @param string $key
     *
     * @return string
     */
    public function get($key);

    /**
     * @param string $key
     *
     * @return void
     */
    public function remove($key);

}