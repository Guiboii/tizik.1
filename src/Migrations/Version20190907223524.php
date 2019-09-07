<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190907223524 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE discipline_school DROP FOREIGN KEY FK_81DE74AAA5522701');
        $this->addSql('ALTER TABLE discipline_teacher DROP FOREIGN KEY FK_DA3EC689A5522701');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('DROP TABLE discipline_school');
        $this->addSql('DROP TABLE discipline_teacher');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE discipline (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discipline_school (discipline_id INT NOT NULL, school_id INT NOT NULL, INDEX IDX_81DE74AAA5522701 (discipline_id), INDEX IDX_81DE74AAC32A47EE (school_id), PRIMARY KEY(discipline_id, school_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discipline_teacher (discipline_id INT NOT NULL, teacher_id INT NOT NULL, INDEX IDX_DA3EC689A5522701 (discipline_id), INDEX IDX_DA3EC68941807E1D (teacher_id), PRIMARY KEY(discipline_id, teacher_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE discipline_school ADD CONSTRAINT FK_81DE74AAA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discipline_school ADD CONSTRAINT FK_81DE74AAC32A47EE FOREIGN KEY (school_id) REFERENCES school (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discipline_teacher ADD CONSTRAINT FK_DA3EC68941807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discipline_teacher ADD CONSTRAINT FK_DA3EC689A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE');
    }
}
