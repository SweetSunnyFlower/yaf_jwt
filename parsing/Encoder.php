<?php

class Jwt_Parsing_Encoder implements Jwt_Interface_Encode {
    public function jsonEncode($source) {
        $json = json_encode($source);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new RuntimeException('Error while encoding to JSON:'.json_last_error_msg());
        }

        return $json;
    }

    public function base64UrlEncode($source) {
        return str_replace('=', '', strtr(base64_encode($source), '+/', '-_'));
    }
}