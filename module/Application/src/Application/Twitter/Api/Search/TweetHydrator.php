<?php
/**
 * File contains class TweetHydrator
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  19.10.2015
 */

namespace Application\Twitter\Api\Search;

use Application\Entity\Tweet;
use Zend\Hydrator\AbstractHydrator;

/**
 * Class TweetHydrator
 *
 * @package Application\Twitter\Api\Search
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   19.10.2015
 */
class TweetHydrator extends AbstractHydrator
{
    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        return [
            'created_at' => $object->getDate()->format('c'),
            'text'       => $object->getText(),
            'user'       => [
                'profile_image_url' => $object->getAvatar()
            ],
            'geo'        => [
                'coordinates' => [
                    $object->getLen(),
                    $object->getLon()
                ]
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        $object->setDate($data['created_at']);
        $object->setAvatar($data['user']['profile_image_url']);
        $object->setText($data['text']);

        $this->setGeo($data, $object);

        return $object;
    }

    /**
     * @param array $data
     * @param Tweet $object
     */
    protected function setGeo(array $data, $object)
    {
        if (isset($data['geo']['coordinates']) && is_array($data['geo']['coordinates'])) {
            $object->setLen($data['geo']['coordinates'][0]);
            $object->setLon($data['geo']['coordinates'][1]);

            return;
        }

        if (isset($data['coordinates']['coordinates']) && is_array($data['coordinates']['coordinates'])) {
            $object->setLen($data['coordinates']['coordinates'][1]);
            $object->setLen($data['coordinates']['coordinates'][0]);

            return;
        }

        if (isset($data['retweeted_status']) && is_array($data['retweeted_status'])) {
            $this->setGeo($data['retweeted_status'], $object);

            return;
        }

        $object->setLen(0)->setLon(0);
    }

}