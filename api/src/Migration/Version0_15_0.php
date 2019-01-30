<?php

namespace App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Migrations\Version;
use Ds\Component\Acl\Migration\Version0_15_0 as Acl;
use Ds\Component\Config\Migration\Version0_15_0 as Config;
use Ds\Component\Container\Attribute;
use Ds\Component\Database\Util\Objects;
use Ds\Component\Database\Util\Parameters;
use Ds\Component\Metadata\Migration\Version0_15_0 as Metadata;
use Ds\Component\Parameter\Migration\Version0_15_0 as Parameter;
use Ds\Component\Tenant\Migration\Version0_15_0 as Tenant;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Class Version0_15_0
 */
final class Version0_15_0 extends AbstractMigration implements ContainerAwareInterface
{
    use Attribute\Container;

    /**
     * @cont string
     */
    const DIRECTORY = '/srv/api/config/migrations';

    /**
     * @var \Ds\Component\Acl\Migration\Version0_15_0
     */
    private $acl;

    /**
     * @var \Ds\Component\Config\Migration\Version0_15_0
     */
    private $config;

    /**
     * @var \Ds\Component\Metadata\Migration\Version0_15_0
     */
    private $metadata;

    /**
     * @var \Ds\Component\Parameter\Migration\Version0_15_0
     */
    private $parameter;

    /**
     * @var \Ds\Component\Tenant\Migration\Version0_15_0
     */
    private $tenant;

    /**
     * Constructor
     *
     * @param \Doctrine\DBAL\Migrations\Version  $version
     */
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->acl = new Acl($version);
        $this->config = new Config($version);
        $this->metadata = new Metadata($version);
        $this->parameter = new Parameter($version);
        $this->tenant = new Tenant($version);
    }

    /**
     * Up migration
     *
     * @param \Doctrine\DBAL\Schema\Schema $schema
     */
    public function up(Schema $schema)
    {
        $parameters = Parameters::parseFile(static::DIRECTORY.'/parameters.yaml');
        $this->acl->up($schema, Objects::parseFile(static::DIRECTORY.'/0_15_0/acl.yaml', $parameters));
        $this->config->setContainer($this->container)->up($schema, Objects::parseFile(static::DIRECTORY.'/0_15_0/config.yaml', $parameters));
        $this->metadata->up($schema, Objects::parseFile(static::DIRECTORY.'/0_15_0/metadata.yaml', $parameters));
        $this->parameter->setContainer($this->container)->up($schema, Objects::parseFile(static::DIRECTORY.'/0_15_0/system/parameter.yaml', $parameters));
        $this->tenant->up($schema, Objects::parseFile(static::DIRECTORY.'/0_15_0/system/tenant.yaml', $parameters));

        $users = Objects::parseFile(static::DIRECTORY.'/0_15_0/user.yaml', $parameters);

        $sequences['app_registration_id_seq'] = 1;
        $sequences['app_user_id_seq'] = 1 + count($users);

        switch ($this->platform->getName()) {
            case 'postgresql':
                $this->addSql('CREATE SEQUENCE app_registration_id_seq INCREMENT BY 1 MINVALUE 1 START '.$sequences['app_registration_id_seq']);
                $this->addSql('CREATE SEQUENCE app_user_id_seq INCREMENT BY 1 MINVALUE 1 START '.$sequences['app_user_id_seq']);
                $this->addSql('CREATE TABLE app_registration (id INT NOT NULL, user_id INT DEFAULT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, username VARCHAR(255) NOT NULL, identity VARCHAR(255) DEFAULT NULL, data JSON NOT NULL, version INT DEFAULT 1 NOT NULL, tenant UUID NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_A026BD26D17F50A6 ON app_registration (uuid)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_A026BD26A76ED395 ON app_registration (user_id)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_A026BD26F85E06774E59C462 ON app_registration (username, tenant)');
                $this->addSql('COMMENT ON COLUMN app_registration.data IS \'(DC2Type:json_array)\'');
                $this->addSql('CREATE TABLE app_user (id INT NOT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, roles TEXT NOT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, identity VARCHAR(255) DEFAULT NULL, identity_uuid UUID DEFAULT NULL, version INT DEFAULT 1 NOT NULL, tenant UUID NOT NULL, username_canonical VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9C05FB297 ON app_user (confirmation_token)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9D17F50A6 ON app_user (uuid)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9F85E06774E59C462 ON app_user (username, tenant)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E992FC23A84E59C462 ON app_user (username_canonical, tenant)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9E7927C744E59C462 ON app_user (email, tenant)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9A0D96FBF4E59C462 ON app_user (email_canonical, tenant)');
                $this->addSql('COMMENT ON COLUMN app_user.roles IS \'(DC2Type:array)\'');
                $this->addSql('ALTER TABLE app_registration ADD CONSTRAINT FK_A026BD26A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

                $i = 0;

                foreach ($users as $user) {
                    $this->addSql(sprintf(
                        'INSERT INTO app_user (id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles, uuid, owner, owner_uuid, identity, identity_uuid, version, tenant, created_at, updated_at, deleted_at) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %d, %s, %s, %s, %s);',
                        ++$i,
                        $this->connection->quote($user->username),
                        $this->connection->quote($user->username),
                        $this->connection->quote($user->username),
                        $this->connection->quote($user->username),
                        $user->enabled ? 'true' : 'false',
                        'NULL',
                        $this->connection->quote(password_hash($user->password, PASSWORD_BCRYPT)),
                        'NULL',
                        'NULL',
                        'NULL',
                        $this->connection->quote(serialize($user->roles)),
                        $this->connection->quote($user->uuid),
                        $this->connection->quote($user->owner),
                        $this->connection->quote($user->owner_uuid),
                        $this->connection->quote($user->identity),
                        null === $user->identity_uuid ? 'NULL' : $this->connection->quote($user->identity_uuid),
                        $user->version,
                        $this->connection->quote($user->tenant),
                        'now()',
                        'now()',
                        'NULL'
                    ));
                }

                break;

            default:
                $this->abortIf(true,'Migration cannot be executed on "'.$this->platform->getName().'".');
                break;
        }
    }

    /**
     * Down migration
     *
     * @param \Doctrine\DBAL\Schema\Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->acl->down($schema);
        $this->config->setContainer($this->container)->down($schema);
        $this->metadata->down($schema);
        $this->parameter->setContainer($this->container)->down($schema);
        $this->tenant->down($schema);

        switch ($this->platform->getName()) {
            case 'postgresql':
                $this->addSql('ALTER TABLE app_registration DROP CONSTRAINT FK_A026BD26A76ED395');
                $this->addSql('DROP SEQUENCE app_registration_id_seq CASCADE');
                $this->addSql('DROP SEQUENCE app_user_id_seq CASCADE');
                $this->addSql('DROP TABLE app_registration');
                $this->addSql('DROP TABLE app_user');
                break;

            default:
                $this->abortIf(true,'Migration cannot be executed on "'.$this->platform->getName().'".');
                break;
        }
    }
}
