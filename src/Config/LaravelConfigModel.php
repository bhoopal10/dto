<?php

namespace Fnp\Dto\Config;

use Fnp\Dto\Common\DtoFill;
use Fnp\Dto\Common\Helper\DtoHelper;
use Illuminate\Contracts\Foundation\Application;

class LaravelConfigModel
{
    use DtoFill;

    public function __construct(Application $app)
    {
        $config = $this->build($app);

        if ($method = DtoHelper::methodExists($this, 'get', 'config')) {
            $config = array_merge($config, $this->$method());
        }

        if ($method = DtoHelper::methodExists($this, 'get', $app->environment(), 'config')) {
            $config = array_merge($config, $this->$method());
        }

        $this->fill($config);

        if ($method = DtoHelper::methodExists($this, 'set', 'config')) {
            $this->$method();
        }

        if ($method = DtoHelper::methodExists($this, 'set', $app->environment(), 'config')) {
            $this->$method();
        }
    }

    public function build(Application $app)
    {
        $reflection = new \ReflectionClass($this);
        $variables  = $reflection->getProperties();
        $build      = [];

        /** @var \ReflectionProperty $var */
        foreach ($variables as $variable) {

            $variable->setAccessible(TRUE);

            $varName  = $variable->getName();
            $varValue = $variable->getValue($this);

            if (!$varValue) {
                continue;
            }

            if (preg_match('/\#(.*)/', $varValue, $match)) {
                $build[ $varName ] = env($match[1]);
                continue;
            }

            if (preg_match('/(.*)@(.*)\(\)$/u', $varValue, $match)) {
                $dependentConfig   = $app->make($match[1]);
                $build[ $varName ] = $app->call([$dependentConfig, $match[2]]);
                continue;
            }

            if (preg_match('/(.*)@(.*)$/u', $varValue, $match)) {

                $dependentConfig   = $app->make($match[1]);
                $dependantProperty = $match[2];
                $build[ $varName ] = $dependentConfig->$dependantProperty;
                continue;
            }

            $build[ $varName ] = $app['config']->get($varValue);

        }

        return $build;
    }

}