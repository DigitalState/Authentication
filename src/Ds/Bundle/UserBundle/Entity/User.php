<?php

namespace Ds\Bundle\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Ds\Component\Entity\Entity\Identifiable;
use Ds\Component\Entity\Entity\Uuidentifiable;
use Ds\Component\Entity\Entity\Identitiable;
use Ds\Component\Entity\Entity\Accessor;
use Knp\DoctrineBehaviors\Model As Behavior;
use FOS\UserBundle\Model\UserInterface;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation As Serializer;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     attributes={
 *         "normalization_context"={"groups"={"user_output"}},
 *         "denormalization_context"={"groups"={"user_input"}}
 *     }
 * )
 * @ORM\Entity
 * @ORM\Table(name="ds_user")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\HasLifecycleCallbacks
 * @ORMAssert\UniqueEntity(fields="uuid")
 */
class User extends BaseUser implements Identifiable, Uuidentifiable, Identitiable
{
    use Behavior\Timestampable\Timestampable;

    use Accessor\Id;
    use Accessor\Uuid;
    use Accessor\Identity;
    use Accessor\IdentityUuid;

    /**
     * @var integer
     * @ApiProperty(identifier=false)
     * @Serializer\Groups({"user_output_user"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ApiProperty(identifier=true)
     * @Serializer\Groups({"user_output"})
     * @ORM\Column(name="uuid", type="guid", unique=true)
     * @Assert\Uuid
     */
    protected $uuid;

    /**
     * @var \DateTime
     * @Serializer\Groups({"user_output_user"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @Serializer\Groups({"user_output_admin"})
     */
    protected $updatedAt;

    /**
     * @var string
     * @Serializer\Groups({"user_output", "user_input"})
     */
    protected $username;

    /**
     * @var string
     * @Serializer\Groups({"user_input"})
     */
    protected $plainPassword;

    /**
     * @var string
     * @Serializer\Groups({"user_output", "user_input"})
     */
    protected $email;

    /**
     * @var boolean
     * @Serializer\Groups({"user_output_user", "user_input_user"})
     */
    protected $enabled;

    /**
     * @var \DateTime
     * @Serializer\Groups({"user_output_user"})
     */
    protected $lastLogin;

    /**
     * @var \Doctrine\Common\Collections\Collection;
     * @Serializer\Groups({"user_output", "user_input_user"})
     */
    protected $groups;

    /**
     * @var array
     * @Serializer\Groups({"user_output", "user_input_user"})
     */
    protected $roles;

    /**
     * @var string
     * @Serializer\Groups({"user_output"})
     * @ORM\Column(name="identity", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    protected $identity;

    /**
     * @var string
     * @Serializer\Groups({"user_output"})
     * @ORM\Column(name="identity_uuid", type="guid", unique=true)
     * @Assert\Uuid
     */
    protected $identityUuid;

    /**
     * Check if user is user
     *
     * @param \FOS\UserBundle\Model\UserInterface $user
     * @return boolean
     */
    public function isUser(UserInterface $user = null)
    {
        return $user instanceof self && $user->id === $this->id;
    }
}
