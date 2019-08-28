<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190828143905 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, INDEX IDX_F99EDABB8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school_teacher (school_id INT NOT NULL, teacher_id INT NOT NULL, INDEX IDX_22D9944DC32A47EE (school_id), INDEX IDX_22D9944D41807E1D (teacher_id), PRIMARY KEY(school_id, teacher_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE school ADD CONSTRAINT FK_F99EDABB8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE school_teacher ADD CONSTRAINT FK_22D9944DC32A47EE FOREIGN KEY (school_id) REFERENCES school (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE school_teacher ADD CONSTRAINT FK_22D9944D41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student ADD school_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33C32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('CREATE INDEX IDX_B723AF33C32A47EE ON student (school_id)');
        $this->addSql('ALTER TABLE household ADD ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE household ADD CONSTRAINT FK_54C32FC0A73F0036 FOREIGN KEY (ville_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_54C32FC0A73F0036 ON household (ville_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE school DROP FOREIGN KEY FK_F99EDABB8BAC62AF');
        $this->addSql('ALTER TABLE household DROP FOREIGN KEY FK_54C32FC0A73F0036');
        $this->addSql('ALTER TABLE school_teacher DROP FOREIGN KEY FK_22D9944DC32A47EE');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33C32A47EE');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE school');
        $this->addSql('DROP TABLE school_teacher');
        $this->addSql('DROP INDEX IDX_54C32FC0A73F0036 ON household');
        $this->addSql('ALTER TABLE household DROP ville_id');
        $this->addSql('DROP INDEX IDX_B723AF33C32A47EE ON student');
        $this->addSql('ALTER TABLE student DROP school_id');
    }
}
