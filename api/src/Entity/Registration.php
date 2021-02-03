<?php

namespace App\Entity;

use App\Entity\Attribute\Accessor as EntityAccessor;
use Ds\Component\Model\Type\Deletable;
use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Versionable;
use Ds\Component\Model\Attribute\Accessor;
use Ds\Component\Tenant\Model\Attribute\Accessor as TenantAccessor;
use Ds\Component\Tenant\Model\Type\Tenantable;
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
 *             "groups"={"registration_output"}
 *         },
 *         "denormalization_context"={
 *             "groups"={"registration_input"}
 *         },
 *         "filters"={
 *             "app.registration.search",
 *             "app.registration.date",
 *             "app.registration.order"
 *         }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\RegistrationRepository")
 * @ORM\Table(
 *     name="app_registration",
 *     uniqueConstraints={
 *        @ORM\UniqueConstraint(columns={"username", "tenant"})
 *     }
 * )
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 * @ORMAssert\UniqueEntity(fields="uuid")
 * @ORMAssert\UniqueEntity(fields={"username", "tenant"})
 */
class Registration implements Identifiable, Uuidentifiable, Ownable, Deletable, Versionable, Tenantable
{
    use Behavior\Timestampable\Timestampable;
    use Behavior\SoftDeletable\SoftDeletable;

    use Accessor\Id;
    use Accessor\Uuid;
    use Accessor\Owner;
    use Accessor\OwnerUuid;
    use Accessor\Username;
    use Accessor\Password;
    use Accessor\Identity;
    use Accessor\Data;
    use EntityAccessor\User;
    use Accessor\Deleted;
    use Accessor\Version;
    use TenantAccessor\Tenant;

    /**
     * @var integer
     * @ApiProperty(identifier=false, writable=false)
     * @Serializer\Groups({"registration_output"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     * @ApiProperty(identifier=true, writable=false)
     * @Serializer\Groups({"registration_output"})
     * @ORM\Column(name="uuid", type="guid", unique=true)
     * @Assert\Uuid
     */
    private $uuid;

    /**
     * @var \DateTime
     * @ApiProperty
     * @Serializer\Groups({"registration_output", "registration_input"})
     * @Assert\DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"registration_output"})
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"registration_output"})
     */
    protected $deletedAt;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"registration_output", "registration_input"})
     * @ORM\Column(name="`owner`", type="string", length=255, nullable=true)
     * @Assert\Length(min=1, max=255)
     */
    private $owner;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"registration_output", "registration_input"})
     * @ORM\Column(name="owner_uuid", type="guid", nullable=true)
     * @Assert\Uuid
     */
    private $ownerUuid;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"registration_output", "registration_input"})
     * @ORM\Column(name="username", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    private $username;

    /**
     * @var string
     * @ApiProperty(readable=false)
     * @Serializer\Groups({"registration_input"})
     */
    private $password;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"registration_output", "registration_input"})
     * @ORM\Column(name="identity", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    private $identity;

    /**
     * @var array
     * @ApiProperty
     * @Serializer\Groups({"registration_output", "registration_input"})
     * @ORM\Column(name="data", type="json_array")
     * @Assert\Type("array")
     */
    private $data;

    /**
     * @var \App\Entity\User
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"registration_output"})
     * @ORM\OneToOne(targetEntity="User", inversedBy="registration")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     */
    private $user;

    /**
     * @var integer
     * @ApiProperty
     * @Serializer\Groups({"registration_output", "registration_input"})
     * @ORM\Column(name="version", type="integer")
     * @ORM\Version
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $version;

    /**
     * @var string
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"registration_output"})
     * @ORM\Column(name="tenant", type="guid")
     * @Assert\Uuid
     */
    private $tenant;
}
