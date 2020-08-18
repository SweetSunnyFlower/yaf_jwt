<?php

class Jwt_Parsing_Decoder implements Jwt_Interface_Decode
{

    public function jsonDecode($sourceJson)
    {
        $source = json_decode($sourceJson, true);

        if (json_last_error() != JSON_ERROR_NONE){
            throw new RuntimeException('Error while JSON decoding to string:' . json_last_error_msg());
        }

        return $source;
    }

    public function base64UrlDecode($sourceJson)
    {
        if ($remainder = strlen($sourceJson) % 4){
            $sourceJson .= str_repeat('=', 4 - $remainder);
        }

        return base64_decode(strtr($sourceJson, '-_', '+/'));
    }

}