<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240626140134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE reservation_id_seq CASCADE');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT fk_42c84955549213ec');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT fk_42c84955ccfa12b8');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('ALTER TABLE property ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE property DROP description');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8BF21CDE3DA5256D ON property (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE reservation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE reservation (id INT NOT NULL, property_id INT DEFAULT NULL, profile_id INT NOT NULL, book_start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, book_end TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_42c84955ccfa12b8 ON reservation (profile_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_42c84955549213ec ON reservation (property_id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT fk_42c84955549213ec FOREIGN KEY (property_id) REFERENCES property (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT fk_42c84955ccfa12b8 FOREIGN KEY (profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE property DROP CONSTRAINT FK_8BF21CDE3DA5256D');
        $this->addSql('DROP INDEX UNIQ_8BF21CDE3DA5256D');
        $this->addSql('ALTER TABLE property ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE property DROP image_id');
    }
}
