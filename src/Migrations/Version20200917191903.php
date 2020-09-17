<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200917191903 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE evento (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(100) NOT NULL, slug VARCHAR(255) NOT NULL, descricao LONGTEXT NOT NULL, data_evento DATETIME NOT NULL, acessos INT DEFAULT NULL, rua VARCHAR(100) NOT NULL, numero VARCHAR(10) NOT NULL, complemento VARCHAR(255) DEFAULT NULL, bairro VARCHAR(50) NOT NULL, estado VARCHAR(50) NOT NULL, cep VARCHAR(8) NOT NULL, imagem VARCHAR(255) DEFAULT NULL, data_cadastro DATETIME NOT NULL, data_atualizacao DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE evento');
    }
}
