<?php

interface Jwt_Interface_Config {
    /**
     * @desc 设置签发人
     * @return $this
     */
    public function setIssued($issued);

    /**
     * @desc 设置受众
     * @return $this
     */
    public function setAudience($audience);

    /**
     * @desc 设置签发时间
     * @return $this
     */
    public function setIssuedAt($issuedAt = 0);

    /**
     * @desc 设置生效时间，在此之前是无效的
     * @return $this
     */
    public function setEffectAt($effectAt = 0);

    /**
     * @desc 设置过期时间
     * @return $this
     */
    public function setExpiresAt($expiresAt = 0);

    /**
     * @desc 设置签发字段
     * @return $this
     */
    public function setIdentifiedBy($identifiedBy);

    /**
     * @param  Jwt_Signer_Key  $key
     * @return mixed
     */
    public function setSecretKey($secretKey);

    /**
     * @desc 签发人
     * @return  string
     */
    public function getIssued();

    /**
     * @desc 受众
     * @return string
     */
    public function getAudience();

    /**
     * @desc 签发时间
     * @return int
     */
    public function getIssuedAt();

    /**
     * @desc 生效时间，在此之前是无效的
     * @return int
     */
    public function getEffectAt();

    /**
     * @desc 过期时间
     * @return int
     */
    public function getExpiresAt();

    /**
     * @desc 签发字段
     * @return string
     */
    public function getIdentifiedBy();

    /**
     * @return mixed
     */
    public function getSecretKey();


}