<?php

use Fnp\Dto\Flex\DtoModel;

class Cars extends DtoModel
{
    use \Fnp\Dto\Common\DtoToCollection;

    protected $alfaRomeo;

    protected $bmw;

    protected $citroen;

    protected $jaguar;

    protected $saab;

    protected $tesla;

    protected $volvo;
}