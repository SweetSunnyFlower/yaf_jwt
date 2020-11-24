<?php

/**
 * Class Jwt_Factory
 * @desc 签名入口
 */
class Jwt_Factory {

    private $encoder;

    private $claimFactory;

    private $config;

    private $signer;

    private $claims = array();

    private $headers = array('typ' => 'JWT', 'alg' => 'none');

    public function __construct(
        Jwt_Interface_Config $config
    ) {
        $this->setClaimFactory();
        $this->setEncoder();
        $this->setSignature();
        $this->setConfig($config);
    }

    /**
     * @param  Jwt_Interface_Config  $config
     * @return $this
     */
    public function setConfig(Jwt_Interface_Config $config) {
        $this->config = $config;

        return $this;
    }

    /**
     * @param  Jwt_Interface_Config  $config
     * @param  array  $claim
     * @return Jwt_Factory
     */
    public static function register(Jwt_Interface_Config $config, $claim = array()) {
        $self = new self($config);

        return $self->issuedBy()->audienceFor()->canOnlyBeUsedAfter()->expiresAt()->identifiedBy()->withMultiClaim(
            $claim
        );
    }

    /**
     * @param  Jwt_Interface_Encode|null  $encoder
     * @return $this
     */
    public function setEncoder(Jwt_Interface_Encode $encoder = null) {
        if (null === $encoder) {
            $this->encoder = new Jwt_Parsing_Encoder();
        } else {
            $this->encoder = $encoder;
        }

        return $this;
    }

    /**
     * @param  Jwt_Interface_ClaimFactory|null  $claimFactory
     * @return $this
     */
    public function setClaimFactory(Jwt_Interface_ClaimFactory $claimFactory = null) {
        if (null === $claimFactory) {
            $this->claimFactory = new Jwt_Claim_Factory();
        } else {
            $this->claimFactory = $claimFactory;
        }

        return $this;
    }

    /**
     * @param  Jwt_Interface_Signer|null  $signer
     * @return $this|Jwt_Signer_Hmac_Sha256
     */
    public function setSignature(Jwt_Interface_Signer $signer = null) {
        if (null === $signer) {
            return $this->signer = new Jwt_Signer_Hmac_Sha256();
        } else {
            $this->signer = $signer;
        }

        return $this;
    }

    /**
     * @desc 签发人
     * @param  false  $replicateAsHeader
     * @return $this
     */
    public function issuedBy($replicateAsHeader = false) {
        return $this->setRegisteredClaim('iss', (string)$this->config->getIssued(), $replicateAsHeader);
    }

    /**
     * @desc 受众
     * @param  false  $replicateAsHeader
     * @return $this
     */
    public function audienceFor($replicateAsHeader = false) {
        return $this->setRegisteredClaim('aud', (string)$this->config->getAudience(), $replicateAsHeader);
    }

    public function identifiedBy($replicateAsHeader = false) {
        return $this->setRegisteredClaim('jti', (string)$this->config->getIdentifiedBy(), $replicateAsHeader);
    }

    public function issuedAt($replicateAsHeader = false) {
        return $this->setRegisteredClaim('iat', (int)$this->config->getIssuedAt(), $replicateAsHeader);
    }

    /**
     * 生效时间
     * @param  false  $replicateAsHeader
     * @return $this
     */
    public function canOnlyBeUsedAfter($replicateAsHeader = false) {
        return $this->setRegisteredClaim('nbf', (int)$this->config->getEffectAt(), $replicateAsHeader);
    }

    /**
     * 过期时间
     * @param  false  $replicateAsHeader
     * @return $this
     */
    public function expiresAt($replicateAsHeader = false) {
        return $this->setRegisteredClaim('exp', (int)$this->config->getExpiresAt(), $replicateAsHeader);
    }

    /**
     * 添加附加数据
     * @param $name
     * @param $value
     * @param $replicate
     * @return $this
     */
    protected function setRegisteredClaim($name, $value, $replicate) {
        $this->withClaim($name, $value);

        if ($replicate) {
            $this->headers[$name] = $this->claims[$name];
        }

        return $this;
    }

    public function withClaim($name, $value) {
        $this->claims[(string)$name] = $this->claimFactory->create($name, $value);

        return $this;
    }

    public function withMultiClaim($claims = array()) {
        foreach ($claims as $name => $value) {
            $this->claims[(string)$name] = $this->claimFactory->create($name, $value);
        }

        return $this;
    }

    public function token() {
        $this->signer->modifyHeader($this->headers);
        $payload = array(
            $this->encoder->base64UrlEncode($this->encoder->jsonEncode($this->headers)),
            $this->encoder->base64UrlEncode($this->encoder->jsonEncode($this->claims)),
        );

        $signature = $this->createSignature($payload);
        if ($signature !== null) {
            $payload[] = $this->encoder->base64UrlEncode($signature);
        }

        return new Jwt_Token($this->headers, $this->claims, $signature, $payload);
    }

    public function createSignature(array $payload) {
        if ($this->signer === null || $this->config->getSecretKey() === null) {
            return null;
        }

        return $this->signer->sign(implode('.', $payload), $this->config->getSecretKey());
    }

    /**
     * @return string
     */
    public function getToken() {
        return $this->token()->getToken();
    }

}