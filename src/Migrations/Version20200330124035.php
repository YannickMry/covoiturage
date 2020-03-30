<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200330124035 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lieu (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, longitude DOUBLE PRECISION NOT NULL, latitude DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet (id INT AUTO_INCREMENT NOT NULL, lieu_depart_id INT NOT NULL, lieu_arrivee_id INT NOT NULL, conducteur_id INT NOT NULL, date_depart DATETIME NOT NULL, places INT NOT NULL, INDEX IDX_2B5BA98CC16565FC (lieu_depart_id), INDEX IDX_2B5BA98CBF9A3FF6 (lieu_arrivee_id), INDEX IDX_2B5BA98CF16F4AC6 (conducteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet_user (trajet_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_825A9176D12A823 (trajet_id), INDEX IDX_825A9176A76ED395 (user_id), PRIMARY KEY(trajet_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CC16565FC FOREIGN KEY (lieu_depart_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CBF9A3FF6 FOREIGN KEY (lieu_arrivee_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CF16F4AC6 FOREIGN KEY (conducteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trajet_user ADD CONSTRAINT FK_825A9176D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trajet_user ADD CONSTRAINT FK_825A9176A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CC16565FC');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CBF9A3FF6');
        $this->addSql('ALTER TABLE trajet_user DROP FOREIGN KEY FK_825A9176D12A823');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CF16F4AC6');
        $this->addSql('ALTER TABLE trajet_user DROP FOREIGN KEY FK_825A9176A76ED395');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('DROP TABLE trajet_user');
        $this->addSql('DROP TABLE user');
    }
}
