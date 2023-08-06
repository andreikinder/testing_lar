<?php


namespace App;


class Expression
{

    protected $expression = '';

    public static function make()
    {
        return new static;
    }

    public function getRegExp()
    {
        return '/' . $this->expression . '/';
    }

    protected function sanitize($value)
    {
        return  preg_quote($value , '/');
    }

    public function __toString()
    {
      return $this->getRegExp();
    }

    public function test($value)
    {
        print_r( $this->getRegExp());
        return (bool) preg_match($this->getRegExp() , $value);

    }

    protected function add ($value)
    {
        $this->expression .= $value;
        return $this;
    }

    public function find($value)
    {
        return $this->add( $this->sanitize($value) );
    }

    public function then($value)
    {
       return $this->find($value);
    }

    public function anything()
    {
        return $this->add('.*');

    }

    public function maybe($value)
    {
        $value = $this->sanitize($value);
        return $this->add("(?:$value)?");

    }

    public function anythingBut($value)
    {
        $value = $this->sanitize($value);
        return $this->add("(?!$value).*?");
    }
}
