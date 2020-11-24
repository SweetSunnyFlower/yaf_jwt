# yaf_jwt

```php
        $secretKey = 'secretKey';
        $issued = 'issued';
        $expire = 3600;
        $config = new Jwt_Config_Default($secretKey, $issued, 'dmlconf', time(), time(), $expire, 'login');
        $claim = array();
        return Jwt_Factory::register($config, $claim)->getToken();
        $secretKey = 'secretKey';
        $issued = 'issued';
        $config = new Jwt_Config_Default($secretKey, $issued, 'dmlconf', time(), time(), 0, 'login');
        return Jwt_Parser::register($config)->parse($token)->verifyToken()->verifyEffectAt()->verifyExpireAt()->claims;
```
