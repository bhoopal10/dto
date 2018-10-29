<?php

namespace Fnp\Dto\Flag;

use Fnp\Dto\Common\DtoProperties;
use Fnp\Dto\Common\Helper\Obj;

class FlagModel
{
    use DtoProperties;

    private $_flags = [];

    public function __construct($flags = [])
    {
        if (is_null($flags))
            $flags = [];

        if (!is_array($flags))
            $flags = [$flags];

        $this->_flags = $flags;

        $this->build();
    }

    public static function make($flags = [])
    {
        return new static($flags);
    }

    protected function build()
    {
        $variables = self::properties();

        foreach ($variables as $variable) {
            $varName = $variable->getName();
            $method  = Obj::methodName('get', $varName);

            if (!method_exists($this, $method))
                continue;

            $value = $this->$method();

            $this->$varName = $value;
        }
    }

    /**
     * Add new flag(s)
     *
     * @param $flags
     *
     * @return $this
     */
    public function add($flags)
    {
        if (!is_array($flags)) {
            $flags = [];
        }

        array_map(function ($flag) {
            $this->_flags[] = $flag;
        }, $flags);

        $this->build();

        return $this;
    }

    /**
     * Check if flag has been set
     *
     * @param $flags
     *
     * @return bool
     */
    public function has($flags)
    {
        if ($this->none()) {
            return FALSE;
        }

        if (is_array($flags)) {
            $all = TRUE;

            foreach($flags as $flag)
                if (!in_array($flag, $this->_flags))
                    $all = FALSE;

            return $all;
        }

        return in_array($flags, $this->_flags);
    }

    /**
     * Check if flag or all of the flags
     * are not set
     *
     * @param $flags
     *
     * @return bool
     */
    public function not($flags)
    {
        return !$this->has($flags);
    }

    /**
     * Return array of set flags
     *
     * @return array
     */
    public function flags()
    {
        return $this->_flags;
    }

    /**
     * Check if none of the flags are set
     *
     * @return bool
     */
    public function none()
    {
        return empty($this->_flags);
    }
}