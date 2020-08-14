<?php

/**
 * Class Jwt_Factory
 * @desc 签名入口
 */
class Jwt_Factory
{

    private $encoder;

    private $claimFactory;

    private $config;

    private $signer;

    private $claims = array();

    private $headers = array('typ'=> 'JWT', 'alg' => 'none');

    public function __construct(Jwt_Interface_Encode $encode, Jwt_Interface_ClaimFactory $claimFactory, Jwt_Interface_Config $config, Jwt_Interface_Signer $signer = null){
        $this->config = $config;
        $this->encoder = $encode;
        $this->claimFactory = $claimFactory;
        $this->signer = $signer;
    }

    /**
     * @desc 签发人
     * @param false $replicateAsHeader
     * @return $this
     */
    public function issuedBy($replicateAsHeader = false)
    {
        return $this->setRegisteredClaim('iss', (string) $this->config->getIssued(), $replicateAsHeader);
    }

    /**
     * @desc 受众
     * @param false $replicateAsHeader
     * @return $this
     */
    public function audienceFor($replicateAsHeader = false)
    {
        return $this->setRegisteredClaim('aud', (string) $this->config->getAudience(), $replicateAsHeader);
    }

    public function identifiedBy($replicateAsHeader = false)
    {
        return $this->setRegisteredClaim('jti', (string) $this->config->getIdentifiedBy(), $replicateAsHeader);
    }

    public function issuedAt($replicateAsHeader = false)
    {
        return $this->setRegisteredClaim('iat', (int) $this->config->getIssuedAt(), $replicateAsHeader);
    }

    public function canOnlyBeUsedAfter($replicateAsHeader = false)
    {
        return $this->setRegisteredClaim('nbf', (int) $this->config->getEffectAt(), $replicateAsHeader);
    }

    public function expiresAt($replicateAsHeader = false)
    {
        return $this->setRegisteredClaim('exp', (int) $this->config->getExpiresAt(), $replicateAsHeader);
    }

    protected function setRegisteredClaim($name, $value, $replicate)
    {
        $this->withClaim($name, $value);

        if ($replicate) {
            $this->headers[$name] = $this->claims[$name];
        }

        return $this;
    }

    public function withClaim($name, $value)
    {
        $this->claims[(string) $name] = $this->claimFactory->create($name, $value);

        return $this;
    }

    public function getToken(){
        $this->signer->modifyHeader($this->headers);
        $payload = array(
            $this->encoder->base64UrlEncode($this->headers),
            $this->encoder->base64UrlEncode($this->claims),
        );

        $signature = $this->createSignature($payload);

        if ($signature !== null){
            $payload[] = $this->encoder->base64UrlEncode($signature);
        }

        return new Jwt_Token($this->headers, $this->claims, $signature, $payload);

    }

    public function createSignature(array $payload){
        if ($this->signer === null || $this->config->getSecretKey() === null){
            return null;
        }

        return $this->signer->sign(implode('.', $payload), $this->config->getSecretKey());
    }

}