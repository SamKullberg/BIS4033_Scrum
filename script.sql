--Using "root" as user with no password
DROP DATABASE IF EXISTS BIS4033Scrum;
CREATE DATABASE BIS4033Scrum;
USE BIS4033Scrum;

CREATE TABLE patients (
	patient_id INT(11) AUTO_INCREMENT NOT NULL,
  	first_name VARCHAR(255) NOT NULL,
  	last_name VARCHAR(255) NOT NULL,
    gender VARCHAR(255) NOT NULL,
  	birthdate DATE NOT NULL,
    genetics VARCHAR(255) NOT NULL,
  	diabetes VARCHAR(255) NOT NULL,
    other_conditions VARCHAR(255) NOT NULL,
	PRIMARY KEY (patient_id)
) ENGINE=INNODB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

CREATE TABLE doctors (
    doctor_id INT(11) AUTO_INCREMENT NOT NULL,
  	first_name VARCHAR(255) NOT NULL,
  	last_name VARCHAR(255) NOT NULL,
    specialty VARCHAR(255) NOT NULL,
    PRIMARY KEY (`doctor_id`)
)

CREATE TABLE visits (
    visit_id INT(11) AUTO_INCREMENT NOT NULL,
  	patient_id INT(11) NOT NULL,
  	doctor_id INT(11) NOT NULL,
    visit_date DATE NOT NULL,
    PRIMARY KEY (visit_id),
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id)
)

CREATE TABLE fev1_results (
    fev1_id INT(11) AUTO_INCREMENT NOT NULL,
  	visit_id INT(11) NOT NULL,
  	fev1_value INT(11) NOT NULL,
    PRIMARY KEY (fev1_id),
    FOREIGN KEY (visit_id) REFERENCES visits(visit_id)
)

CREATE TABLE medications (
    medication_id INT(11) AUTO_INCREMENT NOT NULL,
  	`name` VARCHAR(255) NOT NULL,
  	requires_quantity VARCHAR(255) NOT NULL,
    requires_date VARCHAR(255) NOT NULL,
    PRIMARY KEY (medication_id)
)

CREATE TABLE prescriptions (
    prescription_id INT(11) AUTO_INCREMENT NOT NULL,
    patient_id INT(11) NOT NULL,
    medication_id INT(11) NOT NULL,
  	quantity VARCHAR(255),
  	date_received DATE,
    PRIMARY KEY (prescription_id),
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    FOREIGN KEY (medication_id) REFERENCES medications(medication_id)
)
