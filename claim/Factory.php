<?php

class Jwt_Claim_Factory implements Jwt_Interface_ClaimFactory {

    private $callbacks = array();

    public function __construct(array $callbacks = array()) {
        $this->callbacks = array_merge(
            array(
                'iat' => 'Jwt_Claim_LesserOrEqualsTo',
                'nbf' => 'Jwt_Claim_LesserOrEqualsTo',
                'exp' => 'Jwt_Claim_GreaterOrEqualsTo',
                'iss' => 'Jwt_Claim_EqualsTo',
                'aud' => 'Jwt_Claim_EqualsTo',
                'sub' => 'Jwt_Claim_EqualsTo',
                'jti' => 'Jwt_Claim_EqualsTo',
            ),
            $callbacks
        );
    }

    public function create($name, $value) {
        if (!empty($this->callbacks[$name])) {
            return (new $this->callbacks[$name]($name, $value))->getValue();
        }

        return (new Jwt_Claim_Basic($name, $value))->getValue();
    }
}