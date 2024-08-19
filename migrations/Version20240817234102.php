<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240817234102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employee_position (employee_id INT NOT NULL, position_id INT NOT NULL, INDEX IDX_D613B5328C03F15C (employee_id), INDEX IDX_D613B532DD842E46 (position_id), PRIMARY KEY(employee_id, position_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employee_position ADD CONSTRAINT FK_D613B5328C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employee_position ADD CONSTRAINT FK_D613B532DD842E46 FOREIGN KEY (position_id) REFERENCES position (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A17813DDAE');
        $this->addSql('DROP INDEX IDX_5D9F75A17813DDAE ON employee');
        $this->addSql('ALTER TABLE employee DROP positions_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee_position DROP FOREIGN KEY FK_D613B5328C03F15C');
        $this->addSql('ALTER TABLE employee_position DROP FOREIGN KEY FK_D613B532DD842E46');
        $this->addSql('DROP TABLE employee_position');
        $this->addSql('ALTER TABLE employee ADD positions_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A17813DDAE FOREIGN KEY (positions_id) REFERENCES position (id)');
        $this->addSql('CREATE INDEX IDX_5D9F75A17813DDAE ON employee (positions_id)');
    }
}
