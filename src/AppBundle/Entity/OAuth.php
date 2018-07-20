<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Attribute\Accessor as EntityAccessor;
use Ds\Component\Model\Type\Deletable;
use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Versionable;
use Ds\Component\Model\Attribute\Accessor;
use Ds\Component\Security\Model\Type\Secured;
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
 *     shortName="Oauth",
 *     attributes={
 *         "normalization_context"={
 *             "groups"={"oauth_output"}
 *         },
 *         "denormalization_context"={
 *             "groups"={"oauth_input"}
 *         },
 *         "filters"={
 *             "app.oauth.search",
 *             "app.oauth.date",
 *             "app.oauth.boolean",
 *             "app.oauth.order"
 *         }
 *     }
 * )
 * @ORM\Entity
 * @ORM\Table(
 *     name="app_user_oauth",
 *     uniqueConstraints={
 *        @ORM\UniqueConstraint(columns={"type", "identifier", "tenant"})
 *     }
 * )
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 * @ORMAssert\UniqueEntity(fields="uuid")
 * @ORMAssert\UniqueEntity(fields={"type", "identifier", "tenant"})
 */
class OAuth implements Identifiable, Uuidentifiable, Ownable, Deletable, Versionable, Tenantable, Secured
{
    use Behavior\Timestampable\Timestampable;
    use Behavior\SoftDeletable\SoftDeletable;

    use Accessor\Id;
    use Accessor\Uuid;
    use Accessor\Owner;
    use Accessor\OwnerUuid;
    use EntityAccessor\User;
    use Accessor\Type;
    use Accessor\Identifier;
    use Accessor\Token;
    use Accessor\Deleted;
    use Accessor\Version;
    use TenantAccessor\Tenant;

    /**
     * @var integer
     * @ApiProperty(identifier=false, writable=false)
     * @Serializer\Groups({"oauth_output"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ApiProperty(identifier=true, writable=false)
     * @Serializer\Groups({"oauth_output"})
     * @ORM\Column(name="uuid", type="guid", unique=true)
     * @Assert\Uuid
     */
    protected $uuid;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"oauth_output"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"oauth_output"})
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"oauth_output"})
     */
    protected $deletedAt;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"user_output", "user_input"})
     * @ORM\Column(name="`owner`", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    protected $owner;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"user_output", "user_input"})
     * @ORM\Column(name="owner_uuid", type="guid", nullable=true)
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    protected $ownerUuid;

    /**
     * @var \AppBundle\Entity\User
     * @Serializer\Groups({"oauth_output", "oauth_input"})
     * @ORM\ManyToOne(targetEntity="User", inversedBy="oauths")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @Assert\Valid
     */
    protected $user;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"oauth_output", "oauth_input"})
     * @ORM\Column(name="type", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    protected $type;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"oauth_output", "oauth_input"})
     * @ORM\Column(name="identifier", type="string", length=255)
     * @Assert\Length(min=1, max=255)
     */
    protected $identifier;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"oauth_output", "oauth_input"})
     * @ORM\Column(name="token", type="string", length=255)
     * @Assert\Length(min=1, max=255)
     */
    protected $token;

    /**
     * @var integer
     * @ApiProperty
     * @Serializer\Groups({"oauth_output", "oauth_input"})
     * @ORM\Column(name="version", type="integer")
     * @ORM\Version
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    protected $version;

    /**
     * @var string
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"oauth_output"})
     * @ORM\Column(name="tenant", type="guid")
     * @Assert\Uuid
     */
    protected $tenant;
}
