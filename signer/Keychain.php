<?php
/**
 * This file is part of Lcobucci\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */


class Jwt_Signer_Keychain {
    /**
     * Returns a private key from file path or content
     *
     * @param  string  $key
     * @param  string  $passphrase
     *
     * @return Jwt_Signer_Key
     */
    public function getPrivateKey($key, $passphrase = null) {
        return new Jwt_Signer_Key($key, $passphrase);
    }

    /**
     * Returns a public key from file path or content
     *
     * @param  string  $certificate
     *
     * @return Jwt_Signer_Key
     */
    public function getPublicKey($certificate) {
        return new Jwt_Signer_Key($certificate);
    }
}
