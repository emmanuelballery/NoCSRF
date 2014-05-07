NoCSRF
======

PHP5 CSRF protection

## Instance

### Create a storage (session here)

```php
session_start();
$storage = new Storage($_SESSION);
```

### Generate a generator

```php
$generator = new Generator($storage);
```

### Create a token (with an intention)

```php
$token = $generator->create('delete_item_intention');
```

### Validate a token

```php
$generator->isValid('delete_item_intention', $token->getValue());
```

### Remove deprecated tokens

```php
$generator->clean();
```

## Static

### Create a token (with an intention)

```php
$token = SessionProtection::create('another_intention');
```

### Validate a token

```php
$valid = SessionProtection::isValid('another_intention', $token->getValue());
```

### Remove deprecated tokens

```php
SessionProtection::clean();
```
