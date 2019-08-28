<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190828143043 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE household DROP FOREIGN KEY FK_54C32FC08BAC62AF');
        $this->addSql('ALTER TABLE school DROP FOREIGN KEY FK_F99EDABB8BAC62AF');
        $this->addSql('ALTER TABLE school_user DROP FOREIGN KEY FK_CCBB09A4C32A47EE');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33C32A47EE');
        $this->addSql('ALTER TABLE teacher_school DROP FOREIGN KEY FK_EC15084EC32A47EE');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE school');
        $this->addSql('DROP TABLE school_user');
        $this->addSql('DROP TABLE teacher_school');
        $this->addSql('DROP INDEX IDX_B723AF33C32A47EE ON student');
        $this->addSql('ALTER TABLE student DROP school_id');
        $this->addSql('DROP INDEX IDX_54C32FC08BAC62AF ON household');
        $this->addSql('ALTER TABLE household DROP city_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, slug VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, address VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, slug VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_F99EDABB8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school_user (school_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_CCBB09A4C32A47EE (school_id), INDEX IDX_CCBB09A4A76ED395 (user_id), PRIMARY KEY(school_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher_school (teacher_id INT NOT NULL, school_id INT NOT NULL, INDEX IDX_EC15084E41807E1D (teacher_id), INDEX IDX_EC15084EC32A47EE (school_id), PRIMARY KEY(teacher_id, school_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE school ADD CONSTRAINT FK_F99EDABB8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE school_user ADD CONSTRAINT FK_CCBB09A4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE school_user ADD CONSTRAINT FK_CCBB09A4C32A47EE FOREIGN KEY (school_id) REFERENCES school (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teacher_school ADD CONSTRAINT FK_EC15084E41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teacher_school ADD CONSTRAINT FK_EC15084EC32A47EE FOREIGN KEY (school_id) REFERENCES school (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE household ADD city_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE household ADD CONSTRAINT FK_54C32FC08BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_54C32FC08BAC62AF ON household (city_id)');
        $this->addSql('ALTER TABLE student ADD school_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33C32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('CREATE INDEX IDX_B723AF33C32A47EE ON student (school_id)');
    }
}
