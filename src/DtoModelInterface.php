<?php

namespace Fnp\Dto;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

interface DtoModelInterface extends Arrayable, Jsonable
{
    /**
     * Instantiate the model
     * with the given data set.
     *
     * @param mixed $items
     *
     * @return $this|Collection
     */
    public static function make($items);

    /**
     * Updates the model
     * with the given data set.
     *
     * @param $items
     *
     * @return mixed
     */
    public function populateItems($items);

    /**
     * @inheritdoc
     *
     * @return array
     */
    public function toArray();

    /**
     * @inheritdoc
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0);
}