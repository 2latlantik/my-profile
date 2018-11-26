<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181030132812 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE school_path (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, school VARCHAR(255) NOT NULL, degree VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, start DATE NOT NULL, end DATE NOT NULL, INDEX IDX_4A7C54E2CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE school_path ADD CONSTRAINT FK_4A7C54E2CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE profile CHANGE gender gender VARCHAR(20) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE school_path');
        $this->addSql('ALTER TABLE profile CHANGE gender gender VARCHAR(20) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
