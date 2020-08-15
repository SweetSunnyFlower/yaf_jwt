<?php

interface Jwt_Signer_Ecdsa_SignatureConverter
{
    /**
     * Converts the signature generated by OpenSSL into what JWA defines
     *
     * @param string $signature
     * @param int $length
     *
     * @return string
     */
    public function fromAsn1($signature, $length);

    /**
     * Converts the JWA signature into something OpenSSL understands
     *
     * @param string $points
     * @param int $length
     *
     * @return string
     */
    public function toAsn1($points, $length);
}
