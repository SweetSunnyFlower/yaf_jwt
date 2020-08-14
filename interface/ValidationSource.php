<?php

interface Jwt_Interface_ValidationSource
{
    public function setId($id);

    public function setIssuer($issuer);

    public function setAudience($audience);

    public function setSubject($subject);

    public function setCurrentTime($currentTime);

    public function get($name);

    public function has($name);

}