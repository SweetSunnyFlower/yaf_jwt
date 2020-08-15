<?php
/**
 * This file is part of Lcobucci\JWT, a simple library to handle JWT and JWS
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

abstract class Jwt_Signer_BaseSigner implements Jwt_Interface_Signer
{
    /**
     * {@inheritdoc}
     */
    public function modifyHeader(array &$headers)
    {
        $headers['alg'] = $this->getAlgorithmId();
    }

    /**
     * {@inheritdoc}
     */
    public function sign($payload, $key)
    {
        return new Jwt_Signer_Signature($this->createHash($payload, $this->getKey($key)));
    }

    /**
     * {@inheritdoc}
     */
    public function verify($expected, $payload, $key)
    {
        return $this->doVerify($expected, $payload, $this->getKey($key));
    }

    /**
     * @param Jwt_Signer_Key|string $key
     *
     * @return Jwt_Signer_Key
     */
    private function getKey($key)
    {
        if (is_string($key)) {
            $key = new Jwt_Signer_Key($key);
        }

        return $key;
    }

    /**
     * Creates a hash with the given data
     *
     * @internal
     *
     * @param string $payload
     * @param Jwt_Signer_Key $key
     *
     * @return string
     */
    abstract public function createHash($payload, Jwt_Signer_Key $key);

    /**
     * Performs the signature verification
     *
     * @internal
     *
     * @param string $expected
     * @param string $payload
     * @param Jwt_Signer_Key $key
     *
     * @return boolean
     */
    abstract public function doVerify($expected, $payload, Jwt_Signer_Key $key);
}
