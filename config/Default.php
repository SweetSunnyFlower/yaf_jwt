<?php

class Jwt_Config_Default implements Jwt_Interface_Config{

    /**
     * @desc 签发人
     * @var string
     */
    public $issued;

    /**
     * @desc 受众
     * @var string
     */
    public $audience;

    /**
     * @desc 签发时间
     * @var int
     */
    public $issuedAt;

    /**
     * @desc 生效时间
     * @var int
     */
    public $effectAt;

    /**
     * @desc 过期时间
     * @var int
     */
    public $expiresAt;

    /**
     * @desc 签发字段
     * @var string
     */
    public $identifiedBy;

    public $secretKey;

    /**
     * Jwt_Config_Default constructor.
     * @param $secretKey
     * @param null $issued
     * @param null $audience
     * @param null $issuedAt
     * @param null $effectAt
     * @param null $expiresAt
     * @param null $identifiedBy
     */
    public function __construct($secretKey, $issued = null, $audience = null, $issuedAt = null, $effectAt = null, $expiresAt = null, $identifiedBy = null){
        $this->setSecretKey($secretKey)
            ->setIssued($issued)
            ->setAudience($audience)
            ->setIssuedAt($issuedAt)
            ->setEffectAt($effectAt)
            ->setExpiresAt($expiresAt)
            ->setIdentifiedBy($identifiedBy);
    }

    /**
     * @desc 设置签发人
     * @param $issued
     * @return $this
     */
    public function setIssued($issued){
        $this->issued = $issued;
        return $this;
    }

    /**
     * @desc 设置受众
     * @param $audience
     * @return $this
     */
    public function setAudience($audience){
        $this->audience = $audience;
        return $this;
    }

    /**
     * @desc 设置签发时间
     * @param $issuedAt
     * @return $this
     */
    public function setIssuedAt(int $issuedAt = null){
        $this->issuedAt = $issuedAt ? $issuedAt : time();
        return $this;
    }

    /**
     * @desc 设置生效时间
     * @param $effectAt
     * @return $this
     */
    public function setEffectAt(int $effectAt = 0){
        $this->effectAt = $effectAt;
        return $this;
    }

    /**
     * @desc 设置生效时间
     * @param int $expiresAt
     * @return $this
     */
    public function setExpiresAt(int $expiresAt){
        $this->expiresAt = $expiresAt;
        return $this;
    }

    /**
     * @desc 设置签发字段
     * @param $identifiedBy
     * @return $this
     */
    public function setIdentifiedBy($identifiedBy){
        $this->identifiedBy = $identifiedBy;
        return $this;
    }

    /**
     * @param $secretKey
     * @return $this|mixed
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = new Jwt_Signer_Key($secretKey);
        return $this;
    }

    /**
     * @return string
     */
    public function getIssued(){
        return $this->issued;
    }

    /**
     * @return string
     */
    public function getAudience(){
        return $this->audience;
    }

    /**
     * @return int
     */
    public function getIssuedAt(){
        return $this->issuedAt;
    }

    /**
     * @return int
     */
    public function getEffectAt(){
        return $this->effectAt;
    }

    /**
     * @return int
     */
    public function getExpiresAt(){
        return $this->expiresAt;
    }

    /**
     * @return string
     */
    public function getIdentifiedBy(){
        return $this->identifiedBy;
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }
}