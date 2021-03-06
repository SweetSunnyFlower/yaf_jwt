<?php
/**
 * This file is part of Lcobucci\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */


/**
 * Signer for RSA SHA-256
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 * @since 2.1.0
 */
class Jwt_Signer_Rsa_Sha256 extends Jwt_Signer_Rsa {
    /**
     * {@inheritdoc}
     */
    public function getAlgorithmId() {
        return 'RS256';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlgorithm() {
        return OPENSSL_ALGO_SHA256;
    }
}
