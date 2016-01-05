<?php
/**
 * Created by PhpStorm.
 * User: Matheus
 * Date: 10/9/2015
 * Time: 9:56 PM
 */

namespace TinyBoard\Objects;


class Config extends DbEntity
{
    /**
     * Objects data model
     * @var string
     */
    protected $_table = 'config';

    public function __construct($data = null)
    {
        parent::__construct();
        if ($data != null) {
            $this->_attributes = $data;
        }
    }

}