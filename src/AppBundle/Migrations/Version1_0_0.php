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
        $this->addSql('CREATE TABLE app_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', `owner` VARCHAR(255) DEFAULT NULL, owner_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', identity VARCHAR(255) DEFAULT NULL, identity_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', version INT DEFAULT 1 NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_88BDF3E992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_88BDF3E9A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_88BDF3E9C05FB297 (confirmation_token), UNIQUE INDEX UNIQ_88BDF3E9D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

        // Foreign keys
        $this->addSql('ALTER TABLE ds_access_permission ADD CONSTRAINT FK_D46DD4D04FEA67CF FOREIGN KEY (access_id) REFERENCES ds_access (id)');

        // Data
        $this->addSql('
            INSERT INTO 
                `app_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `uuid`, `owner`, `owner_uuid`, `identity`, `identity_uuid`, `version`, `created_at`, `updated_at`, `deleted_at`)
            VALUES 
                (1, \'admin@digitalstate.ca\', \'admin@digitalstate.ca\', \'admin@digitalstate.ca\', \'admin@digitalstate.ca\', 1, NULL, \'$2y$13$N2Zv69vP24ScS4IQ.gLHL.r2bDI8x/M5TxSZIRbTSFGkxiXfGzOgi\', NULL, NULL, NULL, \'a:1:{i:0;s:10:"ROLE_ADMIN";}\', \'b3fdddc9-896d-4e56-98a2-63b6eeab0598\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'Admin\', \'b7651daf-8ecb-4c23-b703-e7c379791778\', 1, now(), now(), NULL),
                (2, \'system@digitalstate.ca\', \'system@digitalstate.ca\', \'system@digitalstate.ca\', \'system@digitalstate.ca\', 1, NULL, \'$2y$13$N2Zv69vP24ScS4IQ.gLHL.r2bDI8x/M5TxSZIRbTSFGkxiXfGzOgi\', NULL, NULL, NULL, \'a:1:{i:0;s:11:"ROLE_SYSTEM";}\', \'b496655f-8fe6-4340-9a77-1bc3eeabab53\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'System\', \'df5fd904-aa47-452f-9c4a-d6b52fe5ace4\', 1, now(), now(), NULL),
                (3, \'anonymous@digitalstate.ca\', \'anonymous@digitalstate.ca\', \'anonymous@digitalstate.ca\', \'anonymous@digitalstate.ca\', 1, NULL, \'$2y$13$N2Zv69vP24ScS4IQ.gLHL.r2bDI8x/M5TxSZIRbTSFGkxiXfGzOgi\', NULL, NULL, NULL, \'a:1:{i:0;s:14:"ROLE_ANONYMOUS";}\', \'4b3fbbe5-d76a-40d6-a646-d6166c843eb2\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'Anonymous\', NULL, 1, now(), now(), NULL);
        ');

        $this->addSql('
            INSERT INTO 
                `ds_config` (`id`, `uuid`, `owner`, `owner_uuid`, `key`, `value`, `enabled`, `version`, `created_at`, `updated_at`)
            VALUES 
                (1, \'bdba6587-124f-443a-ae4e-ef2d925b4848\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'app.registration.handler\', \'system@ds\', 1, 1, now(), now()),
                (2, \'68487cdf-5e7c-48c4-b353-99b100c07921\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'app.registration.endpoint\', \'https://api.ds\', 1, 1, now(), now()),
                (3, \'87351e29-a842-438c-aa9d-37fd415c3570\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'app.registration.individual.roles\', \'ROLE_INDIVIDUAL\', 1, 1, now(), now()),
                (4, \'6b6e5828-d05e-42d2-b1d3-fa35a07ec3ee\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'app.registration.individual.identity\', \'Individual\', 1, 1, now(), now()),
                (5, \'4f4e90e3-3f0d-438d-b327-4cfc8febf40b\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'app.registration.individual.owner\', \'BusinessUnit\', 1, 1, now(), now()),
                (6, \'d8788c41-6972-4afc-9b27-d3c8edc5846f\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'app.registration.individual.owner_uuid\', \'194671e9-12aa-41df-8feb-1ba45e4a71e6\', 1, 1, now(), now()),
                (7, \'6f75ecdd-407d-4240-9a5d-e880f1050d0d\', \'BusinessUnit\', \'11bec012-a73f-45c1-8d2e-53502fa58c23\', \'app.registration.individual.enabled\', 1, 1, 1, now(), now());
        ');

        // @todo permissions
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

        // Tables
        $this->addSql('DROP TABLE ds_config');
        $this->addSql('DROP TABLE ds_access');
        $this->addSql('DROP TABLE ds_access_permission');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE ds_session');
    }
}
