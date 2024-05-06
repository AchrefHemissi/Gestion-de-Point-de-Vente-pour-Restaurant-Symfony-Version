<?php
// src/Validator/Constraints/NotBlankOrSpace.php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class NoBlankOrSpace extends Constraint
{
public $message = 'The value cannot be blank or a string of spaces.';
}