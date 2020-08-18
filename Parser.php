<?php

class Jwt_Parser{
    private $decoder;

    private $claimFactory;

    public function __construct(
        Jwt_Interface_Decode $decoder,
        Jwt_Interface_ClaimFactory $claimFactory
    )
    {
        $this->decoder = $decoder;
        $this->claimFactory = $claimFactory;
    }

    public function parse($jwt){
        $data = $this->splitJwt($jwt);
        $header = $this->parseHeader($data[0]);
        $claims = $this->parseClaims($data[1]);
        $signature = $this->parseSignature($header, $data[2]);
        foreach ($claims as $name => $value) {
            if (isset($header[$name])) {
                $header[$name] = $value;
            }
        }

        if ($signature === null) {
            unset($data[2]);
        }
        return new Jwt_Token($header, $claims, $signature, $data);

    }

    public function splitJwt($jwt){
        if (!is_string($jwt)){
            throw new InvalidArgumentException('The Jwt format must be string');
        }

        $data = explode('.', $jwt);

        if (count($data) != 3){
            throw new InvalidArgumentException('The Jwt string must have two dots');
        }
        return $data;
    }

    public function parseHeader($header){
        $header = $this->decoder->jsonDecode($this->decoder->base64UrlDecode($header));
        if (isset($header['enc'])){
            throw new InvalidArgumentException('Encryption is not supported yet');
        }

        return $header;
    }

    public function parseClaims($claims){
        $claims = $this->decoder->jsonDecode($this->decoder->base64UrlDecode($claims));

        foreach ($claims as $name => &$value){
            $value = $this->claimFactory->create($name, $value);
        }
        return $claims;
    }

    public function parseSignature($header, $payload){
        if ($payload == '' || !isset($header['alg']) || $header['alg'] == 'none'){
            return null;
        }
        $hash = $this->decoder->base64UrlDecode($payload);

        return new Jwt_Signer_Signature($hash);

    }
}