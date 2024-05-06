<?php
// src/Validator/Constraints/NotBlankOrSpaceValidator.php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotBlankOrSpaceValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (empty(trim($value))) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}