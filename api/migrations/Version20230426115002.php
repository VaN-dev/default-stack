<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426115002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_teams_roles (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, team_id INT DEFAULT NULL, role_id INT DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_B5B5EA98A76ED395 (user_id), INDEX IDX_B5B5EA98296CD8AE (team_id), INDEX IDX_B5B5EA98D60322AC (role_id), UNIQUE INDEX user_team_role_uuid_idx (uuid), UNIQUE INDEX user_team_role_uniqueness_idx (user_id, team_id, role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_teams_roles ADD CONSTRAINT FK_B5B5EA98A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_teams_roles ADD CONSTRAINT FK_B5B5EA98296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_teams_roles ADD CONSTRAINT FK_B5B5EA98D60322AC FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_teams_roles DROP FOREIGN KEY FK_B5B5EA98A76ED395');
        $this->addSql('ALTER TABLE users_teams_roles DROP FOREIGN KEY FK_B5B5EA98296CD8AE');
        $this->addSql('ALTER TABLE users_teams_roles DROP FOREIGN KEY FK_B5B5EA98D60322AC');
        $this->addSql('DROP TABLE users_teams_roles');
    }
}
