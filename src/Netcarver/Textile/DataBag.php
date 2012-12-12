<?php

namespace Netcarver\Textile;


/**
 * Class to allow simple assignment to members of the internal data array
 **/
class DataBag
{
    protected $data;


    public function __construct($initial_data)
    {
        $this->data = (is_array($initial_data)) ? $initial_data : array();
    }


    /**
     * Allows setting of an element in the $data array. eg...
     *
     * $bag->key(value);
     *
     * ...sets $bag's $data['key'] to $value provided $value is not empty.
     * The set can be made forced by following $value with true...
     *
     * $bag->key(value, true);
     *
     * Would force the value into the data array even if it were empty.
     **/
    public function __call($k, $params)
    {
        $allow_empty = isset($params[1]) && is_bool($params[1]) ? $params[1] : false;
        if ($allow_empty || '' != $params[0]) {
            $this->data[$k] = $params[0];
        }

        return $this;
    }
}
