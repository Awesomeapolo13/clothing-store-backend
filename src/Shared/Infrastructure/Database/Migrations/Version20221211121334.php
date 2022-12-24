<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221211121334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the refresh_token table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE refresh_token_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE refresh_token (
                            id INT NOT NULL,
                            refresh_token VARCHAR(128) NOT NULL,
                            username VARCHAR(255) NOT NULL,
                            valid TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                            PRIMARY KEY(id)
                           )'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C74F2195C74F2195 ON refresh_token (refresh_token)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_421A9847E7927C74 ON users_user (email)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE refresh_token_id_seq CASCADE');
        $this->addSql('DROP TABLE refresh_token');
        $this->addSql('DROP INDEX UNIQ_421A9847E7927C74');
    }
}
