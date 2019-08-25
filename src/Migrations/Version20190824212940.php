<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190824212940 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reed DROP FOREIGN KEY FK_FC3B8463576087C6');
        $this->addSql('ALTER TABLE reed DROP FOREIGN KEY FK_FC3B8463A8AE880A');
        $this->addSql('DROP TABLE cane');
        $this->addSql('DROP TABLE reed');
        $this->addSql('DROP TABLE tube');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cane (id INT AUTO_INCREMENT NOT NULL, quantity INT NOT NULL, price DOUBLE PRECISION NOT NULL, date_buy DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reed (id INT AUTO_INCREMENT NOT NULL, cane_id INT NOT NULL, tube_id INT NOT NULL, color VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, date_build DATE NOT NULL, date_sell DATE NOT NULL, paid TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_FC3B8463576087C6 (cane_id), INDEX IDX_FC3B8463A8AE880A (tube_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tube (id INT AUTO_INCREMENT NOT NULL, ref VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, date_buy DATE NOT NULL, price DOUBLE PRECISION NOT NULL, model VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, length INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reed ADD CONSTRAINT FK_FC3B8463576087C6 FOREIGN KEY (cane_id) REFERENCES cane (id)');
        $this->addSql('ALTER TABLE reed ADD CONSTRAINT FK_FC3B8463A8AE880A FOREIGN KEY (tube_id) REFERENCES tube (id)');
    }
}
