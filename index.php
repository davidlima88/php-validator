<?php

use Humber\Validation\Validator;

require_once "Humber/Validation/Validator.php";

$formRequest = [
    'formEmail' => 'david@gmail.com',
    'formName' => "http://wwwcom"
];

$rules = [
    'formEmail' => 'email|filled',
    'formName' => "url"
];

$messages = [
    'formEmail.email' => 'Invalid email',
    'formEmail.filled' => 'Empty email',
    'formName.array' => 'Empty name'
];

$validator = new Validator($rules, $messages);
$errors = $validator->validate($formRequest);
var_export($errors);