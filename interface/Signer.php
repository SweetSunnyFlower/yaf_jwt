<?php

interface Jwt_Interface_Signer {
    public function getAlgorithmId();

    public function modifyHeader(array &$headers);

    public function sign($payload, $key);

    public function verify($expected, $payload, $key);
}