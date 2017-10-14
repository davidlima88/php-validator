<?php

use Humber\Validation\Validator;
require_once "Humber/Validation/Validator.php";

$formRequest = [
    'formEmail' => 'david@gmail.com',
    'formName' => 'David'
];

$rules = [
    'formEmail' => 'email:|filled',
    'formName' => 'filled'
];

$messages = [
    'formEmail.email' => 'Invalid email',
    'formEmail.filled' => 'Empty email',
    'formName.filled' => 'Empty name'
];

$validator = new Validator($rules, $messages);
$errors = $validator->validate($formRequest);
var_export($errors);