<?php

final class Jwt_Signer_Key
{
    private $content;

    private $passphrase;

    public function __construct($content, $passphrase = null){
        $this->setContent($content);
        $this->passphrase = $passphrase;
    }

    private function setContent($content){
        if (strpos($content, 'file://') === 0){
            $content = $this->readFile($content);
        }
        return $this->content = $content;
    }

    public function getContent(){
        return $this->content;
    }

    public function getPassphrase(){
        return $this->passphrase;
    }

    private function readFile($content){
        try {
            $file = new SplFileObject(substr($content, 7));
            $content = '';

            while (!$file->eof()){
                $content .= $file->fgets();
            }

            return $content;
        }catch (Exception $exception){
            throw new InvalidArgumentException('You must provide a valid key file', 0, $exception);
        }
    }
}