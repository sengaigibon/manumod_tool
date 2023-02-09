<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209104126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE modelsRelations (id INT AUTO_INCREMENT NOT NULL, manufacturerName VARCHAR(100) NOT NULL, parentName VARCHAR(100) NOT NULL, modelName VARCHAR(100) NOT NULL, parentId INT NOT NULL, childId INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE parentModels');
        $this->addSql('DROP INDEX AuditLog_id_uindex ON AuditLog');
        $this->addSql('ALTER TABLE AuditLog CHANGE entityType entityType VARCHAR(255) NOT NULL, CHANGE entityId entityId INT NOT NULL, CHANGE createdAt createdAt DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE userId userId INT NOT NULL, CHANGE action action VARCHAR(255) NOT NULL, CHANGE eventData eventData JSON NOT NULL, CHANGE ipAddress ipAddress VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE AuditLog ADD CONSTRAINT FK_956C7A1A64B64DCC FOREIGN KEY (userId) REFERENCES Users (id)');
        $this->addSql('CREATE INDEX IDX_956C7A1A64B64DCC ON AuditLog (userId)');
        $this->addSql('ALTER TABLE Users CHANGE userRole userRole VARCHAR(50) NOT NULL, CHANGE token token LONGTEXT NOT NULL, CHANGE lastLogin lastLogin VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE Users RENAME INDEX users_email_uindex TO UNIQ_D5428AEDE7927C74');
        $this->addSql('ALTER TABLE mdx_countries DROP description, DROP iso3, DROP numcode, DROP name_it, DROP name_fr, DROP name_nl, DROP active, DROP name_at, DROP name_es, DROP name_tr, DROP name_ru, DROP name_pl, DROP name_nlbe, DROP name_frbe, DROP translationId, DROP countrySymbol, DROP name_pt, DROP name_nb, DROP name_sv, DROP name_enus, DROP name_zh, DROP name_da, DROP name_enie, DROP name_dech, DROP name_frch, DROP name_itch, DROP name_enca, DROP name_frca, DROP name_ja, DROP name_debe, DROP name_cs, DROP name_hu, DROP name_et, DROP name_lv, DROP name_lt, DROP name_th, DROP name_enau, DROP name_ko, DROP name_ptbr, DROP name_zhtw, DROP name_az, DROP name_vi, DROP name_id, DROP name_bg, DROP name_uk, DROP name_el, DROP name_enmy, DROP name_esmx, DROP name_sk, CHANGE iso iso VARCHAR(2) NOT NULL, CHANGE name_en name_en VARCHAR(80) NOT NULL, CHANGE name name VARCHAR(80) NOT NULL');
        $this->addSql('ALTER TABLE mdx_i18n_languages DROP name_fr, DROP name_pl, DROP name_fi, DROP name_tr, DROP name_ru, DROP name_es, DROP name_it, DROP name_hu, DROP name_at, DROP db_abbr, DROP db_sql_i18n, DROP lc_locale, DROP lc_charset, DROP name_nl, DROP name_nlbe, DROP name_frbe, DROP name_pt, DROP name_nb, DROP name_sv, DROP name_enus, DROP name_zh, DROP name_da, DROP name_enie, DROP name_dech, DROP name_frch, DROP name_itch, DROP name_enca, DROP name_frca, DROP name_ja, DROP name_debe, DROP name_cs, DROP name_et, DROP name_lv, DROP name_lt, DROP name_th, DROP name_enau, DROP name_ko, DROP name_ptbr, DROP name_zhtw, DROP name_az, DROP name_vi, DROP name_id, DROP name_bg, DROP name_uk, DROP name_el, DROP name_enmy, DROP name_esmx, DROP name_sk, CHANGE name name VARCHAR(64) NOT NULL, CHANGE name_en name_en VARCHAR(64) NOT NULL');
        $this->addSql('ALTER TABLE mdx_kfz_herst CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE name name VARCHAR(200) NOT NULL, CHANGE mobiliti mobiliti INT NOT NULL, CHANGE audi audi VARCHAR(2) DEFAULT NULL, CHANGE mg mg INT NOT NULL, CHANGE msh msh INT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX `primary` ON mdx_kfz_model_parent');
        $this->addSql('ALTER TABLE mdx_kfz_model_parent ADD PRIMARY KEY (modelId)');
        $this->addSql('DROP INDEX name ON mdx_kfz_models');
        $this->addSql('ALTER TABLE mdx_kfz_models CHANGE herst herst INT DEFAULT NULL, CHANGE name name VARCHAR(100) NOT NULL, CHANGE ident_code ident_code VARCHAR(80) NOT NULL');
        $this->addSql('ALTER TABLE mdx_kfz_models RENAME INDEX herst TO IDX_56B16A906797EF8E');
        $this->addSql('DROP INDEX mdx_kfz_models_i18n_pk ON mdx_kfz_models_i18n');
        $this->addSql('ALTER TABLE mdx_kfz_models_i18n CHANGE modelId modelid INT NOT NULL, CHANGE countryId countryid INT DEFAULT NULL, CHANGE languageId languageid INT DEFAULT NULL, CHANGE name name VARCHAR(80) NOT NULL, CHANGE ident_code ident_code VARCHAR(80) NOT NULL, ADD PRIMARY KEY (modelid)');
        $this->addSql('ALTER TABLE mdx_kfz_models_i18n RENAME INDEX countryid TO IDX_F93360F6E268216');
        $this->addSql('ALTER TABLE mdx_kfz_models_i18n RENAME INDEX languageid TO IDX_F93360F189A8DC');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parentModels (parentId INT NOT NULL, modelId INT NOT NULL) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE modelsRelations');
        $this->addSql('ALTER TABLE AuditLog DROP FOREIGN KEY FK_956C7A1A64B64DCC');
        $this->addSql('DROP INDEX IDX_956C7A1A64B64DCC ON AuditLog');
        $this->addSql('ALTER TABLE AuditLog CHANGE entityType entityType VARCHAR(255) DEFAULT NULL, CHANGE entityId entityId INT DEFAULT NULL, CHANGE createdAt createdAt DATETIME DEFAULT NULL, CHANGE userId userId INT DEFAULT NULL, CHANGE action action VARCHAR(255) DEFAULT NULL, CHANGE eventData eventData JSON DEFAULT NULL, CHANGE ipAddress ipAddress VARCHAR(200) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX AuditLog_id_uindex ON AuditLog (id)');
        $this->addSql('ALTER TABLE Users CHANGE userRole userRole VARCHAR(100) DEFAULT NULL, CHANGE token token TEXT DEFAULT NULL, CHANGE lastLogin lastLogin DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Users RENAME INDEX uniq_d5428aede7927c74 TO Users_email_uindex');
        $this->addSql('ALTER TABLE mdx_countries ADD description VARCHAR(80) DEFAULT \'\' NOT NULL, ADD iso3 CHAR(3) DEFAULT NULL, ADD numcode SMALLINT DEFAULT NULL, ADD name_it VARCHAR(80) DEFAULT \'\' NOT NULL, ADD name_fr VARCHAR(80) NOT NULL, ADD name_nl VARCHAR(80) NOT NULL, ADD active VARCHAR(2) DEFAULT \'N\' NOT NULL COMMENT \'Defines if this country is "in use"\', ADD name_at VARCHAR(80) NOT NULL, ADD name_es VARCHAR(80) NOT NULL, ADD name_tr VARCHAR(80) NOT NULL, ADD name_ru VARCHAR(80) NOT NULL, ADD name_pl VARCHAR(80) NOT NULL, ADD name_nlbe VARCHAR(80) DEFAULT NULL, ADD name_frbe VARCHAR(80) DEFAULT NULL, ADD translationId INT DEFAULT NULL, ADD countrySymbol VARCHAR(5) NOT NULL, ADD name_pt VARCHAR(80) DEFAULT NULL, ADD name_nb VARCHAR(80) DEFAULT NULL, ADD name_sv VARCHAR(80) DEFAULT NULL, ADD name_enus VARCHAR(80) DEFAULT NULL, ADD name_zh VARCHAR(80) DEFAULT NULL, ADD name_da VARCHAR(80) DEFAULT NULL, ADD name_enie VARCHAR(80) DEFAULT NULL, ADD name_dech VARCHAR(80) DEFAULT NULL, ADD name_frch VARCHAR(80) DEFAULT NULL, ADD name_itch VARCHAR(80) DEFAULT NULL, ADD name_enca VARCHAR(80) DEFAULT NULL, ADD name_frca VARCHAR(80) DEFAULT NULL, ADD name_ja VARCHAR(80) DEFAULT NULL, ADD name_debe VARCHAR(80) DEFAULT NULL, ADD name_cs VARCHAR(80) DEFAULT NULL, ADD name_hu VARCHAR(80) DEFAULT NULL, ADD name_et VARCHAR(80) DEFAULT NULL, ADD name_lv VARCHAR(80) DEFAULT NULL, ADD name_lt VARCHAR(80) DEFAULT NULL, ADD name_th VARCHAR(80) DEFAULT NULL, ADD name_enau VARCHAR(80) DEFAULT NULL, ADD name_ko VARCHAR(80) DEFAULT NULL, ADD name_ptbr VARCHAR(80) DEFAULT NULL, ADD name_zhtw VARCHAR(80) DEFAULT NULL, ADD name_az VARCHAR(80) DEFAULT NULL, ADD name_vi VARCHAR(80) DEFAULT NULL, ADD name_id VARCHAR(80) DEFAULT NULL, ADD name_bg VARCHAR(80) DEFAULT NULL, ADD name_uk VARCHAR(80) DEFAULT NULL, ADD name_el VARCHAR(80) DEFAULT NULL, ADD name_enmy VARCHAR(80) DEFAULT NULL, ADD name_esmx VARCHAR(80) DEFAULT NULL, ADD name_sk VARCHAR(80) DEFAULT NULL, CHANGE iso iso CHAR(2) DEFAULT \'\' NOT NULL, CHANGE name_en name_en VARCHAR(80) DEFAULT \'\' NOT NULL, CHANGE name name VARCHAR(80) DEFAULT \'\' NOT NULL');
        $this->addSql('ALTER TABLE mdx_i18n_languages ADD name_fr VARCHAR(64) DEFAULT \'\' NOT NULL, ADD name_pl VARCHAR(64) DEFAULT \'\' NOT NULL, ADD name_fi VARCHAR(64) DEFAULT \'\' NOT NULL, ADD name_tr VARCHAR(64) DEFAULT \'\' NOT NULL, ADD name_ru VARCHAR(64) DEFAULT \'\' NOT NULL, ADD name_es VARCHAR(64) DEFAULT \'\' NOT NULL, ADD name_it VARCHAR(64) DEFAULT \'\' NOT NULL, ADD name_hu VARCHAR(64) DEFAULT \'\' NOT NULL, ADD name_at VARCHAR(64) NOT NULL, ADD db_abbr CHAR(2) DEFAULT \'\' NOT NULL, ADD db_sql_i18n VARCHAR(2) DEFAULT \'N\' NOT NULL, ADD lc_locale VARCHAR(10) DEFAULT \'\' NOT NULL, ADD lc_charset VARCHAR(16) DEFAULT \'\' NOT NULL, ADD name_nl VARCHAR(64) NOT NULL, ADD name_nlbe VARCHAR(64) DEFAULT NULL, ADD name_frbe VARCHAR(64) DEFAULT NULL, ADD name_pt VARCHAR(64) DEFAULT NULL, ADD name_nb VARCHAR(64) DEFAULT NULL, ADD name_sv VARCHAR(64) DEFAULT NULL, ADD name_enus VARCHAR(64) DEFAULT NULL, ADD name_zh VARCHAR(64) DEFAULT NULL, ADD name_da VARCHAR(64) DEFAULT NULL, ADD name_enie VARCHAR(64) DEFAULT NULL, ADD name_dech VARCHAR(64) DEFAULT NULL, ADD name_frch VARCHAR(64) DEFAULT NULL, ADD name_itch VARCHAR(64) DEFAULT NULL, ADD name_enca VARCHAR(64) DEFAULT NULL, ADD name_frca VARCHAR(64) DEFAULT NULL, ADD name_ja VARCHAR(64) DEFAULT NULL, ADD name_debe VARCHAR(64) DEFAULT NULL, ADD name_cs VARCHAR(64) DEFAULT NULL, ADD name_et VARCHAR(64) DEFAULT NULL, ADD name_lv VARCHAR(64) DEFAULT NULL, ADD name_lt VARCHAR(64) DEFAULT NULL, ADD name_th VARCHAR(64) DEFAULT NULL, ADD name_enau VARCHAR(64) DEFAULT NULL, ADD name_ko VARCHAR(64) DEFAULT NULL, ADD name_ptbr VARCHAR(64) DEFAULT NULL, ADD name_zhtw VARCHAR(64) DEFAULT NULL, ADD name_az VARCHAR(64) DEFAULT NULL, ADD name_vi VARCHAR(64) DEFAULT NULL, ADD name_id VARCHAR(64) DEFAULT NULL, ADD name_bg VARCHAR(64) DEFAULT NULL, ADD name_uk VARCHAR(64) DEFAULT NULL, ADD name_el VARCHAR(64) DEFAULT NULL, ADD name_enmy VARCHAR(64) DEFAULT NULL, ADD name_esmx VARCHAR(64) DEFAULT NULL, ADD name_sk VARCHAR(64) DEFAULT NULL, CHANGE name name VARCHAR(64) DEFAULT \'\' NOT NULL, CHANGE name_en name_en VARCHAR(64) DEFAULT \'\' NOT NULL');
        $this->addSql('ALTER TABLE mdx_kfz_herst MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON mdx_kfz_herst');
        $this->addSql('ALTER TABLE mdx_kfz_herst CHANGE id id INT NOT NULL, CHANGE name name VARCHAR(200) DEFAULT NULL, CHANGE mobiliti mobiliti INT DEFAULT 380 NOT NULL, CHANGE audi audi CHAR(2) DEFAULT NULL, CHANGE mg mg INT DEFAULT 0 NOT NULL, CHANGE msh msh INT DEFAULT 0 NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON mdx_kfz_model_parent');
        $this->addSql('ALTER TABLE mdx_kfz_model_parent ADD PRIMARY KEY (modelId, parentModelId)');
        $this->addSql('ALTER TABLE mdx_kfz_models DROP FOREIGN KEY FK_56B16A906797EF8E');
        $this->addSql('ALTER TABLE mdx_kfz_models DROP FOREIGN KEY FK_56B16A90BF396750');
        $this->addSql('ALTER TABLE mdx_kfz_models CHANGE herst herst INT NOT NULL, CHANGE name name VARCHAR(100) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, CHANGE ident_code ident_code VARCHAR(80) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`');
        $this->addSql('CREATE FULLTEXT INDEX name ON mdx_kfz_models (name)');
        $this->addSql('ALTER TABLE mdx_kfz_models RENAME INDEX idx_56b16a906797ef8e TO herst');
        $this->addSql('ALTER TABLE mdx_kfz_models_i18n DROP FOREIGN KEY FK_F93360F6E268216');
        $this->addSql('ALTER TABLE mdx_kfz_models_i18n DROP FOREIGN KEY FK_F93360F189A8DC');
        $this->addSql('DROP INDEX `primary` ON mdx_kfz_models_i18n');
        $this->addSql('ALTER TABLE mdx_kfz_models_i18n CHANGE modelid modelId INT NOT NULL COMMENT \'model id from mdx_kfz_model\', CHANGE countryid countryId INT NOT NULL COMMENT \'country id form mdxcnt.mdx_countries\', CHANGE languageid languageId INT NOT NULL, CHANGE name name CHAR(80) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci` COMMENT \'Internationalized Name\', CHANGE ident_code ident_code VARCHAR(80) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`');
        $this->addSql('CREATE UNIQUE INDEX mdx_kfz_models_i18n_pk ON mdx_kfz_models_i18n (modelId, countryId, languageId, ident_code)');
        $this->addSql('ALTER TABLE mdx_kfz_models_i18n RENAME INDEX idx_f93360f189a8dc TO languageId');
        $this->addSql('ALTER TABLE mdx_kfz_models_i18n RENAME INDEX idx_f93360f6e268216 TO countryId');
    }
}
