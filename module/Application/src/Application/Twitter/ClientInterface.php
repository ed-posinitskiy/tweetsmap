<?php
/**
 * File contains interface ClientInterface
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  17.10.2015
 */

namespace Application\Twitter;


/**
 * Interface ClientInterface
 *
 * @package Application\Twitter
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   17.10.2015
 */
interface ClientInterface
{

    /**
     * @param string $version
     *
     * @return void
     */
    public function setVersion($version);

    /**
     * @param string $endpoint
     * @param array  $params
     * @param array  $headers
     *
     * @return Response
     */
    public function get($endpoint, array $params = [], array $headers = []);

    /**
     * @param string $endpoint
     * @param array  $params
     * @param array  $headers
     *
     * @return Response
     */
    public function post($endpoint, array $params = [], array $headers = []);

}