<?php

abstract class Jwt_Signer_OpenSSL extends Jwt_Signer_BaseSigner {
    public function createHash($payload, Jwt_Signer_Key $key) {
        $privateKey = $this->getPrivateKey($key->getContent(), $key->getPassphrase());

        try {
            $signature = '';

            if (!openssl_sign($payload, $signature, $privateKey, $this->getAlgorithm())) {
                throw new InvalidArgumentException(
                    'There was an error while creating the signature: '.openssl_error_string()
                );
            }

            return $signature;
        } finally {
            openssl_free_key($privateKey);
        }
    }

    /**
     * @param  string  $pem
     * @param  string  $passphrase
     *
     * @return resource
     */
    private function getPrivateKey($pem, $passphrase) {
        $privateKey = openssl_pkey_get_private($pem, $passphrase);
        $this->validateKey($privateKey);

        return $privateKey;
    }

    /**
     * @param $expected
     * @param $payload
     * @param $pem
     * @return bool
     */
    public function doVerify($expected, $payload, Jwt_Signer_Key $key) {
        $publicKey = $this->getPublicKey($key->getContent());
        $result = openssl_verify($payload, $expected, $publicKey, $this->getAlgorithm());
        openssl_free_key($publicKey);

        return $result === 1;
    }

    /**
     * @param  string  $pem
     *
     * @return resource
     */
    private function getPublicKey($pem) {
        $publicKey = openssl_pkey_get_public($pem);
        $this->validateKey($publicKey);

        return $publicKey;
    }

    /**
     * Raises an exception when the key type is not the expected type
     *
     * @param  resource|bool  $key
     *
     * @throws InvalidArgumentException
     */
    private function validateKey($key) {
        if (!is_resource($key)) {
            throw new InvalidArgumentException(
                'It was not possible to parse your key, reason: '.openssl_error_string()
            );
        }

        $details = openssl_pkey_get_details($key);

        if (!isset($details['key']) || $details['type'] !== $this->getKeyType()) {
            throw new InvalidArgumentException('This key is not compatible with this signer');
        }
    }

    /**
     * Returns the type of key to be used to create/verify the signature (using OpenSSL constants)
     *
     * @internal
     */
    abstract public function getKeyType();

    /**
     * Returns which algorithm to be used to create/verify the signature (using OpenSSL constants)
     *
     * @internal
     */
    abstract public function getAlgorithm();
}
