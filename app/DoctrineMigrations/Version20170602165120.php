<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170602165120 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE acometidas (id_res_acometidas INT AUTO_INCREMENT NOT NULL, sector INT DEFAULT NULL, acom_exist INT NOT NULL, cub_micro NUMERIC(3, 2) NOT NULL, serv_continuo NUMERIC(3, 2) NOT NULL, por_activa NUMERIC(3, 2) NOT NULL, mes INT NOT NULL, anio INT NOT NULL, INDEX sector (sector), PRIMARY KEY(id_res_acometidas)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color_indicador (id_indicador INT AUTO_INCREMENT NOT NULL, valor_verde NUMERIC(10, 2) DEFAULT NULL, valor_amarillo NUMERIC(10, 2) DEFAULT NULL, valor_anaranjado NUMERIC(10, 2) DEFAULT NULL, ascen_bueno TINYINT(1) DEFAULT NULL, nom_indicador VARCHAR(75) NOT NULL, PRIMARY KEY(id_indicador)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consumos_mayores (id_reg INT AUTO_INCREMENT NOT NULL, sector INT DEFAULT NULL, nombre_cliente VARCHAR(350) NOT NULL, direccion VARCHAR(500) NOT NULL, consumo NUMERIC(10, 2) NOT NULL, mes INT NOT NULL, anio INT NOT NULL, tipo_acometida INT NOT NULL, INDEX sector (sector), PRIMARY KEY(id_reg)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE otros_costos (id_reg_otros_costos INT AUTO_INCREMENT NOT NULL, total NUMERIC(18, 2) NOT NULL, mes INT NOT NULL, anio INT NOT NULL, PRIMARY KEY(id_reg_otros_costos)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE perfiles (id_perfil INT AUTO_INCREMENT NOT NULL, nombre_perfil VARCHAR(75) NOT NULL, PRIMARY KEY(id_perfil)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pozos (id_pozo INT AUTO_INCREMENT NOT NULL, ubicacion VARCHAR(500) NOT NULL, PRIMARY KEY(id_pozo)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rec_password (id_rec_password INT AUTO_INCREMENT NOT NULL, usuario VARCHAR(150) DEFAULT NULL, fecha_registro DATE NOT NULL, estado INT NOT NULL, ram_link VARCHAR(75) NOT NULL, INDEX usuario (usuario), PRIMARY KEY(id_rec_password)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE res_facturacion (id_res_micromedicion INT NOT NULL, monto_recaudado NUMERIC(18, 2) NOT NULL, PRIMARY KEY(id_res_micromedicion)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE res_macromedicion (id_res_macromedicion INT AUTO_INCREMENT NOT NULL, pozo INT DEFAULT NULL, total_extraido NUMERIC(18, 2) NOT NULL, consumo_energia NUMERIC(18, 2) NOT NULL, costo_energia NUMERIC(10, 2) NOT NULL, mes INT NOT NULL, anio INT NOT NULL, INDEX pozo (pozo), PRIMARY KEY(id_res_macromedicion)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE res_micromediciones (id_res_micromedicion INT AUTO_INCREMENT NOT NULL, tarifa INT DEFAULT NULL, sector INT DEFAULT NULL, mes INT NOT NULL, anio INT NOT NULL, tipo_acometida INT NOT NULL, total_consumo NUMERIC(18, 2) NOT NULL, monto_facturado NUMERIC(18, 2) NOT NULL, INDEX sector (sector), INDEX tarifa (tarifa), PRIMARY KEY(id_res_micromedicion)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE res_problemas (id_reg_problemas INT AUTO_INCREMENT NOT NULL, sector INT DEFAULT NULL, cant_rebalses INT NOT NULL, cant_con_ilegal INT NOT NULL, cant_rotura INT NOT NULL, mes INT NOT NULL, anio INT NOT NULL, INDEX sector (sector), PRIMARY KEY(id_reg_problemas)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE res_reclamos (id_res_reclamos INT AUTO_INCREMENT NOT NULL, tipo_reclamo INT DEFAULT NULL, prom_atencion INT NOT NULL, cantidad INT NOT NULL, mes INT NOT NULL, anio INT NOT NULL, INDEX tipo_reclamo (tipo_reclamo), PRIMARY KEY(id_res_reclamos)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sectores (id_sector INT AUTO_INCREMENT NOT NULL, nombre_sector VARCHAR(75) NOT NULL, PRIMARY KEY(id_sector)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suministros (sector INT NOT NULL, pozo INT NOT NULL, INDEX IDX_ACEE398F4BA3D9E8 (sector), INDEX IDX_ACEE398F12D1E28 (pozo), PRIMARY KEY(sector, pozo)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tarifas (id_tarifa INT AUTO_INCREMENT NOT NULL, nivel INT NOT NULL, consumo_min NUMERIC(7, 2) NOT NULL, consumo_max NUMERIC(7, 2) NOT NULL, cobro NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id_tarifa)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_reclamos (id_tipo_reclamo INT AUTO_INCREMENT NOT NULL, tiempo_atencion TIME NOT NULL, descripcion VARCHAR(250) NOT NULL, PRIMARY KEY(id_tipo_reclamo)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuarios (correo VARCHAR(150) NOT NULL, perfil INT DEFAULT NULL, nombre_completo VARCHAR(350) NOT NULL, password VARCHAR(60) NOT NULL, estado INT NOT NULL, INDEX perfil (perfil), PRIMARY KEY(correo)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acometidas ADD CONSTRAINT FK_B39A5C984BA3D9E8 FOREIGN KEY (sector) REFERENCES sectores (id_sector)');
        $this->addSql('ALTER TABLE consumos_mayores ADD CONSTRAINT FK_D02CC58A4BA3D9E8 FOREIGN KEY (sector) REFERENCES sectores (id_sector)');
        $this->addSql('ALTER TABLE rec_password ADD CONSTRAINT FK_55FC4B162265B05D FOREIGN KEY (usuario) REFERENCES usuarios (correo)');
        $this->addSql('ALTER TABLE res_facturacion ADD CONSTRAINT FK_8904D3595A5F424C FOREIGN KEY (id_res_micromedicion) REFERENCES res_micromediciones (id_res_micromedicion)');
        $this->addSql('ALTER TABLE res_macromedicion ADD CONSTRAINT FK_AD645CA512D1E28 FOREIGN KEY (pozo) REFERENCES pozos (id_pozo)');
        $this->addSql('ALTER TABLE res_micromediciones ADD CONSTRAINT FK_12AB4BBAA01B5DE FOREIGN KEY (tarifa) REFERENCES tarifas (id_tarifa)');
        $this->addSql('ALTER TABLE res_micromediciones ADD CONSTRAINT FK_12AB4BBA4BA3D9E8 FOREIGN KEY (sector) REFERENCES sectores (id_sector)');
        $this->addSql('ALTER TABLE res_problemas ADD CONSTRAINT FK_C93905694BA3D9E8 FOREIGN KEY (sector) REFERENCES sectores (id_sector)');
        $this->addSql('ALTER TABLE res_reclamos ADD CONSTRAINT FK_2F17DEAE46722C27 FOREIGN KEY (tipo_reclamo) REFERENCES tipo_reclamos (id_tipo_reclamo)');
        $this->addSql('ALTER TABLE suministros ADD CONSTRAINT FK_ACEE398F4BA3D9E8 FOREIGN KEY (sector) REFERENCES sectores (id_sector)');
        $this->addSql('ALTER TABLE suministros ADD CONSTRAINT FK_ACEE398F12D1E28 FOREIGN KEY (pozo) REFERENCES pozos (id_pozo)');
        $this->addSql('ALTER TABLE usuarios ADD CONSTRAINT FK_EF687F296657647 FOREIGN KEY (perfil) REFERENCES perfiles (id_perfil)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE usuarios DROP FOREIGN KEY FK_EF687F296657647');
        $this->addSql('ALTER TABLE res_macromedicion DROP FOREIGN KEY FK_AD645CA512D1E28');
        $this->addSql('ALTER TABLE suministros DROP FOREIGN KEY FK_ACEE398F12D1E28');
        $this->addSql('ALTER TABLE res_facturacion DROP FOREIGN KEY FK_8904D3595A5F424C');
        $this->addSql('ALTER TABLE acometidas DROP FOREIGN KEY FK_B39A5C984BA3D9E8');
        $this->addSql('ALTER TABLE consumos_mayores DROP FOREIGN KEY FK_D02CC58A4BA3D9E8');
        $this->addSql('ALTER TABLE res_micromediciones DROP FOREIGN KEY FK_12AB4BBA4BA3D9E8');
        $this->addSql('ALTER TABLE res_problemas DROP FOREIGN KEY FK_C93905694BA3D9E8');
        $this->addSql('ALTER TABLE suministros DROP FOREIGN KEY FK_ACEE398F4BA3D9E8');
        $this->addSql('ALTER TABLE res_micromediciones DROP FOREIGN KEY FK_12AB4BBAA01B5DE');
        $this->addSql('ALTER TABLE res_reclamos DROP FOREIGN KEY FK_2F17DEAE46722C27');
        $this->addSql('ALTER TABLE rec_password DROP FOREIGN KEY FK_55FC4B162265B05D');
        $this->addSql('DROP TABLE acometidas');
        $this->addSql('DROP TABLE color_indicador');
        $this->addSql('DROP TABLE consumos_mayores');
        $this->addSql('DROP TABLE otros_costos');
        $this->addSql('DROP TABLE perfiles');
        $this->addSql('DROP TABLE pozos');
        $this->addSql('DROP TABLE rec_password');
        $this->addSql('DROP TABLE res_facturacion');
        $this->addSql('DROP TABLE res_macromedicion');
        $this->addSql('DROP TABLE res_micromediciones');
        $this->addSql('DROP TABLE res_problemas');
        $this->addSql('DROP TABLE res_reclamos');
        $this->addSql('DROP TABLE sectores');
        $this->addSql('DROP TABLE suministros');
        $this->addSql('DROP TABLE tarifas');
        $this->addSql('DROP TABLE tipo_reclamos');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE usuarios');
    }
}
