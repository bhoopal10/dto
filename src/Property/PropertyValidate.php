<?php

namespace Fnp\Dto\Property;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait PropertyValidate
{
    public function valid(Collection $errors = NULL)
    {
        $valid      = TRUE;
        $properties = array_keys(
            get_class_vars(get_called_class())
        );

        foreach ($properties as $property) {

            $validator = 'get' . ucfirst(Str::camel($property));

            if (!method_exists($this, $validator)) {
                continue;
            }

            if (!call_user_func_array([$this, $validator], [$errors])) {
                $valid = FALSE;
            }

        }

        return $valid;
    }
}