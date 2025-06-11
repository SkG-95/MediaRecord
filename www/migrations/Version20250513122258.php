<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250513122258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, adult TINYINT(1) NOT NULL, backdrop_path VARCHAR(255) DEFAULT NULL, genre_ids JSON NOT NULL, tmdb_id INT NOT NULL, original_language VARCHAR(10) NOT NULL, original_title VARCHAR(255) NOT NULL, overview LONGTEXT NOT NULL, popularity DOUBLE PRECISION NOT NULL, poster_path VARCHAR(255) DEFAULT NULL, release_date DATE NOT NULL, title VARCHAR(255) NOT NULL, video TINYINT(1) NOT NULL, vote_average DOUBLE PRECISION NOT NULL, vote_count INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE media
        SQL);
    }
}
