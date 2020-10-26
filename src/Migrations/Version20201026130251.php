<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201026130251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE custida_post (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, postagem_id INT NOT NULL, INDEX IDX_A925CE76DB38439E (usuario_id), INDEX IDX_A925CE766DD36FEA (postagem_id), UNIQUE INDEX usuario_postagem (usuario_id, postagem_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE custida_post ADD CONSTRAINT FK_A925CE76DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE custida_post ADD CONSTRAINT FK_A925CE766DD36FEA FOREIGN KEY (postagem_id) REFERENCES post (id)');
        $this->addSql('DROP TABLE curtida_post');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE curtida_post (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, postagem_id INT NOT NULL, INDEX IDX_46E7A5486DD36FEA (postagem_id), INDEX IDX_46E7A548DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE curtida_post ADD CONSTRAINT FK_46E7A5486DD36FEA FOREIGN KEY (postagem_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE curtida_post ADD CONSTRAINT FK_46E7A548DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE custida_post');
    }
}
