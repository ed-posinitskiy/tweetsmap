<?php
/**
 * File contains class Identity
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Entity;

use DateTime;
use Doctrine\ORM\Mapping;
use InvalidArgumentException;

/**
 * Class Identity
 *
 * @package Application\Entity
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 *
 * @Mapping\Entity
 * @Mapping\Table(name="identity")
 */
class Identity
{
    /**
     * @var string
     *
     * @Mapping\Id
     * @Mapping\GeneratedValue(strategy="NONE")
     * @Mapping\Column(type="string")
     */
    protected $id;

    /**
     * @var DateTime
     *
     * @Mapping\Column(type="datetime")
     */
    protected $createdDate;

    /**
     * @var DateTime
     *
     * @Mapping\Column(type="datetime")
     */
    protected $lastActiveDate;

    /**
     * Identity constructor.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->id = $token;
        $this->createdDate = new DateTime();
        $this->lastActiveDate = new DateTime();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @return DateTime
     */
    public function getLastActiveDate()
    {
        return $this->lastActiveDate;
    }

    /**
     * @param DateTime $lastActiveDate
     *
     * @return Identity
     */
    public function setLastActiveDate($lastActiveDate)
    {
        if (is_string($lastActiveDate)) {
            $lastActiveDate = new DateTime($lastActiveDate);
        }

        if (!$lastActiveDate instanceof DateTime) {
            throw new InvalidArgumentException(
                sprintf(
                    'Expected DateTime object or string, got %s',
                    is_object($lastActiveDate) ? get_class($lastActiveDate) : gettype($lastActiveDate)
                )
            );
        }

        $this->lastActiveDate = $lastActiveDate;

        return $this;
    }

}