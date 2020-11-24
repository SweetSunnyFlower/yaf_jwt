<?php

class Jwt_Parser {
    private $decoder;

    private $claimFactory;

    private $signer;

    private $tokenServer;

    public $claims;

    private $config;

    public function __construct(Jwt_Interface_Config $config) {
        $this->setDecoder();
        $this->setClaimFactory();
        $this->setSignature();
        $this->setConfig($config);
    }

    /**
     * @return Jwt_Parser
     */
    public static function register(Jwt_Interface_Config $config) {
        return new self($config);
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
     * @param  Jwt_Interface_Decode|null  $decoder
     * @return $this
     */
    public function setDecoder(Jwt_Interface_Decode $decoder = null) {
        if (null === $decoder) {
            $this->decoder = new Jwt_Parsing_Decoder();
        } else {
            $this->decoder = $decoder;
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

    public function parse($jwt) {
        $data = $this->splitJwt($jwt);
        $header = $this->parseHeader($data[0]);
        $claims = $this->parseClaims($data[1]);
        $this->claims = $claims;
        $signature = $this->parseSignature($header, $data[2]);
        foreach ($claims as $name => $value) {
            if (isset($header[$name])) {
                $header[$name] = $value;
            }
        }

        if ($signature === null) {
            unset($data[2]);
        }

        $this->tokenServer = new Jwt_Token($header, $claims, $signature, $data);

        return $this;
    }

    /**
     * @return $this;
     * @throws Jwt_Exception_InvalidToken
     */
    public function verifyToken() {
        if (!$this->tokenServer->verify($this->signer, $this->config->getSecretKey())) {
            throw new Jwt_Exception_InvalidToken();
        }

        return $this;
    }

    /**
     * @return $this
     * @throws Jwt_Exception_InvalidToken
     */
    public function verifyEffectAt() {
        $nbf = $this->claims['nbf'];
        if ($nbf > time()) {
            throw new Jwt_Exception_InvalidToken();
        }

        return $this;
    }

    /**
     * @return $this
     * @throws Jwt_Exception_ExpireToken
     */
    public function verifyExpireAt() {
        $expireAt = $this->claims['exp'];
        if (time() > $expireAt) {
            throw new Jwt_Exception_ExpireToken();
        }

        return $this;
    }

    public function splitJwt($jwt) {
        if (!is_string($jwt)) {
            throw new InvalidArgumentException('The Jwt format must be string');
        }

        $data = explode('.', $jwt);

        if (count($data) != 3) {
            throw new InvalidArgumentException('The Jwt string must have two dots');
        }

        return $data;
    }

    public function parseHeader($header) {
        $header = $this->decoder->jsonDecode($this->decoder->base64UrlDecode($header));
        if (isset($header['enc'])) {
            throw new InvalidArgumentException('Encryption is not supported yet');
        }

        return $header;
    }

    public function parseClaims($claims) {
        $claims = $this->decoder->jsonDecode($this->decoder->base64UrlDecode($claims));

        foreach ($claims as $name => &$value) {
            $value = $this->claimFactory->create($name, $value);
        }

        return $claims;
    }

    public function parseSignature($header, $payload) {
        if ($payload == '' || !isset($header['alg']) || $header['alg'] == 'none') {
            return null;
        }
        $hash = $this->decoder->base64UrlDecode($payload);

        return new Jwt_Signer_Signature($hash);
    }
}