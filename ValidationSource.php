<?php

class Jwt_ValidationSource implements Jwt_Interface_ValidationSource
{

    private $items;

    private $leeway;

    public function __construct($currentTime = null, $leeway = 0)
    {
        $currentTime = (int)($currentTime ?: time());
        $this->leeway = (int)$leeway;

        $this->items = array(
            'jti' => null,
            'iss' => null,
            'aud' => null,
            'sub' => null,
        );

    }

    public function setId($id)
    {
        // TODO: Implement setId() method.
        $this->items['jti'] = $id;
    }

    public function setIssuer($issuer)
    {
        // TODO: Implement setIssuer() method.
        $this->items['iss'] = $issuer;
    }

    public function setAudience($audience)
    {
        // TODO: Implement setAudience() method.
        $this->items['aud'] = $audience;
    }

    public function setSubject($subject)
    {
        // TODO: Implement setSubject() method.
        $this->items['sub'] = (string)$subject;
    }

    public function setCurrentTime($currentTime)
    {
        // TODO: Implement setCurrentTime() method.
        $this->items['iat'] = $currentTime + $this->leeway;
        $this->items['nbf'] = $currentTime + $this->leeway;
        $this->items['exp'] = $currentTime - $this->leeway;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        // TODO: Implement get() method.
        return isset($this->items[$name]) ? $this->items[$name] : null;
    }

    public function has($name)
    {
        // TODO: Implement has() method.
        return !empty($this->items[$name]);
    }
}