<?php

namespace App\Entity\Attribute\Accessor;

use App\Entity\Registration as RegistrationEntity;

/**
 * Trait Registration
 */
trait Registration
{
    /**
     * Set registration
     *
     * @param \App\Entity\Registration $registration
     * @return object
     */
    public function setRegistration(RegistrationEntity $registration = null)
    {
        $this->registration = $registration;

        return $this;
    }

    /**
     * Get registration
     *
     * @return \App\Entity\Registration
     */
    public function getRegistration()
    {
        return $this->registration;
    }
}
