- Install

`composer require jiankechu/sign-in-with-apple`

[Authenticating Users with Sign in with Apple](https://developer.apple.com/documentation/sign_in_with_apple/sign_in_with_apple_rest_api/authenticating_users_with_sign_in_with_apple#3383773)

- use
```php
<?php
use ZJKe\SignInWithApple\IdentityToken;

$accessToken = 'eyJraWQiOiJZdXlYb1kiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwcGxlaWQuYXBwbGUuY29tIiwiYXVkIjoiY29tLnFpYW5rdS5hcHAuZ29vZHB1cmUiLCJleHAiOjE2MjQzODA4OTEsImlhdCI6MTYyNDI5NDQ5MSwic3ViIjoiMDAwNDAxLmQ4YWFkNzIxNzkxZjRjYWJhMTk1MDc0MjJiMDk0YzQ4LjA2NTIiLCJjX2hhc2giOiI4WmxOY0V4R01GdE9jeDlqNnhlV2V3IiwiZW1haWwiOiJKaWFua2UuekBmb3htYWlsLmNvbSIsImVtYWlsX3ZlcmlmaWVkIjoidHJ1ZSIsImF1dGhfdGltZSI6MTYyNDI5NDQ5MSwibm9uY2Vfc3VwcG9ydGVkIjp0cnVlfQ.oHtlpkkR-QvO2LNubVdTLO54YO-syEtiG44IHsfduzbMtyaJkin6lUx90FOMRI8PmbNn1lWom5Kg2ZcvjdWqE1rz98bWoXqw2GM-mwbgDmhysJnzUe3wtvRkiD9eA9ORrxlO1BNKB9NnaIre7jzVZAQnStWPZCzaay6YQF-ALMgvMgZuEgiPL-Niv3lCPZh5c8Gi91y9bLv2YR5E5MTUPJCs_aa68es2VTd8gq15zuvfXjpwf8qzTAOOTH_-G6xsq14V0l-9suw1NMll_mc72k0Mt-HhSFVudwvTYrxUAkr-m5qiiZnuNOpBMik_9O__WxLUO-meit8KLQA4Z7fOwQ';
$token = new IdentityToken();
$token->decode($accessToken);

print_r($token->getData());
print_r($token->sub);
//使用缓存
if($cache instanceof \Psr\SimpleCache\CacheInterface){
$token = new IdentityToken($cache);
}
//参考文档
//https://developer.apple.com/documentation/sign_in_with_apple/sign_in_with_apple_rest_api/authenticating_users_with_sign_in_with_apple#3383773
``` 

- uniapp获取jwt token
[iOS 苹果授权登录（Sign in with Apple）](https://ask.dcloud.net.cn/article/36651)
```javascript
//https://ask.dcloud.net.cn/article/36651
uni.login({  
    provider: 'apple',  
    success: function (loginRes) {  
    console.log(loginRes) 
    //loginRes= {"code":"","authResult":"{/"access_token/":/"eyJraWQiOiJZdXlYb1kiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwcGxlaWQuYXBwbGUuY29tIiwiYXVkIjoiY29tLnFpYW5rdS5hcHAuZ29vZHB1cmUiLCJleHAiOjE2MjQzODA4OTEsImlhdCI6MTYyNDI5NDQ5MSwic3ViIjoiMDAwNDAxLmQ4YWFkNzIxNzkxZjRjYWJhMTk1MDc0MjJiMDk0YzQ4LjA2NTIiLCJjX2hhc2giOiI4WmxOY0V4R01GdE9jeDlqNnhlV2V3IiwiZW1haWwiOiJKaWFua2UuekBmb3htYWlsLmNvbSIsImVtYWlsX3ZlcmlmaWVkIjoidHJ1ZSIsImF1dGhfdGltZSI6MTYyNDI5NDQ5MSwibm9uY2Vfc3VwcG9ydGVkIjp0cnVlfQ.oHtlpkkR-QvO2LNubVdTLO54YO-syEtiG44IHsfduzbMtyaJkin6lUx90FOMRI8PmbNn1lWom5Kg2ZcvjdWqE1rz98bWoXqw2GM-mwbgDmhysJnzUe3wtvRkiD9eA9ORrxlO1BNKB9NnaIre7jzVZAQnStWPZCzaay6YQF-ALMgvMgZuEgiPL-Niv3lCPZh5c8Gi91y9bLv2YR5E5MTUPJCs_aa68es2VTd8gq15zuvfXjpwf8qzTAOOTH_-G6xsq14V0l-9suw1NMll_mc72k0Mt-HhSFVudwvTYrxUAkr-m5qiiZnuNOpBMik_9O__WxLUO-meit8KLQA4Z7fOwQ/",/"openid/":/"000401.d8aad721791f4caba19507422b094c48.0652/"}","errMsg":"login:ok"}
    //access_token 传到后端校验
    } 
    });  
```