<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class ConstraintColor extends Constraint
{
    public $message = 'Color choice is disabled for the range %string%';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
