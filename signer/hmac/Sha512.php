<?php
/**
 * This file is part of Lcobucci\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

/**
 * Signer for HMAC SHA-512
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 * @since 0.1.0
 */
class Jwt_Signer_Hmac_Sha512 extends Jwt_Signer_Hmac {
    /**
     * {@inheritdoc}
     */
    public function getAlgorithmId() {
        return 'HS512';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlgorithm() {
        return 'sha512';
    }
}
