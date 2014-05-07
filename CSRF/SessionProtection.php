<?php

namespace CSRF;

/**
 * Class SessionProtection
 *
 * @author "Emmanuel BALLERY" <emmanuel.ballery@gmail.com>
 */
class SessionProtection
{
    /**
     * @var Generator
     */
    private static $generator;

    /**
     * Get Generator
     *
     * @return Generator
     */
    public static function getGenerator()
    {
        // Create a generator if it doesn't exist
        if (null === self::$generator) {
            // Start session ? (PHP < 5.4)
            if ('' === session_id()) {
                session_start();
            }

            self::$generator = new Generator(new Storage($_SESSION));
        }

        return self::$generator;
    }

    /**
     * Create a token
     *
     * @param string $intention Token intention
     * @param int    $lifetime  Token lifetime (default to Generator::TOKEN_LIFETIME)
     *
     * @return Token
     */
    public static function create($intention, $lifetime = Generator::TOKEN_LIFETIME)
    {
        return self::getGenerator()->create($intention, $lifetime);
    }

    /**
     * Test whether a couple intention/value is valid or not
     *
     * @param $intention
     * @param $value
     *
     * @return bool
     */
    public static function isValid($intention, $value)
    {
        return self::getGenerator()->isValid($intention, $value);
    }

    /**
     * Remove deprecated tokens from storage
     */
    public static function clean()
    {
        self::getGenerator()->clean();
    }
}
