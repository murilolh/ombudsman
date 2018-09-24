CREATE DATABASE ombudsman;

USE ombudsman;

CREATE TABLE channel (
  id int(2) NOT NULL,
  name varchar(20) NOT NULL
);

CREATE TABLE theme (
  id int(2) NOT NULL,
  name varchar(30) NOT NULL
);

CREATE TABLE ticket_type (
  id int(2) NOT NULL,
  name varchar(20) NOT NULL
);

CREATE TABLE person_type (
  id int(2) NOT NULL,
  name varchar(30) NOT NULL
);

CREATE TABLE deadline_type (
  id int(2) NOT NULL,
  name varchar(20) NOT NULL
);

CREATE TABLE deadline_conclusion (
  id int(2) NOT NULL,
  name varchar(100) NOT NULL,
  is_good boolean NOT NULL
);

CREATE TABLE contract_type (
  id int(2) NOT NULL,
  name varchar(30) NOT NULL
);

CREATE TABLE ticket (
  id int(11) NOT NULL,
  protocol int(8) NOT NULL,
  id_channel int(2) NOT NULL,
  id_ticket_theme int(2) NOT NULL,
  theme_object varchar(110),
  ticket_date_ini date NOT NULL,
  ticket_date_fin date,
  id_ticket_type int(2) NOT NULL,
  id_person_type int(2),
  person_name varchar(110),
  person_email varchar(30),
  person_phone varchar(110),
  deadline_days int(3),
  deadline_date date,
  id_deadline_type int(2),
  id_deadline_conclusion int(2),
  id_contract_type int(2),
  id_complaint_theme int(2),
  emails text,
  obs_text text,
  reanalysis tinyint(1),
  created datetime,
  modified datetime,
  notified datetime
);

ALTER TABLE channel ADD PRIMARY KEY (id);
ALTER TABLE channel MODIFY id int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE theme ADD PRIMARY KEY (id);
ALTER TABLE theme MODIFY id int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE ticket_type ADD PRIMARY KEY (id);
ALTER TABLE ticket_type MODIFY id int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE person_type ADD PRIMARY KEY (id);
ALTER TABLE person_type MODIFY id int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE deadline_type ADD PRIMARY KEY (id);
ALTER TABLE deadline_type MODIFY id int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE deadline_conclusion ADD PRIMARY KEY (id);
ALTER TABLE deadline_conclusion MODIFY id int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE contract_type ADD PRIMARY KEY (id);
ALTER TABLE contract_type MODIFY id int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE ticket ADD PRIMARY KEY (id);
ALTER TABLE ticket MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE ticket ADD CONSTRAINT `fk_tkt_channel` FOREIGN KEY ( `id_channel` ) REFERENCES `channel` ( `id` ) ;
ALTER TABLE ticket ADD CONSTRAINT `fk_tkt_ticket_theme` FOREIGN KEY ( `id_ticket_theme` ) REFERENCES `theme` ( `id` ) ;
ALTER TABLE ticket ADD CONSTRAINT `fk_tkt_person_type` FOREIGN KEY ( `id_person_type` ) REFERENCES `person_type` ( `id` ) ;
ALTER TABLE ticket ADD CONSTRAINT `fk_tkt_deadline_type` FOREIGN KEY ( `id_deadline_type` ) REFERENCES `deadline_type` ( `id` ) ;
ALTER TABLE ticket ADD CONSTRAINT `fk_tkt_type` FOREIGN KEY ( `id_ticket_type` ) REFERENCES `ticket_type` ( `id` ) ;
ALTER TABLE ticket ADD CONSTRAINT `fk_tkt_deadline_conclusion` FOREIGN KEY ( `id_deadline_conclusion` ) REFERENCES `deadline_conclusion` ( `id` ) ;
ALTER TABLE ticket ADD CONSTRAINT `fk_tkt_complaint_theme` FOREIGN KEY ( `id_complaint_theme` ) REFERENCES `theme` ( `id` ) ;
ALTER TABLE ticket ADD CONSTRAINT `fk_tkt_contract_type` FOREIGN KEY ( `id_contract_type` ) REFERENCES `contract_type` ( `id` ) ;
