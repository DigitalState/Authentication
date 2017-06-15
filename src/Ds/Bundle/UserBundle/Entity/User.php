<?php

namespace Ds\Bundle\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Model\Type\Identitiable;
use Ds\Component\Model\Attribute\Accessor;
use Knp\DoctrineBehaviors\Model As Behavior;
use FOS\UserBundle\Model\UserInterface;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation As Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;

/**
 * @ApiResource(
 *     attributes={
 *         "filters"={"ds_user.user.filter"},
 *         "normalization_context"={"groups"={"user_output"}},
 *         "denormalization_context"={"groups"={"user_input"}}
 *     }
 * )
 * @ORM\Entity
 * @ORM\Table(name="ds_user")
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
     * @ApiProperty(identifier=false, writable=false)
     * @Serializer\Groups({"user_output"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ApiProperty(identifier=true, writable=false)
     * @Serializer\Groups({"user_output"})
     * @ORM\Column(name="uuid", type="guid", unique=true)
     * @Assert\Uuid
     */
    protected $uuid;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"user_output"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"user_output"})
     */
    protected $updatedAt;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"user_output", "user_input"})
     */
    protected $username;

    /**
     * @var string
     * @ApiProperty(readable=false)
     * @Serializer\Groups({"user_input"})
     */
    protected $plainPassword;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"user_output", "user_input"})
     */
    protected $email;

    /**
     * @var boolean
     * @ApiProperty
     * @Serializer\Groups({"user_output", "user_input"})
     */
    protected $enabled;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"user_output"})
     */
    protected $lastLogin;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ApiProperty
     * @Serializer\Groups({"user_output", "user_input"})
     */
    protected $groups;

    /**
     * @var array
     * @ApiProperty
     * @Serializer\Groups({"user_output", "user_input"})
     */
    protected $roles;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"user_output", "user_input"})
     * @ORM\Column(name="identity", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    protected $identity;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"user_output", "user_input"})
     * @ORM\Column(name="identity_uuid", type="guid", unique=true, nullable=true)
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
