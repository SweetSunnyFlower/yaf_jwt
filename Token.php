<?php

class Jwt_Token
{
    private $headers;

    private $claims;

    private $signature;

    private $payload;

    public function __construct(
        array $headers = array('alg' => 'none'),
        array $claims = array(),
        Jwt_Signer_Signature $signature = null,
        array $payload = array('', '')
    ){
        $this->headers = $headers;
        $this->claims = $claims;
        $this->signature = $signature;
        $this->payload = $payload;
    }

    public function getHeaders(){
        return $this->headers;
    }

    public function hasHeader($name){
        return array_key_exists($name, $this->headers);
    }

    public function getHeader($name, $default = null){
        if ($this->hasHeader($name)){
            return $this->getHeaderValue($name);
        }

        if ($default === null) {
            throw new OutOfBoundsException('Requested header is not configured');
        }

        return $default;
    }

    private function getHeaderValue($name)
    {
        $header = $this->headers[$name];

        if ($header instanceof Jwt_Interface_Claim) {
            return $header->getValue();
        }

        return $header;
    }

    public function getClaims()
    {
        return $this->claims;
    }

    public function hasClaim($name)
    {
        return array_key_exists($name, $this->claims);
    }

    public function getClaim($name, $default = null)
    {
        if ($this->hasClaim($name)) {
            return $this->claims[$name]->getValue();
        }

        if ($default === null) {
            throw new OutOfBoundsException('Requested claim is not configured');
        }

        return $default;
    }

    public function verify(Jwt_Interface_Signer $signer, $key)
    {
        if ($this->signature === null) {
            throw new BadMethodCallException('This token is not signed');
        }

        if ($this->headers['alg'] !== $signer->getAlgorithmId()) {
            return false;
        }

        return $this->signature->verify($signer, $this->getPayload(), $key);
    }

    public function getPayload()
    {
        return $this->payload[0] . '.' . $this->payload[1];
    }

    public function validate(Jwt_ValidationSource $source)
    {
        foreach ($this->getValidatableClaims() as $claim) {
            if (!$claim->validate($source)) {
                return false;
            }
        }

        return true;
    }

    public function isExpired(DateTimeInterface $now = null)
    {
        $exp = $this->getClaim('exp', false);

        if ($exp === false) {
            return false;
        }

        $now = $now ?: new DateTime();

        $expiresAt = new DateTime();
        $expiresAt->setTimestamp($exp);

        return $now > $expiresAt;
    }

    private function getValidatableClaims()
    {
        foreach ($this->claims as $claim) {
            if ($claim instanceof Jwt_Interface_Validatable) {
                yield $claim;
            }
        }
    }

    public function getToken()
    {
        $token = implode('.', $this->payload);

        if ($this->signature === null) {
            $token .= '.';
        }
        return $token;
    }

    public function __toString()
    {
        $token = implode('.', $this->payload);

        if ($this->signature === null) {
            $token .= '.';
        }
        return $token;
    }
}