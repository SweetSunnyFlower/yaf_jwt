<?php
/**
 * This file is part of Lcobucci\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */


/**
 * Signer for ECDSA SHA-512
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 * @since 2.1.0
 */
class Jwt_Signer_Ecdsa_Sha512 extends Jwt_Signer_Ecdsa {
    /**
     * {@inheritdoc}
     */
    public function getAlgorithmId() {
        return 'ES512';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlgorithm() {
        return 'sha512';
    }

    /**
     * {@inheritdoc}
     */
    public function getKeyLength() {
        return 132;
    }
}
