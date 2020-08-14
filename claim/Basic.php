<?php

class Jwt_Claim_Basic implements Jwt_Interface_Claim
{

    private $name;

    private $value;

    public function __construct($name, $value){
        $this->name = $name;
        $this->value = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string)$this->value;
    }

    public function jsonSerialize(){
        return $this->value;
    }

}