<?php

interface Jwt_Interface_ClaimFactory
{
    public function create($name, $value);
}