<?php
/**
 * This file is part of Lcobucci\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

/**
 * Base class for hmac signers
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 * @since 0.1.0
 */
abstract class Jwt_Signer_Hmac extends Jwt_Signer_BaseSigner {
    /**
     * {@inheritdoc}
     */
    public function createHash($payload, Jwt_Signer_Key $key) {
        return hash_hmac($this->getAlgorithm(), $payload, $key->getContent(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function doVerify($expected, $payload, Jwt_Signer_Key $key) {
        if (!is_string($expected)) {
            return false;
        }

        $callback = function_exists('hash_equals') ? 'hash_equals' : [$this, 'hashEquals'];

        return call_user_func($callback, $expected, $this->createHash($payload, $key));
    }

    /**
     * PHP < 5.6 timing attack safe hash comparison
     *
     * @param  string  $expected
     * @param  string  $generated
     *
     * @return boolean
     * @internal
     *
     */
    public function hashEquals($expected, $generated) {
        $expectedLength = strlen($expected);

        if ($expectedLength !== strlen($generated)) {
            return false;
        }

        $res = 0;

        for ($i = 0; $i < $expectedLength; ++$i) {
            $res |= ord($expected[$i]) ^ ord($generated[$i]);
        }

        return $res === 0;
    }

    /**
     * Returns the algorithm name
     *
     * @return string
     * @internal
     *
     */
    abstract public function getAlgorithm();
}
