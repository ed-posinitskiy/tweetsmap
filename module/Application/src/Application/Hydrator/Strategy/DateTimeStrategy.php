<?php
/**
 * File contains class DateTimeStrategy
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  20.10.2015
 */

namespace Application\Hydrator\Strategy;

use DateTime;
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class DateTimeStrategy
 *
 * @package Application\Hydrator\Strategy
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   20.10.2015
 */
class DateTimeStrategy implements StrategyInterface
{

    /**
     * @var string
     */
    protected $format = 'c';

    /**
     * DateTimeStrategy constructor.
     *
     * @param string $format
     */
    public function __construct($format)
    {
        $this->format = $format;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @inheritDoc
     */
    public function extract($value)
    {
        if (!$value instanceof DateTime) {
            return $value;
        }

        return $value->format($this->format);
    }

    /**
     * @inheritDoc
     */
    public function hydrate($value)
    {
        if ($value instanceof DateTime) {
            return $value;
        }

        if (is_string($value)) {
            return new DateTime($value);
        }

        if (is_int($value)) {
            $object = new DateTime();
            $object->setTimestamp($value);

            return $object;
        }

        return $value;
    }

}