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
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        // Tables
        $this->addSql('CREATE SEQUENCE ds_config_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ds_access_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ds_access_permission_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE app_registration_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE app_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ds_config (id INT NOT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, "key" VARCHAR(255) NOT NULL, "value" TEXT DEFAULT NULL, enabled BOOLEAN NOT NULL, version INT DEFAULT 1 NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_758C45F4D17F50A6 ON ds_config (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_758C45F4F48571EB ON ds_config ("key")');
        $this->addSql('CREATE TABLE ds_access (id INT NOT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, identity VARCHAR(255) DEFAULT NULL, identity_uuid UUID DEFAULT NULL, version INT DEFAULT 1 NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A76F41DCD17F50A6 ON ds_access (uuid)');
        $this->addSql('CREATE TABLE ds_access_permission (id INT NOT NULL, access_id INT DEFAULT NULL, entity VARCHAR(255) DEFAULT NULL, entity_uuid UUID DEFAULT NULL, "key" VARCHAR(255) NOT NULL, attributes JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D46DD4D04FEA67CF ON ds_access_permission (access_id)');
        $this->addSql('CREATE TABLE ds_session (id VARCHAR(128) NOT NULL PRIMARY KEY, data BYTEA NOT NULL, time INTEGER NOT NULL, lifetime INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE app_registration (id INT NOT NULL, user_id INT DEFAULT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, username VARCHAR(255) NOT NULL, identity VARCHAR(255) DEFAULT NULL, data JSON NOT NULL, version INT DEFAULT 1 NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A026BD26D17F50A6 ON app_registration (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A026BD26F85E0677 ON app_registration (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A026BD26A76ED395 ON app_registration (user_id)');
        $this->addSql('CREATE TABLE app_user (id INT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, roles TEXT NOT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, identity VARCHAR(255) DEFAULT NULL, identity_uuid UUID DEFAULT NULL, version INT DEFAULT 1 NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E992FC23A8 ON app_user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9A0D96FBF ON app_user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9C05FB297 ON app_user (confirmation_token)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9D17F50A6 ON app_user (uuid)');
        $this->addSql('COMMENT ON COLUMN app_user.roles IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE ds_access_permission ADD CONSTRAINT FK_D46DD4D04FEA67CF FOREIGN KEY (access_id) REFERENCES ds_access (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE app_registration ADD CONSTRAINT FK_A026BD26A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        // Data
        $yml = file_get_contents('/srv/api-platform/src/AppBundle/Resources/migrations/1_0_0.yml');
        $data = Yaml::parse($yml);

        foreach (array_keys($data['user']) as $user) {
            if (null === $data['user'][$user]['password']) {
                $data['user'][$user]['password'] = sha1(uniqid('', true).microtime(true));
            }
        }

        $this->addSql('
            INSERT INTO 
                app_user (id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles, uuid, owner, owner_uuid, identity, identity_uuid, version, created_at, updated_at, deleted_at)
            VALUES 
                (1, \'system@ds\', \'system@ds\', \'system@ds\', \'system@ds\', true, NULL, \''.password_hash($data['user']['system']['password'], PASSWORD_BCRYPT).'\', NULL, NULL, NULL, \'a:1:{i:0;s:11:"ROLE_SYSTEM";}\', \''.$data['user']['system']['uuid'].'\', \'System\', \''.$data['identity']['system']['uuid'].'\', \'System\', \''.$data['identity']['system']['uuid'].'\', 1, now(), now(), NULL),
                (2, \'anonymous@ds\', \'anonymous@ds\', \'anonymous@ds\', \'anonymous@ds\', true, NULL, \''.password_hash($data['user']['anonymous']['password'], PASSWORD_BCRYPT).'\', NULL, NULL, NULL, \'a:1:{i:0;s:14:"ROLE_ANONYMOUS";}\', \''.$data['user']['anonymous']['uuid'].'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'Anonymous\', NULL, 1, now(), now(), NULL),
                (3, \'admin@ds\', \'admin@ds\', \'admin@ds\', \'admin@ds\', true, NULL, \''.password_hash($data['user']['admin']['password'], PASSWORD_BCRYPT).'\', NULL, NULL, NULL, \'a:1:{i:0;s:10:"ROLE_STAFF";}\', \''.$data['user']['admin']['uuid'].'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'Staff\', \''.$data['identity']['admin']['uuid'].'\', 1, now(), now(), NULL);
        ');

        $this->addSql('
            INSERT INTO 
                ds_config (id, uuid, owner, owner_uuid, key, value, enabled, version, created_at, updated_at)
            VALUES 
                (1, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.spa.admin\', \''.$data['config']['app.spa.admin']['value'].'\', true, 1, now(), now()),
                (2, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.spa.portal\', \''.$data['config']['app.spa.admin']['value'].'\', true, 1, now(), now()),
                (3, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.individual.owner\', \'BusinessUnit\', true, 1, now(), now()),
                (4, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.individual.owner_uuid\', \''.$data['business_unit']['backoffice']['uuid'].'\', true, 1, now(), now()),
                (5, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.individual.roles\', \'ROLE_INDIVIDUAL\', true, 1, now(), now()),
                (6, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.individual.enabled\', 1, true, 1, now(), now()),
                (7, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.organization.owner\', \'BusinessUnit\', true, 1, now(), now()),
                (8, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.organization.owner_uuid\', \''.$data['business_unit']['backoffice']['uuid'].'\', true, 1, now(), now()),
                (9, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.organization.roles\', \'ROLE_ORGANIZATION\', true, 1, now(), now()),
                (10, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.registration.organization.enabled\', 1, true, 1, now(), now()),
                (11, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.resetting.email.subject\', \'app.resetting.email.subject\', true, 1, now(), now()),
                (12, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.resetting.email.body.plain\', \'app.resetting.email.body.plain\', true, 1, now(), now()),
                (13, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'app.resetting.email.body.html\', \'app.resetting.email.body.html\', true, 1, now(), now()),
                (14, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.user.username\', \'system@ds\', true, 1, now(), now()),
                (15, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.user.uuid\', \''.$data['user']['system']['uuid'].'\', true, 1, now(), now()),
                (16, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.user.roles\', \'ROLE_SYSTEM\', true, 1, now(), now()),
                (17, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.user.identity\', \'System\', true, 1, now(), now()),
                (18, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.user.identity_uuid\', \''.$data['identity']['system']['uuid'].'\', true, 1, now(), now()),
                (19, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.api.assets.host\', \''.$data['config']['ds_api.api.assets.host']['value'].'\', true, 1, now(), now()),
                (20, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.api.authentication.host\', \''.$data['config']['ds_api.api.authentication.host']['value'].'\', true, 1, now(), now()),
                (21, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.api.camunda.host\', \''.$data['config']['ds_api.api.camunda.host']['value'].'\', true, 1, now(), now()),
                (22, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.api.cases.host\', \''.$data['config']['ds_api.api.cases.host']['value'].'\', true, 1, now(), now()),
                (23, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.api.cms.host\', \''.$data['config']['ds_api.api.cms.host']['value'].'\', true, 1, now(), now()),
                (24, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.api.formio.host\', \''.$data['config']['ds_api.api.formio.host']['value'].'\', true, 1, now(), now()),
                (25, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.api.identities.host\', \''.$data['config']['ds_api.api.identities.host']['value'].'\', true, 1, now(), now()),
                (26, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.api.records.host\', \''.$data['config']['ds_api.api.records.host']['value'].'\', true, 1, now(), now()),
                (27, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.api.services.host\', \''.$data['config']['ds_api.api.services.host']['value'].'\', true, 1, now(), now()),
                (28, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'ds_api.api.tasks.host\', \''.$data['config']['ds_api.api.tasks.host']['value'].'\', true, 1, now(), now());
        ');

        $this->addSql('
            INSERT INTO 
                ds_access (id, uuid, owner, owner_uuid, identity, identity_uuid, version, created_at, updated_at)
            VALUES 
                (1, \''.Uuid::uuid4()->toString().'\', \'System\', \''.$data['identity']['system']['uuid'].'\', \'System\', \''.$data['identity']['system']['uuid'].'\', 1, now(), now()),
                (2, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'Anonymous\', NULL, 1, now(), now()),
                (3, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'Individual\', NULL, 1, now(), now()),
                (4, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'Organization\', NULL, 1, now(), now()),
                (5, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'Staff\', NULL, 1, now(), now()),
                (6, \''.Uuid::uuid4()->toString().'\', \'BusinessUnit\', \''.$data['business_unit']['administration']['uuid'].'\', \'Staff\', \''.$data['identity']['admin']['uuid'].'\', 1, now(), now());
        ');

        $this->addSql('
            INSERT INTO 
                ds_access_permission (id, access_id, entity, entity_uuid, key, attributes)
            VALUES 
                (1, 1, \'BusinessUnit\', NULL, \'entity\', \'["BROWSE","READ","EDIT","ADD","DELETE"]\'),
                (2, 1, \'BusinessUnit\', NULL, \'property\', \'["BROWSE","READ","EDIT"]\'),
                (3, 1, \'BusinessUnit\', NULL, \'custom\', \'["BROWSE","READ","EDIT","ADD","DELETE","EXECUTE"]\'),
                (4, 2, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'registration\', \'["ADD"]\'),
                (5, 2, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'registration_owner\', \'["EDIT"]\'),
                (6, 2, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'registration_owner_uuid\', \'["EDIT"]\'),
                (7, 2, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'registration_identity\', \'["EDIT"]\'),
                (8, 2, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'registration_username\', \'["EDIT"]\'),
                (9, 2, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'registration_password\', \'["EDIT"]\'),
                (10, 2, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'registration_data\', \'["EDIT"]\'),
                (11, 2, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'registration_version\', \'["EDIT"]\'),
                (12, 3, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user\', \'["BROWSE","READ","EDIT"]\'),
                (13, 3, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_uuid\', \'["BROWSE","READ"]\'),
                (14, 3, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_created_at\', \'["BROWSE","READ"]\'),
                (15, 3, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_username\', \'["BROWSE","READ"]\'),
                (16, 3, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_email\', \'["BROWSE","READ"]\'),
                (17, 3, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_version\', \'["BROWSE","READ"]\'),
                (18, 3, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_uuid\', \'["BROWSE","READ"]\'),
                (19, 3, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_username\', \'["EDIT"]\'),
                (20, 3, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_email\', \'["EDIT"]\'),
                (21, 3, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_version\', \'["EDIT"]\'),
                (22, 4, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user\', \'["BROWSE","READ","EDIT"]\'),
                (23, 4, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_uuid\', \'["BROWSE","READ"]\'),
                (24, 4, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_created_at\', \'["BROWSE","READ"]\'),
                (25, 4, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_username\', \'["BROWSE","READ"]\'),
                (26, 4, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_email\', \'["BROWSE","READ"]\'),
                (27, 4, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_version\', \'["BROWSE","READ"]\'),
                (28, 4, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_uuid\', \'["BROWSE","READ"]\'),
                (29, 4, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_username\', \'["EDIT"]\'),
                (30, 4, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_email\', \'["EDIT"]\'),
                (31, 4, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_version\', \'["EDIT"]\'),
                (32, 5, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user\', \'["BROWSE","READ"]\'),
                (33, 5, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'user_property\', \'["BROWSE","READ"]\'),
                (34, 5, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'registration\', \'["BROWSE","READ"]\'),
                (35, 5, \'BusinessUnit\', \''.$data['business_unit']['backoffice']['uuid'].'\', \'registration_property\', \'["BROWSE","READ"]\'),
                (36, 6, \'BusinessUnit\', NULL, \'entity\', \'["BROWSE","READ","EDIT","ADD","DELETE"]\'),
                (37, 6, \'BusinessUnit\', NULL, \'property\', \'["BROWSE","READ","EDIT"]\'),
                (38, 6, \'BusinessUnit\', NULL, \'custom\', \'["BROWSE","READ","EDIT","ADD","DELETE","EXECUTE"]\');
        ');
    }

    /**
     * Down
     *
     * @param \Doctrine\DBAL\Schema\Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        // Schema
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ds_access_permission DROP CONSTRAINT FK_D46DD4D04FEA67CF');
        $this->addSql('ALTER TABLE app_registration DROP CONSTRAINT FK_A026BD26A76ED395');
        $this->addSql('DROP SEQUENCE ds_config_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ds_access_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ds_access_permission_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE app_registration_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE app_user_id_seq CASCADE');
        $this->addSql('DROP TABLE ds_config');
        $this->addSql('DROP TABLE ds_access');
        $this->addSql('DROP TABLE ds_access_permission');
        $this->addSql('DROP TABLE ds_session');
        $this->addSql('DROP TABLE app_registration');
        $this->addSql('DROP TABLE app_user');
    }
}
