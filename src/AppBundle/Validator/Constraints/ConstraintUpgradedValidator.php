<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\Booking;
use AppBundle\Service\UpgraderService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class ConstraintUpgradedValidator extends ConstraintValidator
{
    /**
     * @var UpgraderService
     */
    protected $service;

    public function __construct(UpgraderService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Booking $booking
     * @param Constraint $constraint
     */
    public function validate($booking, Constraint $constraint)
    {
        if (!$booking->getUpgraded()) {
            return;
        }

        $isValid = $this->service->validateUpgrade($booking);

        if (!$isValid) {
            $this->context->addViolationAt('upgraded', $constraint->message, array(), null);
            return;
        }
    }

}
