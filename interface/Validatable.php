<?php

interface Jwt_Interface_Validatable {
    public function validate(Jwt_Interface_ValidationSource $source);
}