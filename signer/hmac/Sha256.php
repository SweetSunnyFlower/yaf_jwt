<?php
/**
 * This file is part of Lcobucci\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

class Jwt_Signer_Hmac_Sha256 extends Jwt_Signer_Hmac {
    /**
     * {@inheritdoc}
     */
    public function getAlgorithmId() {
        return 'HS256';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlgorithm() {
        return 'sha256';
    }
}
