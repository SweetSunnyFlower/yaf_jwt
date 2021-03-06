<?php
/**
 * This file is part of Lcobucci\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */


/**
 * Signer for ECDSA SHA-384
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 * @since 2.1.0
 */
class Jwt_Signer_Ecdsa_Sha384 extends Jwt_Signer_Ecdsa {
    /**
     * {@inheritdoc}
     */
    public function getAlgorithmId() {
        return 'ES384';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlgorithm() {
        return 'sha384';
    }

    /**
     * {@inheritdoc}
     */
    public function getKeyLength() {
        return 96;
    }
}
