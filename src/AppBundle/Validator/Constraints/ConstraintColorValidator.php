<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\Vehicle;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class ConstraintColorValidator extends ConstraintValidator
{
    /**
     * @param Vehicle $vehicle
     * @param Constraint $constraint
     */
    public function validate($vehicle, Constraint $constraint)
    {
        if (Vehicle::BASIC === $vehicle->getRange() && !empty($vehicle->getColor())) {
            $this->context->addViolationAt('color', $constraint->message, array('%string%' => $vehicle->humanRange()), null);
        }
    }
}
