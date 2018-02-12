<?php
namespace PrivateMessages\Hydrator;

use PrivateMessages\Model\Message;
use PrivateMessages\Traits\BlockCipherTrait;
use Zend\Hydrator\HydratorInterface;

class PrivateHydrator implements HydratorInterface
{
    use BlockCipherTrait;
    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        //*** use the block cipher to decrypt the message
        return new Message($data);
    }
    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        $data = $object->extract();
        //*** use the block cipher to encrypt the message
        return $data;
    }
}
