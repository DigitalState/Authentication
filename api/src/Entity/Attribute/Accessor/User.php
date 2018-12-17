<?php

namespace App\Entity\Attribute\Accessor;

use App\Entity\User as UserEntity;

/**
 * Trait User
 */
trait User
{
    /**
     * Set user
     *
     * @param \App\Entity\User $user
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
     * @return \App\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
