<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201106134342 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bloqueio (id INT AUTO_INCREMENT NOT NULL, usuario_bloqueador_id INT NOT NULL, usuario_bloqueado_id INT NOT NULL, INDEX IDX_FD25DF8CBF582C69 (usuario_bloqueador_id), INDEX IDX_FD25DF8C401F370A (usuario_bloqueado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bloqueio ADD CONSTRAINT FK_FD25DF8CBF582C69 FOREIGN KEY (usuario_bloqueador_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bloqueio ADD CONSTRAINT FK_FD25DF8C401F370A FOREIGN KEY (usuario_bloqueado_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE bloqueio');
    }
}
