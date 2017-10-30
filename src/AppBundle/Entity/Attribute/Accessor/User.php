<?php

namespace AppBundle\Entity\Attribute\Accessor;

use AppBundle\Entity\User as UserEntity;

/**
 * Trait User
 */
trait User
{
    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return object
     */
    public function setUser(UserEntity $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
