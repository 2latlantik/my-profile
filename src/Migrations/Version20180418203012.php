<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180418203012 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, file_group_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_8C9F36104F0456DA (file_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file_group (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F36104F0456DA FOREIGN KEY (file_group_id) REFERENCES file_group (id)');
        $this->addSql('ALTER TABLE profile ADD profile_picture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F292E8AE2 FOREIGN KEY (profile_picture_id) REFERENCES file_group (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0F292E8AE2 ON profile (profile_picture_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F36104F0456DA');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F292E8AE2');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE file_group');
        $this->addSql('DROP INDEX UNIQ_8157AA0F292E8AE2 ON profile');
        $this->addSql('ALTER TABLE profile DROP profile_picture_id');
    }
}
