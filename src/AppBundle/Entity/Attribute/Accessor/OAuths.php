<?php

namespace AppBundle\Entity\Attribute\Accessor;

use AppBundle\Entity\OAuth;

/**
 * Trait OAuths
 */
trait OAuths
{
    /**
     * Add oauth
     *
     * @param \AppBundle\Entity\OAuth $oauth
     * @return object
     */
    public function addOAuth(OAuth $oauth)
    {
        if (!$this->oauths->contains($oauth)) {
            $this->oauths->add($oauth);
        }

        return $this;
    }

    /**
     * Remove oauths
     *
     * @param \AppBundle\Entity\OAuth $oauth
     * @return object
     */
    public function removeScenario(OAuth $oauth)
    {
        if ($this->oauths->contains($oauth)) {
            $this->oauths->removeElement($oauth);
        }

        return $this;
    }

    /**
     * Get oauths
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOAuths()
    {
        return $this->oauths;
    }
}
