<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190822205217 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_B0F6A6D5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher_school (teacher_id INT NOT NULL, school_id INT NOT NULL, INDEX IDX_EC15084E41807E1D (teacher_id), INDEX IDX_EC15084EC32A47EE (school_id), PRIMARY KEY(teacher_id, school_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher_discipline (teacher_id INT NOT NULL, discipline_id INT NOT NULL, INDEX IDX_FFA14C9F41807E1D (teacher_id), INDEX IDX_FFA14C9FA5522701 (discipline_id), PRIMARY KEY(teacher_id, discipline_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE teacher_school ADD CONSTRAINT FK_EC15084E41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teacher_school ADD CONSTRAINT FK_EC15084EC32A47EE FOREIGN KEY (school_id) REFERENCES school (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teacher_discipline ADD CONSTRAINT FK_FFA14C9F41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teacher_discipline ADD CONSTRAINT FK_FFA14C9FA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE role_user');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649DB403044');
        $this->addSql('DROP INDEX IDX_8D93D649DB403044 ON user');
        $this->addSql('ALTER TABLE user DROP mentor_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE teacher_school DROP FOREIGN KEY FK_EC15084E41807E1D');
        $this->addSql('ALTER TABLE teacher_discipline DROP FOREIGN KEY FK_FFA14C9F41807E1D');
        $this->addSql('CREATE TABLE role_user (role_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_332CA4DDD60322AC (role_id), INDEX IDX_332CA4DDA76ED395 (user_id), PRIMARY KEY(role_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('DROP TABLE teacher_school');
        $this->addSql('DROP TABLE teacher_discipline');
        $this->addSql('ALTER TABLE user ADD mentor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649DB403044 FOREIGN KEY (mentor_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649DB403044 ON user (mentor_id)');
    }
}
