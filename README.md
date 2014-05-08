NoCSRF
======

PHP5 CSRF protection

## Instance

```php
// Create a storage (session here)
session_start();
$storage = new Storage($_SESSION);

// Create a generator
$generator = new Generator($storage);

// Create a token (with an intention)
$token = $generator->create('delete_item_intention');

// Validate a token
$generator->isValid('delete_item_intention', $token->getValue());

// Remove deprecated tokens
$generator->clean();
```

## Static

```php
// Create a token (with an intention)
$token = SessionProtection::create('another_intention');

// Validate a token
$valid = SessionProtection::isValid('another_intention', $token->getValue());

// Remove deprecated tokens
SessionProtection::clean();
```

## Examples

  * [Resources/examples/instance.php](https://github.com/emmanuelballery/NoCSRF/blob/master/Resources/examples/instance.php)
  * [Resources/examples/static.php](https://github.com/emmanuelballery/NoCSRF/blob/master/Resources/examples/static.php)
