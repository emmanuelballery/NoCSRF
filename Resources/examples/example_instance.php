<?php

require __DIR__ . '/../../CSRF/Storage.php';
require __DIR__ . '/../../CSRF/Generator.php';
require __DIR__ . '/../../CSRF/Token.php';

use CSRF\Generator;
use CSRF\Storage;

// Create a storage
session_start();
$storage = new Storage($_SESSION);

// Create a generator
$generator = new Generator($storage);

// Create a token
$token = $generator->create('a_specific_intention');

// Debug
var_dump($token);

// Validate a token
$valid = $generator->isValid('a_specific_intention', $token->getValue());

// Debug
var_dump($valid);

// Remove deprecated tokens
$generator->clean();
