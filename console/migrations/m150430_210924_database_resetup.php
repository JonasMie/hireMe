<?php

use yii\db\Schema;
use yii\db\Migration;

class m150430_210924_database_resetup extends Migration
{
    /**
     * public function up()
     * {
     *
     *
     * }
     *
     * public function down()
     * {
     * echo "m150430_210924_database_resetup cannot be reverted.\n";
     *
     * return false;
     * }
     */

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        //    -- Thu Apr 30 23:03:22 2015
        //    -- Model: New Model    Version: 1.0
        //    -- MySQL Workbench Forward Engineering


        $this->db->createCommand("SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;")->execute();
        $this->db->createCommand("SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;")->execute();
        $this->db->createCommand("SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';")->execute();

        //-- Schema hireMe
        //-- -----------------------------------------------------
        //    -- -----------------------------------------------------
        $this->db->createCommand("CREATE SCHEMA IF NOT EXISTS `hireMe` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
                USE `hireMe` ;")->execute();

        //-- -----------------------------------------------------
        //-- Table `hireMe`.`company`
        //    -- -----------------------------------------------------
        $this->db->createCommand("DROP TABLE IF EXISTS `hireMe`.`company` ;")->execute();

        $this->db->createCommand("CREATE TABLE IF NOT EXISTS `hireMe`.`company` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(255) NOT NULL,
              `street` VARCHAR(255) NOT NULL,
              `houseno` VARCHAR(255) NOT NULL,
              `zip` VARCHAR(10) NOT NULL,
              `city` VARCHAR(255) NOT NULL,
              `sector` TINYINT(3) UNSIGNED NOT NULL,
              `employeeAmount` TINYINT(3) UNSIGNED NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `name_UNIQUE` (`name` ASC))
              ENGINE = InnoDB;")->execute();

        //-- -----------------------------------------------------
        //-- Table `hireMe`.`users`
        //    -- -----------------------------------------------------
        $this->db->createCommand("DROP TABLE IF EXISTS `hireMe`.`user` ;

            CREATE TABLE IF NOT EXISTS `hireMe`.`user` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `firstName` VARCHAR(255) NOT NULL,
              `lastName` VARCHAR(255) NOT NULL,
              `auth_key` VARCHAR(32) NOT NULL,
              `password_hash` VARCHAR(45) NOT NULL,
              `password_reset_token` VARCHAR(255) NULL,
              `email` VARCHAR(255) NOT NULL,
              `status` SMALLINT(6) NULL DEFAULT 10,
              `is_recruiter` TINYINT(1) NULL DEFAULT 0,
              `company_id` INT(11) NULL,
              `created_at` INT(11) NOT NULL,
              `updated_at` INT(11) NOT NULL,
              `birthday` DATE NULL DEFAULT NULL,
              `applications_id` INT NOT NULL,
              `position` VARCHAR(45) NULL,
              PRIMARY KEY (`id`, `applications_id`),
              INDEX `user_company_rel_idx` (`company_id` ASC),
              CONSTRAINT `user_company_rel`
                FOREIGN KEY (`company_id`)
                REFERENCES `hireMe`.`company` (`id`)
                ON DELETE RESTRICT
                ON UPDATE NO ACTION)
              ENGINE = InnoDB;")->execute();

        //-- -----------------------------------------------------
        //-- Table `hireMe`.`job_ad`
        //            -- -----------------------------------------------------
        $this->db->createCommand("DROP TABLE IF EXISTS `hireMe`.`job_ad` ;

            CREATE TABLE IF NOT EXISTS `hireMe`.`job_ad` (
              `id` INT NOT NULL,
              `description` VARCHAR(255) NOT NULL,
              `job_begin` DATETIME NULL,
              `job_end` DATETIME NULL,
              `zip` VARCHAR(10) NOT NULL COMMENT 'Ort (PLZ) der Arbeitsstelle\n',
              `sector` TINYINT(3) NOT NULL,
              `contact_id` INT(11) NOT NULL,
              `company_id` INT(11) NOT NULL,
              `active` TINYINT(1) NOT NULL,
              `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` TIMESTAMP NULL DEFAULT NULL,
              PRIMARY KEY (`id`),
              INDEX `jobAd_company_ref_idx` (`company_id` ASC),
              INDEX `jobAd_recruiter_ref_idx` (`contact_id` ASC),
              CONSTRAINT `jobAd_recruiter_ref`
                FOREIGN KEY (`contact_id`)
                REFERENCES `hireMe`.`user` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `jobAd_company_ref`
                FOREIGN KEY (`company_id`)
                REFERENCES `hireMe`.`company` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
              ENGINE = InnoDB;")->execute();


        //-- -----------------------------------------------------
        //-- Table `hireMe`.`application`
        //            -- -----------------------------------------------------
        $this->db->createCommand("DROP TABLE IF EXISTS `hireMe`.`application` ;

            CREATE TABLE IF NOT EXISTS `hireMe`.`application` (
              `id` INT NOT NULL,
              `user_id` INT NOT NULL,
              `company_id` INT(11) NOT NULL,
              `jobAd_id` INT(11) NOT NULL,
              `score` INT NULL DEFAULT NULL,
              `state` ENUM('Gespeichert', 'Absage', 'Vorstellungsgespräch', 'Versendet') NOT NULL,
              `sent` TINYINT(1) NOT NULL DEFAULT 0,
              `read` TINYINT(1) NOT NULL DEFAULT 0,
              `archived` TINYINT(1) NOT NULL DEFAULT 0,
              `created_at` TIMESTAMP NOT NULL DEFAULT NOW(),"
              //`updated_at` TIMESTAMP NOT NULL DEFAULT 0 ON UPDATE NOW(),
              ."PRIMARY KEY (`id`),
              INDEX `user_rel_id` (`user_id` ASC),
              INDEX `application_company_rel_id` (`company_id` ASC),
              INDEX `application_ad_rel_id` (`jobAd_id` ASC),
              CONSTRAINT `application_user_rel`
                FOREIGN KEY (`user_id`)
                REFERENCES `hireMe`.`user` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `application_company_rel`
                FOREIGN KEY (`company_id`)
                REFERENCES `hireMe`.`company` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `application_ad_rel`
                FOREIGN KEY (`jobAd_id`)
                REFERENCES `hireMe`.`job_ad` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
              ENGINE = InnoDB;")->execute();


        //-- -----------------------------------------------------
        //-- Table `hireMe`.`application_data`
        //            -- -----------------------------------------------------
        $this->db->createCommand("DROP TABLE IF EXISTS `hireMe`.`application_data` ;

            CREATE TABLE IF NOT EXISTS `hireMe`.`application_data` (
              `id` INT NOT NULL,
              `application_id` INT NOT NULL,
              `file_id` VARCHAR(45) NOT NULL,
              `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              INDEX `application_data_rel_idx` (`application_id` ASC),
              CONSTRAINT `application_data_rel`
                FOREIGN KEY (`application_id`)
                REFERENCES `hireMe`.`application` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
              ENGINE = InnoDB;")->execute();


        //-- -----------------------------------------------------
        //-- Table `hireMe`.`saved_applications`
        //            -- -----------------------------------------------------
//        $this->db->createCommand("DROP TABLE IF EXISTS `hireMe`.`saved_applications` ;
//
//            CREATE TABLE IF NOT EXISTS `hireMe`.`saved_applications` (
//              `id` INT NOT NULL,
//              `application_id` INT NULL,
//              PRIMARY KEY (`id`),
//              INDEX `application_ref_idx` (`application_id` ASC),
//              CONSTRAINT `application_ref`
//                FOREIGN KEY (`application_id`)
//                REFERENCES `hireMe`.`application` (`id`)
//                ON DELETE NO ACTION
//                ON UPDATE NO ACTION)
//              ENGINE = InnoDB;")->execute();


        //-- -----------------------------------------------------
        //-- Table `hireMe`.`resume`
        //            -- -----------------------------------------------------
//        $this->db->createCommand("DROP TABLE IF EXISTS `hireMe`.`resume` ;
//
//            CREATE TABLE IF NOT EXISTS `hireMe`.`resume` (
//              `id` INT NOT NULL,
//              `user_id` INT NOT NULL,
//              `period_begin` DATE NOT NULL,
//              `period_end` DATE NOT NULL,
//              `period_head` VARCHAR(60) NOT NULL,
//              `period_body` VARCHAR(100) NOT NULL,
//              PRIMARY KEY (`id`, `user_id`),
//              INDEX `user_ref_idx` (`user_id` ASC),
//              CONSTRAINT `user_ref`
//                FOREIGN KEY (`user_id`)
//                REFERENCES `hireMe`.`user` (`id`)
//                ON DELETE NO ACTION
//                ON UPDATE NO ACTION)
//              ENGINE = InnoDB;")->execute();


        //-- -----------------------------------------------------
        //-- Table `hireMe`.`resume_skills`
        //            -- -----------------------------------------------------
//        $this->db->createCommand("DROP TABLE IF EXISTS `hireMe`.`resume_skills` ;
//
//            CREATE TABLE IF NOT EXISTS `hireMe`.`resume_skills` (
//              `id` INT NOT NULL,
//              `resume_id` INT NOT NULL,
//              `skill` VARCHAR(50) NOT NULL,
//              PRIMARY KEY (`id`, `resume_id`),
//              INDEX `resume_ref_idx` (`resume_id` ASC),
//              CONSTRAINT `resume_ref`
//                FOREIGN KEY (`resume_id`)
//                REFERENCES `hireMe`.`resume` (`id`)
//                ON DELETE NO ACTION
//                ON UPDATE NO ACTION)
//              ENGINE = InnoDB;")->execute();


        //-- -----------------------------------------------------
        //-- Table `hireMe`.`enclosures`
        //            -- -----------------------------------------------------
//        $this->db->createCommand("DROP TABLE IF EXISTS `hireMe`.`enclosures` ;
//
//            CREATE TABLE IF NOT EXISTS `hireMe`.`enclosures` (
//              `id` INT NOT NULL,
//              `user_id` INT NOT NULL,
//              `file_id` INT NOT NULL,
//              PRIMARY KEY (`id`, `user_id`, `file_id`),
//              INDEX `user_ref_idx` (`user_id` ASC),
//              CONSTRAINT `user_ref`
//                FOREIGN KEY (`user_id`)
//                REFERENCES `hireMe`.`user` (`id`)
//                ON DELETE NO ACTION
//                ON UPDATE NO ACTION)
//              ENGINE = InnoDB;")->execute();


        //-- -----------------------------------------------------
        //-- Table `hireMe`.`reports`
        //            -- -----------------------------------------------------
//        $this->db->createCommand("DROP TABLE IF EXISTS `hireMe`.`reports` ;
//
//            CREATE TABLE IF NOT EXISTS `hireMe`.`reports` (
//              `id` INT NOT NULL,
//              `user_id` INT NOT NULL,
//              `file_id` INT NOT NULL,
//              PRIMARY KEY (`id`, `user_id`, `file_id`),
//              INDEX `user_ref_idx` (`user_id` ASC),
//              CONSTRAINT `user_ref`
//                FOREIGN KEY (`user_id`)
//                REFERENCES `hireMe`.`user` (`id`)
//                ON DELETE NO ACTION
//                ON UPDATE NO ACTION)
//              ENGINE = InnoDB;")->execute();

        //-- -----------------------------------------------------
        //-- Table `hireMe`.`favourites`
        //            -- -----------------------------------------------------
        $this->db->createCommand("DROP TABLE IF EXISTS `hireMe`.`favourites` ;

            CREATE TABLE IF NOT EXISTS `hireMe`.`favourites` (
              `id` INT NOT NULL,
              `job_ad_id` INT NOT NULL,
              `user_id` INT NOT NULL,
              PRIMARY KEY (`id`),
              CONSTRAINT `favourites_jobAd_ref`
                FOREIGN KEY (`job_ad_id`)
                REFERENCES `hireMe`.`job_ad` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `favourites_user_ref`
                FOREIGN KEY (`user_id`)
                REFERENCES `hireMe`.`user` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
              ENGINE = InnoDB;")->execute();



        //-- -----------------------------------------------------
        //-- Table `hireMe`.`recruiter`
        //            -- -----------------------------------------------------
//        $this->db->createCommand("DROP TABLE IF EXISTS `hireMe`.`recruiter` ;
//
//            CREATE TABLE IF NOT EXISTS `hireMe`.`recruiter` (
//              `id` INT NOT NULL,
//              `company_id` INT NOT NULL,
//              `firstname` VARCHAR(45) NOT NULL,
//              `lastname` VARCHAR(45) NOT NULL,
//              `birthday` DATE NULL,
//              `email` VARCHAR(45) NOT NULL,
//              `password` VARCHAR(45) NOT NULL,
//              `admin` TINYINT(1) NULL DEFAULT 0,
//              PRIMARY KEY (`id`, `company_id`),
//              INDEX `company_ref_idx` (`company_id` ASC),
//              CONSTRAINT `company_ref`
//                FOREIGN KEY (`company_id`)
//                REFERENCES `hireMe`.`company` (`id`)
//                ON DELETE NO ACTION
//                ON UPDATE NO ACTION,
//              CONSTRAINT `recruiter_ref`
//                FOREIGN KEY (`id`)
//                REFERENCES `hireMe`.`user` (`id`)
//                ON DELETE NO ACTION
//                ON UPDATE NO ACTION)
//            ENGINE = InnoDB;")->execute();

        //-- -----------------------------------------------------
        //-- Table `hireMe`.`auth`
        //            -- -----------------------------------------------------
        $this->db->createCommand("DROP TABLE IF EXISTS `hireMe`.`auth` ;

            CREATE TABLE IF NOT EXISTS `hireMe`.`auth` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `user_id` INT(11) NOT NULL,
              `source` VARCHAR(255) NOT NULL,
              `source_id` VARCHAR(255) NOT NULL,
              PRIMARY KEY (`id`),
              INDEX `user_auth_rel_idx` (`user_id` ASC),
              CONSTRAINT `user_auth_rel`
                FOREIGN KEY (`user_id`)
                REFERENCES `hireMe`.`user` (`id`)
                ON DELETE RESTRICT
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;")->execute();


        //-- -----------------------------------------------------
        //-- Table `hireMe`.`message`
        //            -- -----------------------------------------------------
        $this->db->createCommand("DROP TABLE IF EXISTS `hireMe`.`message` ;

            CREATE TABLE IF NOT EXISTS `hireMe`.`message` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `subject` VARCHAR(255) NOT NULL,
              `content` MEDIUMTEXT NOT NULL,
              `sender_id` INT(11) NOT NULL,
              `receiver_id` INT(11) NOT NULL,
              `sent_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `deleted` TINYINT(1) NOT NULL DEFAULT 0,
              `read` TINYINT(1) NOT NULL DEFAULT 0,
              PRIMARY KEY (`id`),
              INDEX `user_messageReceiver_rel_idx` (`sender_id` ASC, `receiver_id` ASC),
              CONSTRAINT `user_messageSender_rel`
                FOREIGN KEY (`sender_id` )
                REFERENCES `hireMe`.`user` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `user_messageReceiver_rel`
                FOREIGN KEY (`receiver_id`)
                REFERENCES `hireMe`.`user` (`id`)
                ON DELETE RESTRICT
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;")->execute();


        $this->db->createCommand("SET SQL_MODE=@OLD_SQL_MODE;")->execute();
        $this->db->createCommand("SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;")->execute();
        $this->db->createCommand("SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;")->execute();


    }

    public function safeDown()
    {
        return false;
    }

}







