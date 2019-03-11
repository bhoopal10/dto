<?php

namespace Fnp\Dto\Common;

use Fnp\Dto\Common\Flags\DtoToArrayFlags;

trait DtoToJson
{
    abstract public function toArray($flags = NULL);

    /**
     * @inheritdoc
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson(
        $options = 0,
        $flags = DtoToArrayFlags::SERIALIZE_OBJECTS + DtoToArrayFlags::SERIALIZE_STRING_PROVIDERS
    ) {
        return json_encode($this->toArray($flags), $options);
    }
}