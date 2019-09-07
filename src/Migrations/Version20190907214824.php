<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190907214824 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE discipline_teacher (discipline_id INT NOT NULL, teacher_id INT NOT NULL, INDEX IDX_DA3EC689A5522701 (discipline_id), INDEX IDX_DA3EC68941807E1D (teacher_id), PRIMARY KEY(discipline_id, teacher_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discipline_school (discipline_id INT NOT NULL, school_id INT NOT NULL, INDEX IDX_81DE74AAA5522701 (discipline_id), INDEX IDX_81DE74AAC32A47EE (school_id), PRIMARY KEY(discipline_id, school_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE discipline_teacher ADD CONSTRAINT FK_DA3EC689A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discipline_teacher ADD CONSTRAINT FK_DA3EC68941807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discipline_school ADD CONSTRAINT FK_81DE74AAA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discipline_school ADD CONSTRAINT FK_81DE74AAC32A47EE FOREIGN KEY (school_id) REFERENCES school (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discipline DROP FOREIGN KEY FK_75BEEE3F41807E1D');
        $this->addSql('ALTER TABLE discipline DROP FOREIGN KEY FK_75BEEE3FC32A47EE');
        $this->addSql('DROP INDEX UNIQ_75BEEE3F41807E1D ON discipline');
        $this->addSql('DROP INDEX UNIQ_75BEEE3FC32A47EE ON discipline');
        $this->addSql('ALTER TABLE discipline DROP teacher_id, DROP school_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE discipline_teacher');
        $this->addSql('DROP TABLE discipline_school');
        $this->addSql('ALTER TABLE discipline ADD teacher_id INT DEFAULT NULL, ADD school_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE discipline ADD CONSTRAINT FK_75BEEE3F41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE discipline ADD CONSTRAINT FK_75BEEE3FC32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_75BEEE3F41807E1D ON discipline (teacher_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_75BEEE3FC32A47EE ON discipline (school_id)');
    }
}
