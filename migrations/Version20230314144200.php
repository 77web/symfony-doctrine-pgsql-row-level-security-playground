<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230314144200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE ROLE member');
        $this->addSql('GRANT USAGE ON SCHEMA "public" TO "member"');
        $this->addSql('GRANT ALL ON ALL TABLES IN SCHEMA "public" TO "member"');
        $this->addSql('GRANT ALL ON ALL SEQUENCES IN SCHEMA "public" TO "member"');
    }

    public function down(Schema $schema): void
    {
        // do nothing
    }
}
