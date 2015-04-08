<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class ConstraintUpgraded extends Constraint
{
    public $message = 'You cannot upgrade this booking';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy()
    {
        return 'booking_upgraded';
    }
}
