<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180214222458 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL, ADD registered_at DATETIME DEFAULT NULL, CHANGE username username VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_8d93d649e7927c74 TO app_user_email');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP roles, DROP registered_at, CHANGE username username VARCHAR(25) NOT NULL COLLATE utf8_unicode_ci, CHANGE password password VARCHAR(64) NOT NULL COLLATE utf8_unicode_ci, CHANGE email email VARCHAR(60) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE user RENAME INDEX app_user_email TO UNIQ_8D93D649E7927C74');
    }
}
