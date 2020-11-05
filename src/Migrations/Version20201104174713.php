<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201104174713 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E41DC9B2');
        $this->addSql('CREATE TABLE foto (id INT AUTO_INCREMENT NOT NULL, album_id INT DEFAULT NULL, foto VARCHAR(255) NOT NULL, INDEX IDX_EADC3BE51137ABCF (album_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album_foto (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nome VARCHAR(100) NOT NULL, data_criacao DATETIME NOT NULL, data_atualizacao DATETIME DEFAULT NULL, INDEX IDX_8ED78DA5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE foto ADD CONSTRAINT FK_EADC3BE51137ABCF FOREIGN KEY (album_id) REFERENCES album_foto (id)');
        $this->addSql('ALTER TABLE album_foto ADD CONSTRAINT FK_8ED78DA5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE curtida_comentario');
        $this->addSql('DROP TABLE design');
        $this->addSql('DROP INDEX IDX_8D93D649E41DC9B2 ON user');
        $this->addSql('ALTER TABLE user DROP design_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE foto DROP FOREIGN KEY FK_EADC3BE51137ABCF');
        $this->addSql('CREATE TABLE curtida_comentario (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, comentario_id INT NOT NULL, INDEX IDX_32C19765DB38439E (usuario_id), INDEX IDX_32C19765F3F2D7EC (comentario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE design (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, body VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, navbar VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, bg VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, btn VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, card VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE curtida_comentario ADD CONSTRAINT FK_32C19765DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE curtida_comentario ADD CONSTRAINT FK_32C19765F3F2D7EC FOREIGN KEY (comentario_id) REFERENCES post_comentario (id)');
        $this->addSql('DROP TABLE foto');
        $this->addSql('DROP TABLE album_foto');
        $this->addSql('ALTER TABLE user ADD design_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E41DC9B2 FOREIGN KEY (design_id) REFERENCES design (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649E41DC9B2 ON user (design_id)');
    }
}
