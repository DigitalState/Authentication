<?php

namespace AppBundle\Entity\Attribute\Accessor;

use AppBundle\Entity\Registration as RegistrationEntity;

/**
 * Trait Registration
 */
trait Registration
{
    /**
     * Set registration
     *
     * @param \AppBundle\Entity\Registration $registration
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
     * @return \AppBundle\Entity\Registration
     */
    public function getRegistration()
    {
        return $this->registration;
    }
}
