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
        $this->addSql('CREATE TABLE ds_permission (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', `owner` VARCHAR(255) DEFAULT NULL, owner_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', identity VARCHAR(255) DEFAULT NULL, identity_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', version INT DEFAULT 1 NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_7A6F7670D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ds_permission_entry (id INT AUTO_INCREMENT NOT NULL, permission_id INT DEFAULT NULL, business_unit_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', `key` VARCHAR(255) NOT NULL, attributes LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', INDEX IDX_E68A6391FED90CCA (permission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', `owner` VARCHAR(255) DEFAULT NULL, owner_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', identity VARCHAR(255) DEFAULT NULL, identity_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', version INT DEFAULT 1 NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_88BDF3E992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_88BDF3E9A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_88BDF3E9C05FB297 (confirmation_token), UNIQUE INDEX UNIQ_88BDF3E9D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

        // Foreign keys
        $this->addSql('ALTER TABLE ds_permission_entry ADD CONSTRAINT FK_E68A6391FED90CCA FOREIGN KEY (permission_id) REFERENCES ds_permission (id)');

        // Data
        $this->addSql('
            INSERT INTO 
                `app_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `uuid`, `owner`, `owner_uuid`, `identity`, `identity_uuid`, `version`, `created_at`, `updated_at`, `deleted_at`)
            VALUES 
                (1, \'admin@ds\', \'admin@ds\', \'admin@ds\', \'admin@ds\', 1, NULL, \'$2y$13$N2Zv69vP24ScS4IQ.gLHL.r2bDI8x/M5TxSZIRbTSFGkxiXfGzOgi\', NULL, NULL, NULL, \'a:1:{i:0;s:10:"ROLE_ADMIN";}\', \'aad70948-0089-483a-bae7-f71d50b0386f\', \'Admin\', \'59717ce0-5a37-46d8-ad80-66d5b22d2ccf\', \'Admin\', \'59717ce0-5a37-46d8-ad80-66d5b22d2ccf\', 1, now(), now(), NULL),
                (2, \'system@ds\', \'system@ds\', \'system@ds\', \'system@ds\', 1, NULL, \'$2y$13$N2Zv69vP24ScS4IQ.gLHL.r2bDI8x/M5TxSZIRbTSFGkxiXfGzOgi\', NULL, NULL, NULL, \'a:1:{i:0;s:11:"ROLE_SYSTEM";}\', \'e67b996e-357f-48d8-b18c-a5e84d87eeef\', \'System\', \'bd654051-6a03-488a-a771-bb3bfc646a9f\', \'System\', \'bd654051-6a03-488a-a771-bb3bfc646a9f\', 1, now(), now(), NULL),
                (3, \'anonymous@ds\', \'anonymous@ds\', \'anonymous@ds\', \'anonymous@ds\', 1, NULL, \'$2y$13$N2Zv69vP24ScS4IQ.gLHL.r2bDI8x/M5TxSZIRbTSFGkxiXfGzOgi\', NULL, NULL, NULL, \'a:1:{i:0;s:14:"ROLE_ANONYMOUS";}\', \'2f5cd00c-613a-4813-bcd1-caccd3e4f2a4\', \'BusinessUnit\', \'6836c95c-4d92-4642-8b39-be60176411e6\', \'Anonymous\', NULL, 1, now(), now(), NULL);
        ');

        $this->addSql('
            INSERT INTO 
                `ds_config` (`id`, `uuid`, `owner`, `owner_uuid`, `key`, `value`, `enabled`, `version`, `created_at`, `updated_at`)
            VALUES 
                (1, \'f6751b55-653b-4a66-8b31-06ad2a3b52c2\', \'BusinessUnit\', \'ed1fe135-b791-4b8d-a033-acab9daa9853\', \'app.registration.handler\', \'system@ds\', 1, 1, now(), now()),
                (2, \'6928362f-5162-4c12-88fa-b77a9d6d9641\', \'BusinessUnit\', \'ed1fe135-b791-4b8d-a033-acab9daa9853\', \'app.registration.endpoint\', \'https://api.ds\', 1, 1, now(), now()),
                (3, \'d4e199b3-e128-4e9f-bb82-f50704d05ce5\', \'BusinessUnit\', \'ed1fe135-b791-4b8d-a033-acab9daa9853\', \'app.registration.individual.roles\', \'ROLE_INDIVIDUAL\', 1, 1, now(), now()),
                (4, \'296d729c-b18e-424f-913f-5121ee012865\', \'BusinessUnit\', \'ed1fe135-b791-4b8d-a033-acab9daa9853\', \'app.registration.individual.identity\', \'Individual\', 1, 1, now(), now()),
                (5, \'f246584b-d3af-42b1-8c8d-7cf1a650a739\', \'BusinessUnit\', \'ed1fe135-b791-4b8d-a033-acab9daa9853\', \'app.registration.individual.owner\', \'BusinessUnit\', 1, 1, now(), now()),
                (6, \'81f84145-56b5-4a3d-a8d7-9a4a7fe5adf0\', \'BusinessUnit\', \'ed1fe135-b791-4b8d-a033-acab9daa9853\', \'app.registration.individual.owner_uuid\', \'194671e9-12aa-41df-8feb-1ba45e4a71e6\', 1, 1, now(), now()),
                (7, \'b17c83be-c768-4352-a839-045048d0c0aa\', \'BusinessUnit\', \'ed1fe135-b791-4b8d-a033-acab9daa9853\', \'app.registration.individual.enabled\', 1, 1, 1, now(), now());
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
        $this->addSql('ALTER TABLE ds_permission_entry DROP FOREIGN KEY FK_E68A6391FED90CCA');

        // Tables
        $this->addSql('DROP TABLE ds_config');
        $this->addSql('DROP TABLE ds_permission');
        $this->addSql('DROP TABLE ds_permission_entry');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE ds_session');
    }
}
