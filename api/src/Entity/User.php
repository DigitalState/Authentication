<?php

namespace App\Entity;

use App\Entity\Attribute\Accessor as EntityAccessor;
use DateTime;
use Ds\Component\Model\Type\Deletable;
use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Identitiable;
use Ds\Component\Model\Type\Versionable;
use Ds\Component\Model\Attribute\Accessor;
use Ds\Component\Tenant\Model\Attribute\Accessor as TenantAccessor;
use Ds\Component\Tenant\Model\Type\Tenantable;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\UserBundle\Model\UserInterface;
use Knp\DoctrineBehaviors\Model as Behavior;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;
use Symfony\Component\Serializer\Annotation As Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     attributes={
 *         "normalization_context"={
 *             "groups"={"user_output"}
 *         },
 *         "denormalization_context"={
 *             "groups"={"user_input"}
 *         },
 *         "filters"={
 *             "app.user.search",
 *             "app.user.date",
 *             "app.user.boolean",
 *             "app.user.order"
 *         }
 *     }
 * )
 * @ORM\Entity
 * @ORM\Table(
 *     name="app_user",
 *     uniqueConstraints={
 *        @ORM\UniqueConstraint(columns={"username", "tenant"}),
 *        @ORM\UniqueConstraint(columns={"username_canonical", "tenant"}),
 *        @ORM\UniqueConstraint(columns={"email", "tenant"}),
 *        @ORM\UniqueConstraint(columns={"email_canonical", "tenant"})
 *     }
 * )
 * @ORM\AttributeOverrides({
 *     @ORM\AttributeOverride(
 *         name="usernameCanonical",
 *         column=@ORM\Column(type="string", name="username_canonical", length=180, unique=false)
 *     ),
 *     @ORM\AttributeOverride(
 *         name="emailCanonical",
 *         column=@ORM\Column(type="string", name="email_canonical", length=180, unique=false)
 *     )
 * })
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 * @ORMAssert\UniqueEntity(fields="uuid")
 * @ORMAssert\UniqueEntity(fields={"username", "tenant"})
 * @ORMAssert\UniqueEntity(fields={"usernameCanonical", "tenant"})
 * @ORMAssert\UniqueEntity(fields={"email", "tenant"})
 * @ORMAssert\UniqueEntity(fields={"emailCanonical", "tenant"})
 */
class User extends BaseUser implements Identifiable, Uuidentifiable, Ownable, Identitiable, Deletable, Versionable, Tenantable
{
    use Behavior\Timestampable\Timestampable;
    use Behavior\SoftDeletable\SoftDeletable;

    use Accessor\Id;
    use Accessor\Uuid;
    use Accessor\Owner;
    use Accessor\OwnerUuid;
    use Accessor\Identity;
    use Accessor\IdentityUuid;
    use EntityAccessor\Registration;
    use Accessor\Deleted;
    use Accessor\Version;
    use TenantAccessor\Tenant;

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
    private $uuid;

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
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"user_output"})
     */
    protected $deletedAt;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"user_output", "user_input"})
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
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
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     * @Assert\Regex("/^.+@.+$/")
     */
    protected $email;

    /**
     * @var boolean
     * @ApiProperty
     * @Serializer\Groups({"user_output", "user_input"})
     * @Assert\Type("boolean")
     */
    protected $enabled;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"user_output"})
     */
    protected $lastLogin; # region accessors

    /**
     * {@inheritdoc}
     */
    public function setLastLogin(DateTime $time = null)
    {
        // Disable last login by always setting it to null. This avoids a version bump due to login in.
        $this->lastLogin = null;

        return $this;
    }

    # endregion

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
     * @Assert\Type("array")
     * @Assert\All({
     *     @Assert\NotBlank,
     *     @Assert\Length(min=1)
     * })
     */
    protected $roles;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"user_output", "user_input"})
     * @ORM\Column(name="`owner`", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    private $owner;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"user_output", "user_input"})
     * @ORM\Column(name="owner_uuid", type="guid", nullable=true)
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    private $ownerUuid;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"user_output", "user_input"})
     * @ORM\Column(name="identity", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    private $identity;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"user_output", "user_input"})
     * @ORM\Column(name="identity_uuid", type="guid", nullable=true)
     * @Assert\Uuid
     */
    private $identityUuid;

    /**
     * @var \App\Entity\Registration
     * @ORM\OneToOne(targetEntity="Registration", mappedBy="user")
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     */
    private $registration;

    /**
     * @var integer
     * @ApiProperty
     * @Serializer\Groups({"user_output", "user_input"})
     * @ORM\Column(name="version", type="integer")
     * @ORM\Version
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $version;

    /**
     * @var string
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"user_output"})
     * @ORM\Column(name="tenant", type="guid")
     * @Assert\Uuid
     */
    private $tenant;

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
