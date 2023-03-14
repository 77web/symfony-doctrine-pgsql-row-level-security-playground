<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230314144214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE member_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE task_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE member (id INT NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE task (id INT NOT NULL, member_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_527EDB257597D3FE ON task (member_id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB257597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('CREATE POLICY member_policy_member_user ON member TO member USING (username = current_user)');
        $this->addSql('GRANT ALL ON TABLE member TO member');
        $this->addSql('ALTER TABLE member ENABLE ROW LEVEL SECURITY');

        $this->addSql('CREATE POLICY task_policy_member_user ON task TO member USING (member_id IN (SELECT id FROM member WHERE username = current_user))');
        $this->addSql('GRANT ALL ON TABLE task TO member');
        $this->addSql('ALTER TABLE task ENABLE ROW LEVEL SECURITY');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE member_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE task_id_seq CASCADE');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB257597D3FE');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE task');
    }
}
