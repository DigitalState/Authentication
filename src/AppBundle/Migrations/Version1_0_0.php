<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Version1_0_0
 */
class Version1_0_0 extends AbstractMigration
{
    /**
     * Up
     *
     * @param \Doctrine\DBAL\Schema\Schema $schema
     */
    public function up(Schema $schema)
    {
        $platform = $this->connection->getDatabasePlatform()->getName();

        switch ($platform) {
            case 'postgresql':
                // Entity schema
                $this->addSql('CREATE SEQUENCE ds_config_id_seq INCREMENT BY 1 MINVALUE 1 START 29');
                $this->addSql('CREATE SEQUENCE ds_parameter_id_seq INCREMENT BY 1 MINVALUE 1 START 4');
                $this->addSql('CREATE SEQUENCE ds_metadata_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
                $this->addSql('CREATE SEQUENCE ds_metadata_trans_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
                $this->addSql('CREATE SEQUENCE ds_access_id_seq INCREMENT BY 1 MINVALUE 1 START 3');
                $this->addSql('CREATE SEQUENCE ds_access_permission_id_seq INCREMENT BY 1 MINVALUE 1 START 7');
                $this->addSql('CREATE SEQUENCE ds_tenant_id_seq INCREMENT BY 1 MINVALUE 1 START 2');
                $this->addSql('CREATE SEQUENCE app_user_oauth_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
                $this->addSql('CREATE SEQUENCE app_registration_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
                $this->addSql('CREATE SEQUENCE app_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
                $this->addSql('CREATE TABLE ds_config (id INT NOT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, "key" VARCHAR(255) NOT NULL, value JSON DEFAULT NULL, enabled BOOLEAN NOT NULL, version INT DEFAULT 1 NOT NULL, tenant UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_758C45F4D17F50A6 ON ds_config (uuid)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_758C45F48A90ABA94E59C462 ON ds_config (key, tenant)');
                $this->addSql('CREATE TABLE ds_parameter (id INT NOT NULL, "key" VARCHAR(255) NOT NULL, value JSON DEFAULT NULL, enabled BOOLEAN NOT NULL, PRIMARY KEY(id))');
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
                $this->addSql('CREATE TABLE app_registration (id INT NOT NULL, user_id INT DEFAULT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, username VARCHAR(255) NOT NULL, identity VARCHAR(255) DEFAULT NULL, data JSON NOT NULL, version INT DEFAULT 1 NOT NULL, tenant UUID NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_A026BD26D17F50A6 ON app_registration (uuid)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_A026BD26A76ED395 ON app_registration (user_id)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_A026BD26F85E06774E59C462 ON app_registration (username, tenant)');
                $this->addSql('CREATE TABLE app_user (id INT NOT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, roles TEXT NOT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, identity VARCHAR(255) DEFAULT NULL, identity_uuid UUID DEFAULT NULL, version INT DEFAULT 1 NOT NULL, tenant UUID NOT NULL, username_canonical VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9C05FB297 ON app_user (confirmation_token)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9D17F50A6 ON app_user (uuid)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9F85E06774E59C462 ON app_user (username, tenant)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E992FC23A84E59C462 ON app_user (username_canonical, tenant)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9E7927C744E59C462 ON app_user (email, tenant)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9A0D96FBF4E59C462 ON app_user (email_canonical, tenant)');
                $this->addSql('COMMENT ON COLUMN app_user.roles IS \'(DC2Type:array)\'');
                $this->addSql('ALTER TABLE ds_metadata_trans ADD CONSTRAINT FK_A6447E202C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES ds_metadata (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
                $this->addSql('ALTER TABLE ds_access_permission ADD CONSTRAINT FK_D46DD4D04FEA67CF FOREIGN KEY (access_id) REFERENCES ds_access (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
                $this->addSql('ALTER TABLE app_user_oauth ADD CONSTRAINT FK_B00328E0A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
                $this->addSql('ALTER TABLE app_registration ADD CONSTRAINT FK_A026BD26A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

                // Custom schema
                $this->addSql('CREATE TABLE ds_session (id VARCHAR(128) NOT NULL PRIMARY KEY, data BYTEA NOT NULL, time INTEGER NOT NULL, lifetime INTEGER NOT NULL)');

                // Data
                $yml = file_get_contents('/srv/api-platform/src/AppBundle/Resources/migrations/1_0_0.yml');
                $data = Yaml::parse($yml);

                $this->addSql('
                    INSERT INTO 
                        ds_parameter (id, key, value, enabled)
                    VALUES 
                        (1, \'ds_system.user.username\', \'"'.$data['system']['username'].'"\', true),
                        (2, \'ds_system.user.password\', \'"'.$data['system']['password'].'"\', true),
                        (3, \'ds_tenant.tenant.default\', \'"'.$data['tenant']['uuid'].'"\', true);
                ');

                $this->addSql('
                    INSERT INTO 
                        ds_tenant (id, uuid, data, created_at, updated_at)
                    VALUES 
                        (1, \''.$data['tenant']['uuid'].'\', \'{}\', now(), now());
                ');

                $this->addSql('
                    INSERT INTO 
                        ds_config (id, uuid, owner, owner_uuid, key, value, enabled, version, tenant, created_at, updated_at)
                    VALUES 
                        (1, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.spa.admin\', \'"'.$data['config']['app.spa.admin']['value'].'"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (2, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.spa.portal\', \'"'.$data['config']['app.spa.portal']['value'].'"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (3, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.spa.portal.oauth.success\', \'"'.$data['config']['app.spa.portal.oauth.success']['value'].'"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (4, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.individual.owner.type\', \'"BusinessUnit"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (5, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.individual.owner.uuid\', \'"'.$data['business_unit']['administration']['uuid'].'"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (6, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.individual.data.github\', \'"{}"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (7, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.individual.data.google\', \'"{}"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (8, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.individual.data.twitter\', \'"{}"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (9, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.individual.roles\', \'[]\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (10, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.individual.enabled\', \'true\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (11, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.organization.owner.type\', \'"BusinessUnit"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (12, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.organization.owner.uuid\', \'"'.$data['business_unit']['administration']['uuid'].'"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (13, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.organization.data.github\', \'"{}"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (14, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.organization.data.google\', \'"{}"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (15, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.organization.data.twitter\', \'"{}"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (16, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.organization.roles\', \'[]\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (17, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.organization.enabled\', \'true\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (18, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.resetting.email.subject\', \'"app.resetting.email.subject"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (19, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.resetting.email.body.plain\', \'"app.resetting.email.body.plain"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (20, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.resetting.email.body.html\', \'"app.resetting.email.body.html"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (21, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.user.username\', \'"'.$data['user']['system']['username'].'"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (22, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.user.password\', \'"'.$data['user']['system']['password'].'"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (23, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.user.uuid\', \'"'.$data['user']['system']['uuid'].'"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (24, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.user.roles\', \'[]\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (25, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.user.identity.roles\', \'[]\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (26, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.user.identity.type\', \'"System"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (27, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.user.identity.uuid\', \'"'.$data['identity']['system']['uuid'].'"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (28, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.user.tenant\', \'"'.$data['tenant']['uuid'].'"\', true, 1, \''.$data['tenant']['uuid'].'\', now(), now());
                ');

                $this->addSql('
                    INSERT INTO 
                        ds_access (id, uuid, owner, owner_uuid, assignee, assignee_uuid, version, tenant, created_at, updated_at)
                    VALUES 
                        (1, \''.Uuid::uuid4()->toString().'\', \'System\', \''.$data['identity']['system']['uuid'].'\', \'System\', \''.$data['identity']['system']['uuid'].'\', 1, \''.$data['tenant']['uuid'].'\', now(), now()),
                        (2, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'Staff\', \''.$data['identity']['admin']['uuid'].'\', 1, \''.$data['tenant']['uuid'].'\', now(), now());
                ');

                $this->addSql('
                    INSERT INTO 
                        ds_access_permission (id, access_id, scope, entity, entity_uuid, key, attributes, tenant)
                    VALUES 
                        (1, 1, \'generic\', NULL, NULL, \'entity\', \'["BROWSE","READ","EDIT","ADD","DELETE"]\', \''.$data['tenant']['uuid'].'\'),
                        (2, 1, \'generic\', NULL, NULL, \'property\', \'["BROWSE","READ","EDIT"]\', \''.$data['tenant']['uuid'].'\'),
                        (3, 1, \'generic\', NULL, NULL, \'generic\', \'["BROWSE","READ","EDIT","ADD","DELETE","EXECUTE"]\', \''.$data['tenant']['uuid'].'\'),
                        (4, 2, \'generic\', NULL, NULL, \'entity\', \'["BROWSE","READ","EDIT","ADD","DELETE"]\', \''.$data['tenant']['uuid'].'\'),
                        (5, 2, \'generic\', NULL, NULL, \'property\', \'["BROWSE","READ","EDIT"]\', \''.$data['tenant']['uuid'].'\'),
                        (6, 2, \'generic\', NULL, NULL, \'generic\', \'["BROWSE","READ","EDIT","ADD","DELETE","EXECUTE"]\', \''.$data['tenant']['uuid'].'\');
                ');

                $this->addSql('
                    INSERT INTO 
                        app_user (id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles, uuid, owner, owner_uuid, identity, identity_uuid, version, tenant, created_at, updated_at, deleted_at)
                    VALUES 
                        (1, \'system@system.ds\', \'system@system.ds\', \'system@system.ds\', \'system@system.ds\', true, NULL, \''.password_hash($data['user']['system']['password'], PASSWORD_BCRYPT).'\', NULL, NULL, NULL, \'a:1:{i:0;s:0:"";}\', \''.$data['user']['system']['uuid'].'\', \'System\', \''.$data['identity']['system']['uuid'].'\', \'System\', \''.$data['identity']['system']['uuid'].'\', 1, \''.$data['tenant']['uuid'].'\', now(), now(), NULL),
                        (2, \'anonymous@anonymous.ds\', \'anonymous@anonymous.ds\', \'anonymous@anonymous.ds\', \'anonymous@anonymous.ds\', true, NULL, \''.password_hash($data['user']['anonymous']['password'], PASSWORD_BCRYPT).'\', NULL, NULL, NULL, \'a:1:{i:0;s:0:"";}\', \''.$data['user']['anonymous']['uuid'].'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'Anonymous\', NULL, 1, \''.$data['tenant']['uuid'].'\', now(), now(), NULL),
                        (3, \'admin@staff.ds\', \'admin@staff.ds\', \'admin@staff.ds\', \'admin@staff.ds\', true, NULL, \''.password_hash($data['user']['admin']['password'], PASSWORD_BCRYPT).'\', NULL, NULL, NULL, \'a:1:{i:0;s:0:"";}\', \''.$data['user']['admin']['uuid'].'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'Staff\', \''.$data['identity']['admin']['uuid'].'\', 1, \''.$data['tenant']['uuid'].'\', now(), now(), NULL);
                ');

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
                // Entity schema
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

                // Custom schema
                $this->addSql('DROP TABLE ds_session');
                break;

            default:
                $this->abortIf(true,'Migration cannot be executed on "'.$platform.'".');
                break;
        }
    }
}
