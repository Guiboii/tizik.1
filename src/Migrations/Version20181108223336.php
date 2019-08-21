<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181108223336 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `read` ADD cane_id INT NOT NULL, ADD tube_id INT NOT NULL');
        $this->addSql('ALTER TABLE `read` ADD CONSTRAINT FK_98574167576087C6 FOREIGN KEY (cane_id) REFERENCES cane (id)');
        $this->addSql('ALTER TABLE `read` ADD CONSTRAINT FK_98574167A8AE880A FOREIGN KEY (tube_id) REFERENCES tube (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98574167576087C6 ON `read` (cane_id)');
        $this->addSql('CREATE INDEX IDX_98574167A8AE880A ON `read` (tube_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `read` DROP FOREIGN KEY FK_98574167576087C6');
        $this->addSql('ALTER TABLE `read` DROP FOREIGN KEY FK_98574167A8AE880A');
        $this->addSql('DROP INDEX UNIQ_98574167576087C6 ON `read`');
        $this->addSql('DROP INDEX IDX_98574167A8AE880A ON `read`');
        $this->addSql('ALTER TABLE `read` DROP cane_id, DROP tube_id');
    }
}
