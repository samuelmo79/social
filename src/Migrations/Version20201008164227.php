<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201008164227 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amizade (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, amigo_id INT NOT NULL, INDEX IDX_E13B4B0CDB38439E (usuario_id), INDEX IDX_E13B4B0C6DAE5CD1 (amigo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amizade_solicitacao (amizade_id INT NOT NULL, solicitacao_id INT NOT NULL, INDEX IDX_BBCF13A5CDDD435F (amizade_id), INDEX IDX_BBCF13A5774BE1CF (solicitacao_id), PRIMARY KEY(amizade_id, solicitacao_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amizade ADD CONSTRAINT FK_E13B4B0CDB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE amizade ADD CONSTRAINT FK_E13B4B0C6DAE5CD1 FOREIGN KEY (amigo_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE amizade_solicitacao ADD CONSTRAINT FK_BBCF13A5CDDD435F FOREIGN KEY (amizade_id) REFERENCES amizade (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amizade_solicitacao ADD CONSTRAINT FK_BBCF13A5774BE1CF FOREIGN KEY (solicitacao_id) REFERENCES solicitacao (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amizade_solicitacao DROP FOREIGN KEY FK_BBCF13A5CDDD435F');
        $this->addSql('DROP TABLE amizade');
        $this->addSql('DROP TABLE amizade_solicitacao');
    }
}
