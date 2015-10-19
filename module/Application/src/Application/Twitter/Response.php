<?php
/**
 * File contains class Response
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter;

use stdClass;

/**
 * Class Response
 *
 * @package Application\Twitter
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class Response
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string Json encoded response body
     */
    protected $body;

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    /**
     * @param int $statusCode
     *
     * @return Response
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param string $body
     *
     * @return Response
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return stdClass
     */
    public function getBody()
    {
        return json_decode($this->body, true);
    }

    /**
     * @return string
     */
    public function getRawBody()
    {
        return $this->body;
    }
}