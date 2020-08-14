<?php

class Jwt_Claim_Factory implements Jwt_Interface_ClaimFactory
{

    private $callbacks = array();

    public function __construct(array $callbacks = array())
    {
        $this->callbacks = array_merge(
            array(
                'iat' => 'Jwt_Claim_CreateLesserOrEqualsTo',
                'nbf' => 'Jwt_Claim_CreateLesserOrEqualsTo',
                'exp' => 'Jwt_Claim_CreateGreaterOrEqualsTo',
                'iss' => 'Jwt_Claim_CreateEqualsTo',
                'aud' => 'Jwt_Claim_CreateEqualsTo',
                'sub' => 'Jwt_Claim_CreateEqualsTo',
                'jti' => 'Jwt_Claim_CreateEqualsTo',
            ),
            $callbacks
        );
    }

    public function create($name, $value)
    {
        if (!empty($this->callbacks[$name])){
            return new $this->callbacks[$name]($name, $value);
        }

        return new Jwt_Claim_Basic($name, $value);
    }
}