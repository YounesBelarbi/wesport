<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200225140205 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE favorite_sport (user_id INT NOT NULL, sport_id INT NOT NULL, level_id INT DEFAULT NULL, INDEX IDX_AC0DC4F6A76ED395 (user_id), INDEX IDX_AC0DC4F6AC78BCF8 (sport_id), INDEX IDX_AC0DC4F65FB14BA7 (level_id), PRIMARY KEY(user_id, sport_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classified_ad (id INT AUTO_INCREMENT NOT NULL, seller_id INT NOT NULL, classified_ad_body LONGTEXT NOT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, sport_concerned VARCHAR(255) NOT NULL, object_for_sale VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_6869CB768DE820D9 (seller_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, age INT DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, reset_token VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_event (user_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_D96CF1FFA76ED395 (user_id), INDEX IDX_D96CF1FF71F7E88B (event_id), PRIMARY KEY(user_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_contact_list (user_id INT NOT NULL, contact_list_id INT NOT NULL, INDEX IDX_ECFB06E5A76ED395 (user_id), INDEX IDX_ECFB06E5A781370A (contact_list_id), PRIMARY KEY(user_id, contact_list_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, event_organizer_id INT NOT NULL, event_body LONGTEXT NOT NULL, author VARCHAR(255) NOT NULL, sport_concerned VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, event_date DATE NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_3BAE0AA76A7F4729 (event_organizer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level_sport (level_id INT NOT NULL, sport_id INT NOT NULL, INDEX IDX_705CEADB5FB14BA7 (level_id), INDEX IDX_705CEADBAC78BCF8 (sport_id), PRIMARY KEY(level_id, sport_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_list (id INT AUTO_INCREMENT NOT NULL, creator_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_6C377AE761220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favorite_sport ADD CONSTRAINT FK_AC0DC4F6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorite_sport ADD CONSTRAINT FK_AC0DC4F6AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE favorite_sport ADD CONSTRAINT FK_AC0DC4F65FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE classified_ad ADD CONSTRAINT FK_6869CB768DE820D9 FOREIGN KEY (seller_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FF71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_contact_list ADD CONSTRAINT FK_ECFB06E5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_contact_list ADD CONSTRAINT FK_ECFB06E5A781370A FOREIGN KEY (contact_list_id) REFERENCES contact_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA76A7F4729 FOREIGN KEY (event_organizer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE level_sport ADD CONSTRAINT FK_705CEADB5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE level_sport ADD CONSTRAINT FK_705CEADBAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contact_list ADD CONSTRAINT FK_6C377AE761220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE favorite_sport DROP FOREIGN KEY FK_AC0DC4F6A76ED395');
        $this->addSql('ALTER TABLE classified_ad DROP FOREIGN KEY FK_6869CB768DE820D9');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FFA76ED395');
        $this->addSql('ALTER TABLE user_contact_list DROP FOREIGN KEY FK_ECFB06E5A76ED395');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA76A7F4729');
        $this->addSql('ALTER TABLE contact_list DROP FOREIGN KEY FK_6C377AE761220EA6');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FF71F7E88B');
        $this->addSql('ALTER TABLE favorite_sport DROP FOREIGN KEY FK_AC0DC4F65FB14BA7');
        $this->addSql('ALTER TABLE level_sport DROP FOREIGN KEY FK_705CEADB5FB14BA7');
        $this->addSql('ALTER TABLE user_contact_list DROP FOREIGN KEY FK_ECFB06E5A781370A');
        $this->addSql('ALTER TABLE favorite_sport DROP FOREIGN KEY FK_AC0DC4F6AC78BCF8');
        $this->addSql('ALTER TABLE level_sport DROP FOREIGN KEY FK_705CEADBAC78BCF8');
        $this->addSql('DROP TABLE favorite_sport');
        $this->addSql('DROP TABLE classified_ad');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_event');
        $this->addSql('DROP TABLE user_contact_list');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE level_sport');
        $this->addSql('DROP TABLE contact_list');
        $this->addSql('DROP TABLE sport');
    }
}
