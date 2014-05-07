<?php

namespace CSRF;

/**
 * Class Token
 *
 * @author "Emmanuel BALLERY" <emmanuel.ballery@gmail.com>
 */
class Token
{
    /**
     * Intention
     *
     * @var string
     */
    private $intention;

    /**
     * Value
     *
     * @var string
     */
    private $value;

    /**
     * Creation timestamp
     *
     * @var int
     */
    private $created;

    /**
     * Lifetime in seconds
     *
     * @var int
     */
    private $lifetime;

    /**
     * @param string $intention Intention
     * @param int    $lifetime  Lifetime in seconds
     */
    function __construct($intention, $lifetime)
    {
        $this->intention = $intention;
        $this->lifetime = $lifetime;
        $this->created = time();

        if (function_exists('openssl_random_pseudo_bytes')) {
            $this->value = openssl_random_pseudo_bytes(16);
        } else {
            $this->value = uniqid(mt_rand(), true);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * Test whether this token is valid or not
     *
     * @param string|int $intention Token ID
     * @param string     $value     Token value
     *
     * @return bool
     */
    public function isValid($intention, $value)
    {
        return
            false === $this->isDeprecated() &&
            $intention === $this->intention &&
            $value === $this->value;
    }

    /**
     * Test whether this token is deprecated or not
     *
     * @return bool
     */
    public function isDeprecated()
    {
        return (time() > ($this->created + $this->lifetime));
    }

    /**
     * Set Intention
     *
     * @param string $intention Intention
     *
     * @return Token
     */
    public function setIntention($intention)
    {
        $this->intention = $intention;

        return $this;
    }

    /**
     * Get Intention
     *
     * @return string
     */
    public function getIntention()
    {
        return $this->intention;
    }

    /**
     * Set Value
     *
     * @param string $value Value
     *
     * @return Token
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get Value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set Created
     *
     * @param int $created Created
     *
     * @return Token
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get Created
     *
     * @return int
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set Lifetime
     *
     * @param int $lifetime Lifetime
     *
     * @return Token
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = $lifetime;

        return $this;
    }

    /**
     * Get Lifetime
     *
     * @return int
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }
}
