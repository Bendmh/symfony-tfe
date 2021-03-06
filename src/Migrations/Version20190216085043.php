<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190216085043 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questions CHANGE bonne_reponse2 bonne_reponse2 VARCHAR(255) DEFAULT NULL, CHANGE bonne_reponse3 bonne_reponse3 VARCHAR(255) DEFAULT NULL, CHANGE mauvaise_reponse2 mauvaise_reponse2 VARCHAR(255) DEFAULT NULL, CHANGE mauvaise_reponse3 mauvaise_reponse3 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questions CHANGE bonne_reponse2 bonne_reponse2 VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE bonne_reponse3 bonne_reponse3 VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE mauvaise_reponse2 mauvaise_reponse2 VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE mauvaise_reponse3 mauvaise_reponse3 VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
