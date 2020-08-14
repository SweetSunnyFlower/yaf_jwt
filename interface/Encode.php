<?php

/**
 * Interface Jwt_Interface_Encode
 */
interface Jwt_Interface_Encode
{

    public function jsonEncode($source);

    public function base64UrlEncode($source);
}