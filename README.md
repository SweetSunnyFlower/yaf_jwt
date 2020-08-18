# yaf_jwt

```php
$token = Jwt_Factory::register('secretKey', array(array('username' => 'gaobingbing')))->token()->getToken();

$isLogin = (new Jwt_Parser(new Jwt_Parsing_Decoder(), new Jwt_Claim_Factory()))->parse($token)->verify(new Jwt_Signer_Hmac_Sha256(), (new Jwt_Config_Default('fdfasff', 'baidu.com', 'ccapp', time(), 0, time() + 3600, 1))->getSecretKey());
```
