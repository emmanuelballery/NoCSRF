<?php

namespace CSRF;

/**
 * Class Generator
 *
 * @author "Emmanuel BALLERY" <emmanuel.ballery@gmail.com>
 */
class Generator
{
    /**
     * Default token lifetime
     *
     * @var int
     */
    const TOKEN_LIFETIME = 300;

    /**
     * Token storage key
     *
     * @var string
     */
    const TOKEN_STORAGE_KEY = '_token';

    /**
     * @var Storage
     */
    private $storage;

    /**
     * @param Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Create a token
     *
     * @param string $intention Token intention
     * @param int    $lifetime  Token lifetime (default to self::TOKEN_LIFETIME)
     *
     * @return Token
     */
    public function create($intention, $lifetime = self::TOKEN_LIFETIME)
    {
        // Get tokens
        if (null === $intentions = $this->getStorage()->get(self::TOKEN_STORAGE_KEY)) {
            $intentions = array();
        }

        // Create a structure for this intention
        if (false === array_key_exists($intention, $intentions)) {
            $intentions[$intention] = array();
        }

        // Store this token
        $intentions[$intention][] = $token = new Token($intention, $lifetime);
        $this->getStorage()->set(self::TOKEN_STORAGE_KEY, $intentions);

        return $token;
    }

    /**
     * Test whether a couple intention/value is valid or not
     *
     * @param $intention
     * @param $value
     *
     * @return bool
     */
    public function isValid($intention, $value)
    {
        // Pessimistic approach
        $valid = false;

        if (null !== $intentions = $this->getStorage()->get(self::TOKEN_STORAGE_KEY)) {
            foreach ($intentions as $tokens) {
                foreach ($tokens as $token) {
                    if ($token instanceof Token) {
                        $valid = $valid || $token->isValid($intention, $value);
                    }
                }
            }
        }

        return $valid;
    }

    /**
     * Remove deprecated tokens from storage
     */
    public function clean()
    {
        $preservedTokens = array();

        if (null !== $intentions = $this->getStorage()->get(self::TOKEN_STORAGE_KEY)) {
            foreach ($intentions as $intention => $tokens) {
                foreach ($tokens as $token) {
                    if ($token instanceof Token) {
                        if (false === $token->isDeprecated()) {
                            $preservedTokens[$intention][] = $token;
                        }
                    }
                }
            }
        }

        $this->getStorage()->set(self::TOKEN_STORAGE_KEY, $preservedTokens);
    }

    /**
     * Get Storage
     *
     * @return Storage
     */
    public function getStorage()
    {
        return $this->storage;
    }
}
