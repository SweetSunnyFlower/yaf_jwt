<?php

class Jwt_Claim_LesserOrEqualsTo extends Jwt_Claim_Basic implements Jwt_Interface_Validatable
{

    public function validate(Jwt_Interface_ValidationSource $source)
    {
        // TODO: Implement validate() method.
        if (($name = $this->getName()) && $source->has($name)) {
            return $this->getValue() === $source->get($name);
        }
        return true;
    }
}