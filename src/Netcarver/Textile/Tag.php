<?php

namespace Netcarver\Textile;


/**
 * Class to allow contruction of HTML tags on conversion of an object to a string
 *
 * Example usage...
 *
 * $img = new TextileTag('img')->class('big blue')->src('images/elephant.jpg');
 * echo $img;
 **/
class Tag extends Netcarver\Textile\DataBag
{
    protected $tag;
    protected $selfclose;


    public function __construct($name, $attribs=array(), $selfclosing=true)
    {
        parent::__construct($attribs);
        $this->tag = $name;
        $this->selfclose = $selfclosing;
    }


	public function __toString()
	{
        $attribs = '';

        if (count($this->data)) {
            ksort($this->data);
            foreach ($this->data as $k=>$v)
                $attribs .= " $k=\"$v\"";
        }

        if ($this->tag)
            $o = '<' . $this->tag . $attribs . (($this->selfclose) ? " />" : '>');
        else
            $o = $attribs;

        return $o;
    }
}
