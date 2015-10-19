<?php
/**
 * File contains class SearchHistory
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Entity;

use DateTime;
use Doctrine\ORM\Mapping;
use InvalidArgumentException;

/**
 * Class SearchHistory
 *
 * @package Application\Entity
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 *
 * @Mapping\Entity(repositoryClass="Application\Repository\SearchHistoryRepository")
 * @Mapping\Table(name="search_history")
 */
class SearchHistory
{
    /**
     * @var int
     *
     * @Mapping\Id
     * @Mapping\GeneratedValue(strategy="AUTO")
     * @Mapping\Column(type="integer")
     */
    protected $id;

    /**
     * @var Identity
     *
     * @Mapping\ManyToOne(targetEntity="Identity")
     * @Mapping\JoinColumn(name="identity", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $identity;

    /**
     * @var string
     * @Mapping\Column(type="string")
     */
    protected $keyword;

    /**
     * @var DateTime
     * @Mapping\Column(type="datetime")
     */
    protected $date;

    /**
     * SearchHistory constructor.
     */
    public function __construct()
    {
        $this->date = new DateTime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Identity
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @param Identity $identity
     *
     * @return SearchHistory
     */
    public function setIdentity(Identity $identity)
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * @param string $keyword
     *
     * @return SearchHistory
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     *
     * @return SearchHistory
     */
    public function setDate($date)
    {
        if (is_string($date)) {
            $date = new DateTime($date);
        }

        if (!$date instanceof DateTime) {
            throw new InvalidArgumentException(
                sprintf(
                    'Instance of DateTime or string expected, got `%s`',
                    is_object($date) ? get_class($date) : gettype($date)
                )
            );
        }

        $this->date = $date;

        return $this;
    }
}