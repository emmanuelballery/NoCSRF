<?php

require __DIR__ . '/../../CSRF/SessionProtection.php';

use CSRF\SessionProtection;

// Create a token
$token = SessionProtection::create('another_intention');

// Debug
var_dump($token);

// Validate a token
$valid = SessionProtection::isValid('another_intention', $token->getValue());

// Debug
var_dump($valid);

// Remove deprecated tokens
SessionProtection::clean();
