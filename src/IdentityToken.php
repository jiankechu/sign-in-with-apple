<?php

namespace ZJKe\SignInWithApple;

use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\SimpleCache\CacheInterface;
use UnexpectedValueException;

/**
 * Class IdentityToken
 *
 * @package       SignInWithApple
 *
 * @property-read string $iss
 * @property-read string $aud
 * @property-read int $exp
 * @property-read int $iat
 * @property-read string $sub
 * @property-read string $nonce
 * @property-read string $c_hash
 * @property-read int $nonce_supported
 * @property-read string $email
 * @property-read bool $email_verified
 * @property-read int $auth_time
 * @property-read string $at_hash
 *
 *
 * @see https://developer.apple.com/documentation/sign_in_with_apple/sign_in_with_apple_rest_api/authenticating_users_with_sign_in_with_apple#3383773
 *
 */
class IdentityToken
{
    /**
     * @var array
     */
    protected $publicKeys;

    /**
     * @var CacheInterface|null
     */
    protected $cache;
    /**
     * @var string
     */
    protected $cacheKey = 'appleid_apple_com_auth_keys';

    /**
     * @var object|null
     */
    private $data;

    /**
     * @throws GuzzleException
     * @see https://developer.apple.com/documentation/sign_in_with_apple/fetch_apple_s_public_key_for_verifying_token_signature
     */
    protected function reloadPublicKeys()
    {
        $curl = new Client();
        $resp = $curl->request('GET', 'https://appleid.apple.com/auth/keys');
        $keyStr = $resp->getBody()->getContents();
        if ($this->cache) {
            $this->cache->set($this->cacheKey, $keyStr);
        }
        $keys = $this->parseKeySet($keyStr);
        $this->publicKeys = $keys;
        return $keys;
    }

    protected function parseKeySet(string $keyStr)
    {
        $keys = json_decode($keyStr, 1);
        $keys = JWK::parseKeySet($keys);

        return $keys;
    }

    protected function getPublicKeys()
    {
        if ($this->publicKeys) {
            return $this->publicKeys;
        }
        if ($this->cache && $this->cache->has($this->cacheKey)) {
            $keyStr = $this->cache->get($this->cacheKey);
            $keys = $this->parseKeySet($keyStr);
        } else {
            $keys = $this->reloadPublicKeys();
        }
        return $keys;
    }

    public function setPublicKeys($keys)
    {
        $this->publicKeys = $keys;
        return $this;
    }

    /**
     * IdentityToken constructor.
     * @param CacheInterface|null $cache
     * @param string|null $cacheKey
     */
    public function __construct($cache = null, $cacheKey = null)
    {
        if ($cache) {
            $this->cache = $cache;
        }
        if ($cacheKey) {
            $this->cacheKey = $cacheKey;
        }
    }

    public function decode(string $idTokenString, string $nonce = null)
    {
        $keys = $this->getPublicKeys();
        if ($this->cache) {
            $keys = $this->checkOrUpdateKeys($idTokenString, $keys);
        }
        $this->data = JWT::decode($idTokenString, $keys, ['RS256']);

        if (!is_null($nonce) && !empty($this->data->nonce_supported) && $this->data->nonce !== $nonce) {
            $this->data = null;
            throw new UnexpectedValueException('Invalid nonce');
        }
        return $this;
    }

    protected function checkOrUpdateKeys($jwt, array $keys)
    {
        $tks = \explode('.', $jwt);
        if (\count($tks) != 3) {
            throw new UnexpectedValueException('Wrong number of segments');
        }
        $headb64 = $tks[0];
        if (null === ($header = JWT::jsonDecode(JWT::urlsafeB64Decode($headb64)))) {
            throw new UnexpectedValueException('Invalid header encoding');
        }

        if (empty($header->kid)) {
            throw new UnexpectedValueException('Empty key id kid');
        }
        if (!isset($keys[$header->kid])) {
            $keys = $this->reloadPublicKeys();
        }
        return $keys;
    }

    public function __get(string $name)
    {
        if (!$this->__isset($name)) {
            return null;
        }

        return $this->data->$name;
    }

    public function __isset(string $name): bool
    {
        return is_object($this->data) && property_exists($this->data, $name);
    }

    public function getData()
    {
        return $this->data;
    }
}
