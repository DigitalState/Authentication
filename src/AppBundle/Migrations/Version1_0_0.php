<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Ds\Component\Container\Attribute;
use Ramsey\Uuid\Uuid;
use stdClass;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Version1_0_0
 */
class Version1_0_0 extends AbstractMigration implements ContainerAwareInterface
{
    use Attribute\Container;

    /**
     * Up
     *
     * @param \Doctrine\DBAL\Schema\Schema $schema
     */
    public function up(Schema $schema)
    {
        $platform = $this->connection->getDatabasePlatform()->getName();
        $cipherService = $this->container->get('ds_encryption.service.cipher');

        switch ($platform) {
            case 'postgresql':
                // Schema
                $this->addSql('CREATE SEQUENCE ds_config_id_seq INCREMENT BY 1 MINVALUE 1 START 37');
                $this->addSql('CREATE SEQUENCE ds_parameter_id_seq INCREMENT BY 1 MINVALUE 1 START 4');
                $this->addSql('CREATE SEQUENCE ds_metadata_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
                $this->addSql('CREATE SEQUENCE ds_metadata_trans_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
                $this->addSql('CREATE SEQUENCE ds_access_id_seq INCREMENT BY 1 MINVALUE 1 START 3');
                $this->addSql('CREATE SEQUENCE ds_access_permission_id_seq INCREMENT BY 1 MINVALUE 1 START 7');
                $this->addSql('CREATE SEQUENCE ds_tenant_id_seq INCREMENT BY 1 MINVALUE 1 START 2');
                $this->addSql('CREATE SEQUENCE app_user_oauth_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
                $this->addSql('CREATE SEQUENCE app_registration_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
                $this->addSql('CREATE SEQUENCE app_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
                $this->addSql('CREATE TABLE ds_config (id INT NOT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, "key" VARCHAR(255) NOT NULL, value TEXT DEFAULT NULL, version INT DEFAULT 1 NOT NULL, tenant UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_758C45F4D17F50A6 ON ds_config (uuid)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_758C45F48A90ABA94E59C462 ON ds_config (key, tenant)');
                $this->addSql('CREATE TABLE ds_parameter (id INT NOT NULL, "key" VARCHAR(255) NOT NULL, value TEXT DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_B3C0FD91F48571EB ON ds_parameter ("key")');
                $this->addSql('CREATE TABLE ds_metadata (id INT NOT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, slug VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, data JSON NOT NULL, version INT DEFAULT 1 NOT NULL, tenant UUID NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_11290F17D17F50A6 ON ds_metadata (uuid)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_11290F17989D9B624E59C462 ON ds_metadata (slug, tenant)');
                $this->addSql('CREATE TABLE ds_metadata_trans (id INT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE INDEX IDX_A6447E202C2AC5D3 ON ds_metadata_trans (translatable_id)');
                $this->addSql('CREATE UNIQUE INDEX ds_metadata_trans_unique_translation ON ds_metadata_trans (translatable_id, locale)');
                $this->addSql('CREATE TABLE ds_access (id INT NOT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, assignee VARCHAR(255) DEFAULT NULL, assignee_uuid UUID DEFAULT NULL, version INT DEFAULT 1 NOT NULL, tenant UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_A76F41DCD17F50A6 ON ds_access (uuid)');
                $this->addSql('CREATE TABLE ds_access_permission (id INT NOT NULL, access_id INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, entity VARCHAR(255) DEFAULT NULL, entity_uuid UUID DEFAULT NULL, "key" VARCHAR(255) NOT NULL, attributes JSON NOT NULL, tenant UUID NOT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE INDEX IDX_D46DD4D04FEA67CF ON ds_access_permission (access_id)');
                $this->addSql('CREATE TABLE ds_tenant (id INT NOT NULL, uuid UUID NOT NULL, data JSON NOT NULL, version INT DEFAULT 1 NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_EF5FAEEAD17F50A6 ON ds_tenant (uuid)');
                $this->addSql('CREATE TABLE app_user_oauth (id INT NOT NULL, user_id INT DEFAULT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, type VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, version INT DEFAULT 1 NOT NULL, tenant UUID NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_B00328E0D17F50A6 ON app_user_oauth (uuid)');
                $this->addSql('CREATE INDEX IDX_B00328E0A76ED395 ON app_user_oauth (user_id)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_B00328E08CDE5729772E836A4E59C462 ON app_user_oauth (type, identifier, tenant)');
                $this->addSql('CREATE TABLE app_user (id INT NOT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, roles TEXT NOT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, identity VARCHAR(255) DEFAULT NULL, identity_uuid UUID DEFAULT NULL, version INT DEFAULT 1 NOT NULL, tenant UUID NOT NULL, username_canonical VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9C05FB297 ON app_user (confirmation_token)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9D17F50A6 ON app_user (uuid)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9F85E06774E59C462 ON app_user (username, tenant)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E992FC23A84E59C462 ON app_user (username_canonical, tenant)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9E7927C744E59C462 ON app_user (email, tenant)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9A0D96FBF4E59C462 ON app_user (email_canonical, tenant)');
                $this->addSql('COMMENT ON COLUMN app_user.roles IS \'(DC2Type:array)\'');
                $this->addSql('CREATE TABLE app_registration (id INT NOT NULL, user_id INT DEFAULT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, username VARCHAR(255) NOT NULL, identity VARCHAR(255) DEFAULT NULL, data JSON NOT NULL, version INT DEFAULT 1 NOT NULL, tenant UUID NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_A026BD26D17F50A6 ON app_registration (uuid)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_A026BD26A76ED395 ON app_registration (user_id)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_A026BD26F85E06774E59C462 ON app_registration (username, tenant)');
                $this->addSql('ALTER TABLE ds_metadata_trans ADD CONSTRAINT FK_A6447E202C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES ds_metadata (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
                $this->addSql('ALTER TABLE ds_access_permission ADD CONSTRAINT FK_D46DD4D04FEA67CF FOREIGN KEY (access_id) REFERENCES ds_access (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
                $this->addSql('ALTER TABLE app_user_oauth ADD CONSTRAINT FK_B00328E0A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
                $this->addSql('ALTER TABLE app_registration ADD CONSTRAINT FK_A026BD26A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
                $this->addSql('CREATE TABLE ds_session (id VARCHAR(128) NOT NULL PRIMARY KEY, data BYTEA NOT NULL, time INTEGER NOT NULL, lifetime INTEGER NOT NULL)');

                // Data
                $yml = file_get_contents('/srv/api-platform/src/AppBundle/Resources/migrations/1_0_0.yml');
                $data = Yaml::parse($yml);
                $i = 0;
                $parameters = [
                    [
                        'key' => 'ds_system.user.username',
                        'value' => serialize($data['system']['username'])
                    ],
                    [
                        'key' => 'ds_system.user.password',
                        'value' => $cipherService->encrypt($data['system']['password'])
                    ],
                    [
                        'key' => 'ds_tenant.tenant.default',
                        'value' => serialize($data['tenant']['uuid'])
                    ]
                ];

                foreach ($parameters as $parameter) {
                    $this->addSql(sprintf(
                        'INSERT INTO ds_parameter (id, key, value) VALUES (%d, %s, %s);',
                        ++$i,
                        $this->connection->quote($parameter['key']),
                        $this->connection->quote($parameter['value'])
                    ));
                }

                $i = 0;
                $tenants = [
                    [
                        'uuid' => $data['tenant']['uuid'],
                        'data' => '"'.$cipherService->encrypt(new stdClass).'"'
                    ]
                ];

                foreach ($tenants as $tenant) {
                    $this->addSql(sprintf(
                        'INSERT INTO ds_tenant (id, uuid, data, created_at, updated_at) VALUES (%d, %s, %s, %s, %s);',
                        ++$i,
                        $this->connection->quote($tenant['uuid']),
                        $this->connection->quote($tenant['data']),
                        'now()',
                        'now()'
                    ));
                }

                $i = 0;
                $configs = [
                    [
                        'key' => 'ds_api.user.username',
                        'value' => serialize($data['user']['system']['username'])
                    ],
                    [
                        'key' => 'ds_api.user.password',
                        'value' => $cipherService->encrypt($data['user']['system']['password'])
                    ],
                    [
                        'key' => 'ds_api.user.uuid',
                        'value' => serialize($data['user']['system']['uuid'])
                    ],
                    [
                        'key' => 'ds_api.user.roles',
                        'value' => serialize([])
                    ],
                    [
                        'key' => 'ds_api.user.identity.roles',
                        'value' => serialize([])
                    ],
                    [
                        'key' => 'ds_api.user.identity.type',
                        'value' => serialize('System')
                    ],
                    [
                        'key' => 'ds_api.user.identity.uuid',
                        'value' => serialize($data['identity']['system']['uuid'])
                    ],
                    [
                        'key' => 'ds_api.user.tenant',
                        'value' => serialize($data['tenant']['uuid'])
                    ],
                    [
                        'key' => 'app.spa.admin',
                        'value' => serialize($data['config']['app.spa.admin']['value'])
                    ],
                    [
                        'key' => 'app.spa.admin.oauth',
                        'value' => serialize($data['config']['app.spa.admin.oauth']['value'])
                    ],
                    [
                        'key' => 'app.spa.portal',
                        'value' => serialize($data['config']['app.spa.portal']['value'])
                    ],
                    [
                        'key' => 'app.spa.portal.oauth',
                        'value' => serialize($data['config']['app.spa.portal.oauth']['value'])
                    ],
                    [
                        'key' => 'app.registration.individual.owner.type',
                        'value' => serialize('BusinessUnit')
                    ],
                    [
                        'key' => 'app.registration.individual.owner.uuid',
                        'value' => serialize($data['business_unit']['administration']['uuid'])
                    ],
                    [
                        'key' => 'app.registration.individual.data.github',
                        'value' => serialize(new stdClass)
                    ],
                    [
                        'key' => 'app.registration.individual.data.google',
                        'value' => serialize(new stdClass)
                    ],
                    [
                        'key' => 'app.registration.individual.data.twitter',
                        'value' => serialize(new stdClass)
                    ],
                    [
                        'key' => 'app.registration.individual.roles',
                        'value' => serialize([])
                    ],
                    [
                        'key' => 'app.registration.individual.enabled',
                        'value' => serialize(true)
                    ],
                    [
                        'key' => 'app.registration.organization.owner.type',
                        'value' => serialize('BusinessUnit')
                    ],
                    [
                        'key' => 'app.registration.organization.owner.uuid',
                        'value' => serialize($data['business_unit']['administration']['uuid'])
                    ],
                    [
                        'key' => 'app.registration.organization.data.github',
                        'value' => serialize(new stdClass)
                    ],
                    [
                        'key' => 'app.registration.organization.data.google',
                        'value' => serialize(new stdClass)
                    ],
                    [
                        'key' => 'app.registration.organization.data.twitter',
                        'value' => serialize(new stdClass)
                    ],
                    [
                        'key' => 'app.registration.organization.roles',
                        'value' => serialize([])
                    ],
                    [
                        'key' => 'app.registration.organization.enabled',
                        'value' => serialize(true)
                    ],
                    [
                        'key' => 'app.registration.staff.owner.type',
                        'value' => serialize('BusinessUnit')
                    ],
                    [
                        'key' => 'app.registration.staff.owner.uuid',
                        'value' => serialize($data['business_unit']['administration']['uuid'])
                    ],
                    [
                        'key' => 'app.registration.staff.data.github',
                        'value' => serialize(new stdClass)
                    ],
                    [
                        'key' => 'app.registration.staff.data.google',
                        'value' => serialize(new stdClass)
                    ],
                    [
                        'key' => 'app.registration.staff.data.twitter',
                        'value' => serialize(new stdClass)
                    ],
                    [
                        'key' => 'app.registration.staff.roles',
                        'value' => serialize([])
                    ],
                    [
                        'key' => 'app.registration.staff.enabled',
                        'value' => serialize(false)
                    ],
                    [
                        'key' => 'app.resetting.email.subject',
                        'value' => serialize('app.resetting.email.subject')
                    ],
                    [
                        'key' => 'app.resetting.email.body.plain',
                        'value' => serialize('app.resetting.email.body.plain')
                    ],
                    [
                        'key' => 'app.resetting.email.body.html',
                        'value' => serialize('app.resetting.email.body.html')
                    ]
                ];

                foreach ($configs as $config) {
                    $this->addSql(sprintf(
                        'INSERT INTO ds_config (id, uuid, owner, owner_uuid, key, value, version, tenant, created_at, updated_at) VALUES (%d, %s, %s, %s, %s, %s, %d, %s, %s, %s);',
                        ++$i,
                        $this->connection->quote(Uuid::uuid4()->toString()),
                        $this->connection->quote('BusinessUnit'),
                        $this->connection->quote($data['business_unit']['administration']['uuid']),
                        $this->connection->quote($config['key']),
                        $this->connection->quote($config['value']),
                        1,
                        $this->connection->quote($data['tenant']['uuid']),
                        'now()',
                        'now()'
                    ));
                }

                $i = 0;
                $j = 0;
                $accesses = [
                    [
                        'owner' => 'System',
                        'owner_uuid' => $data['identity']['system']['uuid'],
                        'assignee' => 'System',
                        'assignee_uuid' => $data['identity']['system']['uuid'],
                        'permissions' => [
                            [
                                'key' => 'entity',
                                'attributes' => '["BROWSE","READ","EDIT","ADD","DELETE"]'
                            ],
                            [
                                'key' => 'property',
                                'attributes' => '["BROWSE","READ","EDIT"]'
                            ],
                            [
                                'key' => 'generic',
                                'attributes' => '["BROWSE","READ","EDIT","ADD","DELETE","EXECUTE"]'
                            ]
                        ]
                    ],
                    [
                        'owner' => 'BusinessUnit',
                        'owner_uuid' => $data['business_unit']['administration']['uuid'],
                        'assignee' => 'Staff',
                        'assignee_uuid' => $data['identity']['admin']['uuid'],
                        'permissions' => [
                            [
                                'key' => 'entity',
                                'attributes' => '["BROWSE","READ","EDIT","ADD","DELETE"]'
                            ],
                            [
                                'key' => 'property',
                                'attributes' => '["BROWSE","READ","EDIT"]'
                            ],
                            [
                                'key' => 'generic',
                                'attributes' => '["BROWSE","READ","EDIT","ADD","DELETE","EXECUTE"]'
                            ]
                        ]
                    ]
                ];

                foreach ($accesses as $access) {
                    $this->addSql(sprintf(
                        'INSERT INTO ds_access (id, uuid, owner, owner_uuid, assignee, assignee_uuid, version, tenant, created_at, updated_at) VALUES (%d, %s, %s, %s, %s, %s, %d, %s, %s, %s);',
                        ++$i,
                        $this->connection->quote(Uuid::uuid4()->toString()),
                        $this->connection->quote($access['owner']),
                        $this->connection->quote($access['owner_uuid']),
                        $this->connection->quote($access['assignee']),
                        $this->connection->quote($access['assignee_uuid']),
                        1,
                        $this->connection->quote($data['tenant']['uuid']),
                        'now()',
                        'now()'
                    ));

                    foreach ($access['permissions'] as $permission) {
                        $this->addSql(sprintf(
                            'INSERT INTO ds_access_permission (id, access_id, scope, entity, entity_uuid, key, attributes, tenant) VALUES (%d, %d, %s, %s, %s, %s, %s, %s);',
                            ++$j,
                            $i,
                            $this->connection->quote('generic'),
                            'NULL',
                            'NULL',
                            $this->connection->quote($permission['key']),
                            $this->connection->quote($permission['attributes']),
                            $this->connection->quote($data['tenant']['uuid'])
                        ));
                    }
                }

                $i = 0;
                $users = [
                    [
                        'username' => 'system@system.ds',
                        'password' => password_hash($data['user']['system']['password'], PASSWORD_BCRYPT),
                        'uuid' => $data['user']['system']['uuid'],
                        'owner' => 'System',
                        'owner_uuid' => $data['identity']['system']['uuid'],
                        'identity' => 'System',
                        'identity_uuid' => $data['identity']['system']['uuid']
                    ],
                    [
                        'username' => 'anonymous@anonymous.ds',
                        'password' => password_hash($data['user']['anonymous']['password'], PASSWORD_BCRYPT),
                        'uuid' => $data['user']['anonymous']['uuid'],
                        'owner' => 'BusinessUnit',
                        'owner_uuid' => $data['business_unit']['administration']['uuid'],
                        'identity' => 'Anonymous',
                        'identity_uuid' => null
                    ],
                    [
                        'username' => 'admin@staff.ds',
                        'password' => password_hash($data['user']['admin']['password'], PASSWORD_BCRYPT),
                        'uuid' => $data['user']['admin']['uuid'],
                        'owner' => 'BusinessUnit',
                        'owner_uuid' => $data['business_unit']['administration']['uuid'],
                        'identity' => 'Staff',
                        'identity_uuid' => $data['identity']['admin']['uuid']
                    ]
                ];

                foreach ($users as $user) {
                    $this->addSql(sprintf(
                        'INSERT INTO app_user (id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles, uuid, owner, owner_uuid, identity, identity_uuid, version, tenant, created_at, updated_at, deleted_at) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %d, %s, %s, %s, %s);',
                        ++$i,
                        $this->connection->quote($user['username']),
                        $this->connection->quote($user['username']),
                        $this->connection->quote($user['username']),
                        $this->connection->quote($user['username']),
                        'true',
                        'NULL',
                        $this->connection->quote($user['password']),
                        'NULL',
                        'NULL',
                        'NULL',
                        $this->connection->quote('a:1:{i:0;s:0:"";}'),
                        $this->connection->quote($user['uuid']),
                        $this->connection->quote($user['owner']),
                        $this->connection->quote($user['owner_uuid']),
                        $this->connection->quote($user['identity']),
                        null === $user['identity_uuid'] ? 'NULL' : $this->connection->quote($user['identity_uuid']),
                        1,
                        $this->connection->quote($data['tenant']['uuid']),
                        'now()',
                        'now()',
                        'NULL'
                    ));
                }

                break;

            default:
                $this->abortIf(true,'Migration cannot be executed on "'.$platform.'".');
                break;
        }
    }

    /**
     * Down
     *
     * @param \Doctrine\DBAL\Schema\Schema $schema
     */
    public function down(Schema $schema)
    {
        $platform = $this->connection->getDatabasePlatform()->getName();

        switch ($platform) {
            case 'postgresql':
                // Schema
                $this->addSql('ALTER TABLE ds_metadata_trans DROP CONSTRAINT FK_A6447E202C2AC5D3');
                $this->addSql('ALTER TABLE ds_access_permission DROP CONSTRAINT FK_D46DD4D04FEA67CF');
                $this->addSql('ALTER TABLE app_user_oauth DROP CONSTRAINT FK_B00328E0A76ED395');
                $this->addSql('ALTER TABLE app_registration DROP CONSTRAINT FK_A026BD26A76ED395');
                $this->addSql('DROP SEQUENCE ds_config_id_seq CASCADE');
                $this->addSql('DROP SEQUENCE ds_parameter_id_seq CASCADE');
                $this->addSql('DROP SEQUENCE ds_metadata_id_seq CASCADE');
                $this->addSql('DROP SEQUENCE ds_metadata_trans_id_seq CASCADE');
                $this->addSql('DROP SEQUENCE ds_access_id_seq CASCADE');
                $this->addSql('DROP SEQUENCE ds_access_permission_id_seq CASCADE');
                $this->addSql('DROP SEQUENCE ds_tenant_id_seq CASCADE');
                $this->addSql('DROP SEQUENCE app_user_oauth_id_seq CASCADE');
                $this->addSql('DROP SEQUENCE app_registration_id_seq CASCADE');
                $this->addSql('DROP SEQUENCE app_user_id_seq CASCADE');
                $this->addSql('DROP TABLE ds_config');
                $this->addSql('DROP TABLE ds_parameter');
                $this->addSql('DROP TABLE ds_metadata');
                $this->addSql('DROP TABLE ds_metadata_trans');
                $this->addSql('DROP TABLE ds_access');
                $this->addSql('DROP TABLE ds_access_permission');
                $this->addSql('DROP TABLE ds_tenant');
                $this->addSql('DROP TABLE app_user_oauth');
                $this->addSql('DROP TABLE app_registration');
                $this->addSql('DROP TABLE app_user');
                $this->addSql('DROP TABLE ds_session');
                break;

            default:
                $this->abortIf(true,'Migration cannot be executed on "'.$platform.'".');
                break;
        }
    }
}
