<?php

namespace BasicPHPAPI\DAO;
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 14/09/2016
 * Time: 19:06
 */
class AbstractDAO
{
    protected $DB;

    public function __construct($DB)
    {
        $this->DB = $DB;
    }
}