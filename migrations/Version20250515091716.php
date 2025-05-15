<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250515091716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create performed_jobs table for tracking executed jobs';
    }

    public function up(Schema $schema): void
    {
        // Enable UUID generation extension if needed
        $this->addSql("CREATE EXTENSION IF NOT EXISTS pgcrypto");

        // Create table with UUID primary key
        $this->addSql(
            "CREATE TABLE performed_jobs (
                id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
                job_name VARCHAR(255) NOT NULL,
                ran_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                status_code INT,
                duration_ms INT NOT NULL,
                success BOOLEAN NOT NULL,
                message TEXT
            )"
        );

        $this->addSql("CREATE INDEX idx_performed_jobs_ran_at ON performed_jobs (ran_at)");
        $this->addSql("CREATE INDEX idx_performed_jobs_job_name ON performed_jobs (job_name)");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE performed_jobs");
    }
}
