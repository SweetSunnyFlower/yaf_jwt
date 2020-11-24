<?php

/**
 * Interface Jwt_Interface_Decode
 */
interface Jwt_Interface_Decode {

    public function jsonDecode($sourceJson);

    public function base64UrlDecode($sourceJson);
}