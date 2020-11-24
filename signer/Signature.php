<?php

class Jwt_Signer_Signature {
    protected $hash;

    public function __construct($hash) {
        $this->hash = $hash;
    }

    public function verify(Jwt_Interface_Signer $signer, $payload, $key) {
        return $signer->verify($this->hash, $payload, $key);
    }

    public function signature() {
        return $this->hash;
    }

    public function __toString() {
        return $this->hash;
    }
}