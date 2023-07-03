<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230703085156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pokemon (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, evolution INT NOT NULL, starter INT NOT NULL, type_courbe_niveau VARCHAR(255) NOT NULL, type_2 INT DEFAULT NULL, type_1 INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ref_pokemon_type DROP FOREIGN KEY FK_5483EF99564D586');
        $this->addSql('ALTER TABLE ref_pokemon_type DROP FOREIGN KEY FK_5483EF999C6D843C');
        $this->addSql('DROP TABLE ref_elementary_type');
        $this->addSql('DROP TABLE ref_pokemon_type');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ref_elementary_type (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ref_pokemon_type (id INT NOT NULL, type_1 INT DEFAULT NULL, type_2 INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, evolution TINYINT(1) NOT NULL, starter TINYINT(1) NOT NULL, type_courbe_niveau CHAR(1) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_5483EF99564D586 (type_2), INDEX IDX_5483EF999C6D843C (type_1), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ref_pokemon_type ADD CONSTRAINT FK_5483EF99564D586 FOREIGN KEY (type_2) REFERENCES ref_elementary_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE ref_pokemon_type ADD CONSTRAINT FK_5483EF999C6D843C FOREIGN KEY (type_1) REFERENCES ref_elementary_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE pokemon');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
