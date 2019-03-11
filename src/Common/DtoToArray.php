<?php

namespace Fnp\Dto\Common;

use Fnp\Dto\Common\Flags\DtoToArrayFlags;
use Fnp\Dto\Common\Helper\Iof;
use Fnp\Dto\Common\Helper\Obj;
use ReflectionProperty;

trait DtoToArray
{
    /**
     * @param array|int Additional flags from DtoToArrayFlags?
     *
     * @return array
     * @throws \ReflectionException
     */
    public function toArray($flags = NULL)
    {
        // For compatibility
        if ($flags === TRUE)
            $flags = DtoToArrayFlags::SERIALIZE_OBJECTS;

        $flags      = new DtoToArrayFlags($flags);
        $reflection = new \ReflectionClass($this);
        $vars       = $reflection->getProperties(
            $flags->reflectionOptions()
        );

        $array = [];

        /** @var ReflectionProperty $varRef */
        foreach ($vars as $varRef) {

            $varRef->setAccessible(TRUE);
            $varName  = $varRef->getName();
            $varValue = $varRef->getValue($this);

            if (Iof::arrayable($varValue) && $flags->serializeObjects()) {
                $array[ $varName ] = $varValue->toArray();
            } elseif (Iof::stringable($this->$varName) && $flags->serializeStringProviders()) {
                $array[ $varName ] = $varValue->__toString();
            } else {
                $getter = Obj::methodExists($this, 'get', $varName);

                if ($getter) {
                    $array[ $varName ] = $this->$getter();
                } else {
                    $array[ $varName ] = $varValue;
                }
            }
        }

        if ($flags->excludeNulls())
            $array = array_filter($array, function ($value) {
                return !is_null($value);
            });

        return $array;
    }
}