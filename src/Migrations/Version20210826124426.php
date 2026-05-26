<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210826124426 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, file_group_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_8C9F36104F0456DA (file_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file_group (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE leisure (id INT AUTO_INCREMENT NOT NULL, rich_text_delta LONGTEXT DEFAULT NULL, rich_text_html LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE password_token (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, expired_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_BEAB6C245F37A13B (token), INDEX IDX_BEAB6C24A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professional_experience (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, society VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, rich_text_delta LONGTEXT DEFAULT NULL, rich_text_html LONGTEXT DEFAULT NULL, start DATE NOT NULL, end DATE DEFAULT NULL, INDEX IDX_32FDB9BACCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, profile_picture_id INT DEFAULT NULL, leisure_id INT DEFAULT NULL, surname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, job VARCHAR(255) DEFAULT NULL, birth_date DATETIME DEFAULT NULL, postal_code VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, rich_text_delta LONGTEXT DEFAULT NULL, rich_text_html LONGTEXT DEFAULT NULL, mail VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, viadeo VARCHAR(255) DEFAULT NULL, linkedin VARCHAR(255) DEFAULT NULL, situation_state VARCHAR(255) DEFAULT NULL, situation_goal VARCHAR(255) DEFAULT NULL, gender VARCHAR(20) DEFAULT NULL, UNIQUE INDEX UNIQ_8157AA0F989D9B62 (slug), UNIQUE INDEX UNIQ_8157AA0FA76ED395 (user_id), UNIQUE INDEX UNIQ_8157AA0F292E8AE2 (profile_picture_id), UNIQUE INDEX UNIQ_8157AA0F61840D8B (leisure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile_tag (profile_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_AD2B1EBCCCFA12B8 (profile_id), INDEX IDX_AD2B1EBCBAD26311 (tag_id), PRIMARY KEY(profile_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school_path (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, school VARCHAR(255) NOT NULL, degree VARCHAR(255) NOT NULL, rich_text_delta LONGTEXT DEFAULT NULL, rich_text_html LONGTEXT DEFAULT NULL, start DATE NOT NULL, end DATE DEFAULT NULL, INDEX IDX_4A7C54E2CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, skill_group_id INT DEFAULT NULL, `label` VARCHAR(255) NOT NULL, progression NUMERIC(5, 2) DEFAULT NULL, not_evaluated TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_5E3DE477BCFCB4B5 (skill_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_group (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, `label` VARCHAR(255) NOT NULL, INDEX IDX_48E8D7F9CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', is_active TINYINT(1) NOT NULL, registered_at DATETIME DEFAULT NULL, UNIQUE INDEX app_user_email (email), UNIQUE INDEX app_user_username (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_register_token (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, expired_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_E2B0BA9A5F37A13B (token), INDEX IDX_E2B0BA9AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F36104F0456DA FOREIGN KEY (file_group_id) REFERENCES file_group (id)');
        $this->addSql('ALTER TABLE password_token ADD CONSTRAINT FK_BEAB6C24A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE professional_experience ADD CONSTRAINT FK_32FDB9BACCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F292E8AE2 FOREIGN KEY (profile_picture_id) REFERENCES file_group (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F61840D8B FOREIGN KEY (leisure_id) REFERENCES leisure (id)');
        $this->addSql('ALTER TABLE profile_tag ADD CONSTRAINT FK_AD2B1EBCCCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile_tag ADD CONSTRAINT FK_AD2B1EBCBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE school_path ADD CONSTRAINT FK_4A7C54E2CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477BCFCB4B5 FOREIGN KEY (skill_group_id) REFERENCES skill_group (id)');
        $this->addSql('ALTER TABLE skill_group ADD CONSTRAINT FK_48E8D7F9CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE user_register_token ADD CONSTRAINT FK_E2B0BA9AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F36104F0456DA');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F292E8AE2');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F61840D8B');
        $this->addSql('ALTER TABLE professional_experience DROP FOREIGN KEY FK_32FDB9BACCFA12B8');
        $this->addSql('ALTER TABLE profile_tag DROP FOREIGN KEY FK_AD2B1EBCCCFA12B8');
        $this->addSql('ALTER TABLE school_path DROP FOREIGN KEY FK_4A7C54E2CCFA12B8');
        $this->addSql('ALTER TABLE skill_group DROP FOREIGN KEY FK_48E8D7F9CCFA12B8');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477BCFCB4B5');
        $this->addSql('ALTER TABLE profile_tag DROP FOREIGN KEY FK_AD2B1EBCBAD26311');
        $this->addSql('ALTER TABLE password_token DROP FOREIGN KEY FK_BEAB6C24A76ED395');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FA76ED395');
        $this->addSql('ALTER TABLE user_register_token DROP FOREIGN KEY FK_E2B0BA9AA76ED395');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE file_group');
        $this->addSql('DROP TABLE leisure');
        $this->addSql('DROP TABLE password_token');
        $this->addSql('DROP TABLE professional_experience');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE profile_tag');
        $this->addSql('DROP TABLE school_path');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skill_group');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_register_token');
    }
}
