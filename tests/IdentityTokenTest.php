<?php

namespace ZJKe\SignInWithAppleTest;

use Firebase\JWT\JWK;
use ZJKe\SignInWithApple\IdentityToken;
use PHPUnit\Framework\TestCase;

class IdentityTokenTest extends TestCase
{


    public function testDecode()
    {
        $keyStr = <<<KEY
{
  "keys": [
    {
      "kty": "RSA",
      "kid": "86D88Kf",
      "use": "sig",
      "alg": "RS256",
      "n": "iGaLqP6y-SJCCBq5Hv6pGDbG_SQ11MNjH7rWHcCFYz4hGwHC4lcSurTlV8u3avoVNM8jXevG1Iu1SY11qInqUvjJur--hghr1b56OPJu6H1iKulSxGjEIyDP6c5BdE1uwprYyr4IO9th8fOwCPygjLFrh44XEGbDIFeImwvBAGOhmMB2AD1n1KviyNsH0bEB7phQtiLk-ILjv1bORSRl8AK677-1T8isGfHKXGZ_ZGtStDe7Lu0Ihp8zoUt59kx2o9uWpROkzF56ypresiIl4WprClRCjz8x6cPZXU2qNWhu71TQvUFwvIvbkE1oYaJMb0jcOTmBRZA2QuYw-zHLwQ",
      "e": "AQAB"
    },
    {
      "kty": "RSA",
      "kid": "eXaunmL",
      "use": "sig",
      "alg": "RS256",
      "n": "4dGQ7bQK8LgILOdLsYzfZjkEAoQeVC_aqyc8GC6RX7dq_KvRAQAWPvkam8VQv4GK5T4ogklEKEvj5ISBamdDNq1n52TpxQwI2EqxSk7I9fKPKhRt4F8-2yETlYvye-2s6NeWJim0KBtOVrk0gWvEDgd6WOqJl_yt5WBISvILNyVg1qAAM8JeX6dRPosahRVDjA52G2X-Tip84wqwyRpUlq2ybzcLh3zyhCitBOebiRWDQfG26EH9lTlJhll-p_Dg8vAXxJLIJ4SNLcqgFeZe4OfHLgdzMvxXZJnPp_VgmkcpUdRotazKZumj6dBPcXI_XID4Z4Z3OM1KrZPJNdUhxw",
      "e": "AQAB"
    },
    {
      "kty": "RSA",
      "kid": "YuyXoY",
      "use": "sig",
      "alg": "RS256",
      "n": "1JiU4l3YCeT4o0gVmxGTEK1IXR-Ghdg5Bzka12tzmtdCxU00ChH66aV-4HRBjF1t95IsaeHeDFRgmF0lJbTDTqa6_VZo2hc0zTiUAsGLacN6slePvDcR1IMucQGtPP5tGhIbU-HKabsKOFdD4VQ5PCXifjpN9R-1qOR571BxCAl4u1kUUIePAAJcBcqGRFSI_I1j_jbN3gflK_8ZNmgnPrXA0kZXzj1I7ZHgekGbZoxmDrzYm2zmja1MsE5A_JX7itBYnlR41LOtvLRCNtw7K3EFlbfB6hkPL-Swk5XNGbWZdTROmaTNzJhV-lWT0gGm6V1qWAK2qOZoIDa_3Ud0Gw",
      "e": "AQAB"
    }
  ]
}
KEY;

        $appleJwt = 'eyJraWQiOiJZdXlYb1kiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwcGxlaWQuYXBwbGUuY29tIiwiYXVkIjoiY29tLnFpYW5rdS5hcHAuZ29vZHB1cmUiLCJleHAiOjE2MjQzODA4OTEsImlhdCI6MTYyNDI5NDQ5MSwic3ViIjoiMDAwNDAxLmQ4YWFkNzIxNzkxZjRjYWJhMTk1MDc0MjJiMDk0YzQ4LjA2NTIiLCJjX2hhc2giOiI4WmxOY0V4R01GdE9jeDlqNnhlV2V3IiwiZW1haWwiOiJKaWFua2UuekBmb3htYWlsLmNvbSIsImVtYWlsX3ZlcmlmaWVkIjoidHJ1ZSIsImF1dGhfdGltZSI6MTYyNDI5NDQ5MSwibm9uY2Vfc3VwcG9ydGVkIjp0cnVlfQ.oHtlpkkR-QvO2LNubVdTLO54YO-syEtiG44IHsfduzbMtyaJkin6lUx90FOMRI8PmbNn1lWom5Kg2ZcvjdWqE1rz98bWoXqw2GM-mwbgDmhysJnzUe3wtvRkiD9eA9ORrxlO1BNKB9NnaIre7jzVZAQnStWPZCzaay6YQF-ALMgvMgZuEgiPL-Niv3lCPZh5c8Gi91y9bLv2YR5E5MTUPJCs_aa68es2VTd8gq15zuvfXjpwf8qzTAOOTH_-G6xsq14V0l-9suw1NMll_mc72k0Mt-HhSFVudwvTYrxUAkr-m5qiiZnuNOpBMik_9O__WxLUO-meit8KLQA4Z7fOwQ';
        $keys = JWK::parseKeySet(json_decode($keyStr, 1));
        $token = new IdentityToken();
        $token->setPublicKeys($keys);
        $token->decode($appleJwt);
        $this->assertIsObject($token->getData());
        $this->assertEquals('000401.d8aad721791f4caba19507422b094c48.0652', $token->sub);
    }
}
