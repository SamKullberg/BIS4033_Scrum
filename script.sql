CREATE DATABASE BIS4033Scrum;
USE BIS4033Scrum;

CREATE TABLE IF NOT EXISTS `patients` (
	`patient_id` INT(11) NOT NULL AUTO_INCREMENT,
  	`first_name` VARCHAR(255) NOT NULL,
  	`last_name` VARCHAR(255) NOT NULL,
    `gender` VARCHAR(255) NOT NULL,
  	`birthdate` DATE NOT NULL,
    `genetics` MEDIUMTEXT(1000) NOT NULL,
  	`diabetes` VARCHAR(255) NOT NULL,
    `other_conditions` MEDIUMTEXT(1000) NOT NULL,
	PRIMARY KEY (`patient_id`)
) ENGINE=INNODB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

USE BIS4033Scrum;
GRANT SELECT, INSERT, UPDATE ON patients TO 'kermit'@'localhost';
FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS `doctors` (
    `doctor_id` INT(11) NOT NULL AUTO_INCREMENT,
  	`first_name` VARCHAR(255) NOT NULL,
  	`last_name` VARCHAR(255) NOT NULL,
    `specialty` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`doctor_id`)
)

USE BIS4033Scrum;
GRANT SELECT, INSERT, UPDATE ON doctors TO 'kermit'@'localhost';
FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS `visits` (
    `visit_id` INT(11) NOT NULL AUTO_INCREMENT,
  	`patient_id` INT(11) NOT NULL,
  	`doctor_id` INT(11) NOT NULL,
    `visit_date` DATE NOT NULL,
    PRIMARY KEY (`visit_id`),
    FOREIGN KEY (`patient_id`) REFERENCES patients(`patient_id`),
    FOREIGN KEY (`doctor_id`) REFERENCES doctors(`doctor_id`)
)

USE BIS4033Scrum;
GRANT SELECT, INSERT, UPDATE ON visits TO 'kermit'@'localhost';
FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS `fev1_results` (
    `fev1_id` INT(11) NOT NULL AUTO_INCREMENT,
  	`visit_id` INT(11) NOT NULL,
  	`fev1_value` INT(11) NOT NULL,
    PRIMARY KEY (`fev1_id`),
    FOREIGN KEY (`visit_id`) REFERENCES visits(`visit_id`)
)

USE BIS4033Scrum;
GRANT SELECT, INSERT, UPDATE ON fev1_results TO 'kermit'@'localhost';
FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS `medications` (
    `medication_id` INT(11) NOT NULL AUTO_INCREMENT,
  	`name` VARCHAR(255) NOT NULL,
  	`requires_quantity` VARCHAR(255) NOT NULL,
    `requires_date` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`medication_id`)
)

USE BIS4033Scrum;
GRANT SELECT, INSERT, UPDATE ON medications TO 'kermit'@'localhost';
FLUSH PRIVILEGES;


CREATE TABLE IF NOT EXISTS `prescriptions` (
    `prescription_id` INT(11) NOT NULL AUTO_INCREMENT,
    `patient_id` INT(11) NOT NULL,
    `medication_id` INT(11) NOT NULL,
  	`quantity` VARCHAR(255),
  	`date_received` DATE,
    PRIMARY KEY (`prescription_id`),
    FOREIGN KEY (`patient_id`) REFERENCES patients(`patient_id`),
    FOREIGN KEY (`medication_id`) REFERENCES medications(`medication_id`)
)

USE BIS4033Scrum;
GRANT SELECT, INSERT, UPDATE ON prescriptions TO 'kermit'@'localhost';
FLUSH PRIVILEGES;
