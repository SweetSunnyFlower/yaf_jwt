<?php

interface Jwt_Interface_Claim{

    public function __construct($name, $value);

    public function getName();

    public function getValue();

    public function __toString();

}