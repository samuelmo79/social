<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201118133559 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE seguidor (id INT AUTO_INCREMENT NOT NULL, usuario_seguidor_id INT NOT NULL, usuario_seguido_id INT NOT NULL, INDEX IDX_EF2EC608110F1BEE (usuario_seguidor_id), INDEX IDX_EF2EC608C642FAE2 (usuario_seguido_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE seguidor ADD CONSTRAINT FK_EF2EC608110F1BEE FOREIGN KEY (usuario_seguidor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE seguidor ADD CONSTRAINT FK_EF2EC608C642FAE2 FOREIGN KEY (usuario_seguido_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE seguidor');
    }
}
