<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201006151002 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE solicitacao ADD solicitado_id INT NOT NULL');
        $this->addSql('ALTER TABLE solicitacao ADD CONSTRAINT FK_A84F9E16C2828A38 FOREIGN KEY (solicitado_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A84F9E16C2828A38 ON solicitacao (solicitado_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE solicitacao DROP FOREIGN KEY FK_A84F9E16C2828A38');
        $this->addSql('DROP INDEX IDX_A84F9E16C2828A38 ON solicitacao');
        $this->addSql('ALTER TABLE solicitacao DROP solicitado_id');
    }
}
