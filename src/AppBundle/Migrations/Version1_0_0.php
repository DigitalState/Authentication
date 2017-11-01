<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

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
        // Tables
        $this->addSql('CREATE TABLE ds_session (id VARCHAR(128) NOT NULL PRIMARY KEY, `data` BLOB NOT NULL, `time` INTEGER UNSIGNED NOT NULL, lifetime MEDIUMINT NOT NULL) COLLATE utf8_bin, engine = innodb');
        $this->addSql('CREATE TABLE ds_config (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', `owner` VARCHAR(255) DEFAULT NULL, owner_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', `key` VARCHAR(255) NOT NULL, `value` LONGTEXT DEFAULT NULL, enabled TINYINT(1) NOT NULL, version INT DEFAULT 1 NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_758C45F4D17F50A6 (uuid), UNIQUE INDEX UNIQ_758C45F44E645A7E (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ds_access (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', `owner` VARCHAR(255) DEFAULT NULL, owner_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', identity VARCHAR(255) DEFAULT NULL, identity_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', version INT DEFAULT 1 NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_A76F41DCD17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ds_access_permission (id INT AUTO_INCREMENT NOT NULL, access_id INT DEFAULT NULL, entity VARCHAR(255) DEFAULT NULL, entity_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', `key` VARCHAR(255) NOT NULL, attributes LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', INDEX IDX_D46DD4D04FEA67CF (access_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_registration (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', `owner` VARCHAR(255) DEFAULT NULL, owner_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', username VARCHAR(255) NOT NULL, identity VARCHAR(255) DEFAULT NULL, data LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', version INT DEFAULT 1 NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_A026BD26D17F50A6 (uuid), UNIQUE INDEX UNIQ_A026BD26F85E0677 (username), UNIQUE INDEX UNIQ_A026BD26A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', `owner` VARCHAR(255) DEFAULT NULL, owner_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', identity VARCHAR(255) DEFAULT NULL, identity_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', version INT DEFAULT 1 NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_88BDF3E992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_88BDF3E9A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_88BDF3E9C05FB297 (confirmation_token), UNIQUE INDEX UNIQ_88BDF3E9D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

        // Foreign keys
        $this->addSql('ALTER TABLE ds_access_permission ADD CONSTRAINT FK_D46DD4D04FEA67CF FOREIGN KEY (access_id) REFERENCES ds_access (id)');
        $this->addSql('ALTER TABLE app_registration ADD CONSTRAINT FK_A026BD26A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id)');

        // Data
        $this->addSql('
            INSERT INTO 
                `app_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `uuid`, `owner`, `owner_uuid`, `identity`, `identity_uuid`, `version`, `created_at`, `updated_at`, `deleted_at`)
            VALUES 
                (1, \'system@ds\', \'system@ds\', \'system@ds\', \'system@ds\', 1, NULL, \'$2y$13$N2Zv69vP24ScS4IQ.gLHL.r2bDI8x/M5TxSZIRbTSFGkxiXfGzOgi\', NULL, NULL, NULL, \'a:1:{i:0;s:11:"ROLE_SYSTEM";}\', \'b496655f-8fe6-4340-9a77-1bc3eeabab53\', \'System\', \'df5fd904-aa47-452f-9c4a-d6b52fe5ace4\', \'System\', \'df5fd904-aa47-452f-9c4a-d6b52fe5ace4\', 1, now(), now(), NULL),
                (2, \'anonymous@ds\', \'anonymous@ds\', \'anonymous@ds\', \'anonymous@ds\', 1, NULL, \'$2y$13$N2Zv69vP24ScS4IQ.gLHL.r2bDI8x/M5TxSZIRbTSFGkxiXfGzOgi\', NULL, NULL, NULL, \'a:1:{i:0;s:14:"ROLE_ANONYMOUS";}\', \'4b3fbbe5-d76a-40d6-a646-d6166c843eb2\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'Anonymous\', NULL, 1, now(), now(), NULL),
                (3, \'bpm@ds\', \'bpm@ds\', \'bpm@ds\', \'bpm@ds\', 1, NULL, \'$2y$13$N2Zv69vP24ScS4IQ.gLHL.r2bDI8x/M5TxSZIRbTSFGkxiXfGzOgi\', NULL, NULL, NULL, \'a:1:{i:0;s:11:"ROLE_SYSTEM";}\', \'42157409-f2f1-4f16-a954-a92a9d1bf3d1\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'System\', \'7b59586d-6924-47f3-bc1b-0dc207f5e80c\', 1, now(), now(), NULL);
        ');

        $this->addSql('
            INSERT INTO 
                `ds_config` (`id`, `uuid`, `owner`, `owner_uuid`, `key`, `value`, `enabled`, `version`, `created_at`, `updated_at`)
            VALUES 
                (1, \'fb96f432-d95f-4555-a2fa-7841d817a626\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'app.registration.individual.owner\', \'BusinessUnit\', 1, 1, now(), now()),
                (2, \'f4b4bcc4-78a9-4b54-9bcc-6a8924db1eae\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'app.registration.individual.owner_uuid\', \'447a62c0-7043-41f7-8540-d57aa15070de\', 1, 1, now(), now()),
                (3, \'aeda0e1f-28b4-463f-9387-9b1e2b6073b0\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'app.registration.individual.roles\', \'ROLE_INDIVIDUAL\', 1, 1, now(), now()),
                (4, \'2244f1ab-293c-4ee0-a158-2bb4621b9256\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'app.registration.individual.enabled\', 1, 1, 1, now(), now()),
                (5, \'4f4e90e3-3f0d-438d-b327-4cfc8febf40b\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'app.registration.organization.owner\', \'BusinessUnit\', 1, 1, now(), now()),
                (6, \'d8788c41-6972-4afc-9b27-d3c8edc5846f\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'app.registration.organization.owner_uuid\', \'447a62c0-7043-41f7-8540-d57aa15070de\', 1, 1, now(), now()),
                (7, \'003e1dfd-5ac2-4c20-ad40-0d1310a70d61\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'app.registration.organization.roles\', \'ROLE_ORGANIZATION\', 1, 1, now(), now()),
                (8, \'6f75ecdd-407d-4240-9a5d-e880f1050d0d\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'app.registration.organization.enabled\', 1, 1, 1, now(), now()),
                (9, \'328005da-f30a-4d6c-beeb-a7b121af9dda\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'ds_api.user.username\', \'system@ds\', 1, 1, now(), now()),
                (10, \'03192e19-0a42-4580-9ce4-8cadd885f4b6\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'ds_api.user.uuid\', \'b496655f-8fe6-4340-9a77-1bc3eeabab53\', 1, 1, now(), now()),
                (11, \'d8ef0814-b88f-4a66-858e-9ab0341f12b5\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'ds_api.user.roles\', \'ROLE_SYSTEM\', 1, 1, now(), now()),
                (12, \'35ac315f-3a9d-4627-8aac-b9609e421f5e\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'ds_api.user.identity\', \'System\', 1, 1, now(), now()),
                (13, \'44edc068-fa1e-4b8a-bd3a-4f98d348d525\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'ds_api.user.identity_uuid\', \'df5fd904-aa47-452f-9c4a-d6b52fe5ace4\', 1, 1, now(), now()),
                (14, \'b8bb00a5-5055-4a3f-8762-908b21c63ef8\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'ds_api.api.authentication.host\', \'http://127.0.0.1\', 1, 1, now(), now()),
                (15, \'2210d668-9d3f-465c-a9bb-79101c7e76ba\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'ds_api.api.identities.host\', \'http://127.0.0.1\', 1, 1, now(), now()),
                (16, \'50b1e9c5-b96c-4533-88c5-94ed800e569c\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'ds_api.api.cases.host\', \'http://127.0.0.1\', 1, 1, now(), now()),
                (17, \'2fb6b34b-9a08-443d-91b9-7172b15537a6\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'ds_api.api.services.host\', \'http://127.0.0.1\', 1, 1, now(), now()),
                (18, \'70a56725-fe17-4ee9-995c-894fa2f682cd\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'ds_api.api.records.host\', \'http://127.0.0.1\', 1, 1, now(), now()),
                (19, \'10be5003-cc4e-4945-9444-f0953bfb3762\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'ds_api.api.assets.host\', \'http://127.0.0.1\', 1, 1, now(), now()),
                (20, \'ffdb061b-4a88-4e02-8567-675ff01d0361\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'ds_api.api.cms.host\', \'http://127.0.0.1\', 1, 1, now(), now()),
                (21, \'87290bf2-0c01-4df9-940e-2b9987a9792f\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'ds_api.api.camunda.host\', \'http://127.0.0.1/engine-rest\', 1, 1, now(), now()),
                (22, \'6eb11430-9e99-4064-bee7-bd3be4644780\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'ds_api.api.formio.host\', \'http://127.0.0.1\', 1, 1, now(), now());
        ');

        $this->addSql('
            INSERT INTO 
                `ds_access` (`id`, `uuid`, `owner`, `owner_uuid`, `identity`, `identity_uuid`, `version`, `created_at`, `updated_at`)
            VALUES 
                (1, \'fda501b2-6fdb-4122-8a2a-2f4e8eddc83c\', \'System\', \'df5fd904-aa47-452f-9c4a-d6b52fe5ace4\', \'System\', \'df5fd904-aa47-452f-9c4a-d6b52fe5ace4\', 1, now(), now()),
                (2, \'b1bf6078-e676-4ac6-88e3-5b47a38efcd1\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'System\', \'7b59586d-6924-47f3-bc1b-0dc207f5e80c\', 1, now(), now());
        ');

        $this->addSql('
            INSERT INTO 
                `ds_access_permission` (`id`, `access_id`, `entity`, `entity_uuid`, `key`, `attributes`)
            VALUES 
                (1, 1, \'BusinessUnit\', NULL, \'entity\', \'["BROWSE","READ","EDIT","ADD","DELETE"]\'),
                (2, 1, \'BusinessUnit\', NULL, \'property\', \'["BROWSE","READ","EDIT"]\'),
                (3, 1, \'BusinessUnit\', NULL, \'custom\', \'["BROWSE","READ","EDIT","ADD","DELETE","EXECUTE"]\'),
                (4, 2, \'BusinessUnit\', NULL, \'entity\', \'["BROWSE","READ","EDIT","ADD","DELETE"]\'),
                (5, 2, \'BusinessUnit\', NULL, \'property\', \'["BROWSE","READ","EDIT"]\'),
                (6, 2, \'BusinessUnit\', NULL, \'custom\', \'["BROWSE","READ","EDIT","ADD","DELETE","EXECUTE"]\');
        ');
    }

    /**
     * Down
     *
     * @param \Doctrine\DBAL\Schema\Schema $schema
     */
    public function down(Schema $schema)
    {
        // Foreign keys
        $this->addSql('ALTER TABLE ds_access_permission DROP FOREIGN KEY FK_D46DD4D04FEA67CF');
        $this->addSql('ALTER TABLE app_registration DROP FOREIGN KEY FK_A026BD26A76ED395');

        // Tables
        $this->addSql('DROP TABLE ds_config');
        $this->addSql('DROP TABLE ds_access');
        $this->addSql('DROP TABLE ds_access_permission');
        $this->addSql('DROP TABLE app_registration');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE ds_session');
    }
}
