<?php

namespace Fnp\Dto\Common;

use Fnp\Dto\Common\Helper\DtoHelper;
use Illuminate\Contracts\Support\Arrayable;
use ReflectionProperty;

trait DtoToArray
{
    /**
     * @param boolean $follow Should we convert the objects to array?
     *
     * @return array
     */
    public function toArray($follow = TRUE)
    {
        $reflection = new \ReflectionClass($this);
        $vars       = $reflection->getProperties(
            ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED
        );

        $array = [];

        /** @var ReflectionProperty $varRef */
        foreach ($vars as $varRef) {

            $varName = $varRef->getName();

            if ($this->$varName instanceof Arrayable && $follow) {
                $array[$varName] = $this->$varName->toArray();
            } else {
                $getter = DtoHelper::methodExists($this, 'get', $varName);

                if ($getter) {
                    $array[$varName] = $this->$getter();
                } else {
                    $array[$varName] = $this->$varName;
                }
            }
        }

        return $array;
    }
}