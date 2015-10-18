<?php
/**
 * File contains class TwitterBearerToken
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Entity;

use DateTime;
use Doctrine\ORM\Mapping;

/**
 * Class TwitterBearerToken
 *
 * @package Application\Entity
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 *
 * @Mapping\Entity
 * @Mapping\Table(name="twitter_token_storage")
 */
class TwitterBearerToken
{
    /**
     * @Mapping\Id
     * @Mapping\GeneratedValue(strategy="NONE")
     * @Mapping\Column(type="string")
     *
     * @var string
     */
    protected $id;

    /**
     * @Mapping\Column(type="string")
     *
     * @var string
     */
    protected $token;

    /**
     * @Mapping\Column(type="datetime")
     *
     * @var DateTime
     */
    protected $createdDate;

    /**
     * TwitterBearerToken constructor.
     *
     * @param string $id
     * @param string $token
     */
    public function __construct($id, $token)
    {
        $this->id          = $id;
        $this->token       = $token;
        $this->createdDate = new DateTime();
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     *
     * @return TwitterBearerToken
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

}