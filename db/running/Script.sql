DROP TABLE IF EXISTS fotolife.customer;

CREATE TABLE fotolife.customer (
  id int NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  phone varchar(10) NOT NULL,
  email varchar(100) NOT NULL,
  birthday date DEFAULT NULL,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS fotolife.meeting;
CREATE TABLE fotolife.meeting (
  id int NOT NULL AUTO_INCREMENT COMMENT 'key',
  title varchar(100) NOT NULL DEFAULT 'Reunión',
  description text NOT NULL,
  start date NOT NULL,
  time_init time NOT NULL,
  status int NOT NULL DEFAULT '1',
  user_id_log int NOT NULL DEFAULT '100',
  location text,
  id_customer int NOT NULL,
  id_service int NOT NULL,
  latitude varchar(100) DEFAULT NULL,
  longitude varchar(100) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY meeting_customer_FK (id_customer),
  KEY meeting_service_FK (id_service),
  CONSTRAINT meeting_customer_FK FOREIGN KEY (id_customer) REFERENCES fotolife.customer (id),
  CONSTRAINT meeting_service_FK FOREIGN KEY (id_service) REFERENCES fotolife.services (id)
);


DROP TABLE IF EXISTS fotolife.ticket;

CREATE TABLE fotolife.ticket (
  id int NOT NULL AUTO_INCREMENT,
  total decimal(10,0) NOT NULL,
  date_ticket datetime NOT NULL,
  id_meeting int DEFAULT NULL,
  PRIMARY KEY (id),
  KEY ticket_FK (id_meeting),
  CONSTRAINT ticket_FK FOREIGN KEY (id_meeting) REFERENCES fotolife.meeting (id)
);

DROP TABLE IF EXISTS fotolife.payment;
CREATE TABLE fotolife.payment (
  id int NOT NULL AUTO_INCREMENT,
  amount decimal(10,0) NOT NULL,
  date_payment datetime NOT NULL,
  id_ticket int NOT NULL,
  PRIMARY KEY (id),
  KEY payment_FK (id_ticket),
  CONSTRAINT payment_FK FOREIGN KEY (id_ticket) REFERENCES fotolife.ticket (id)
);


DROP TABLE IF EXISTS products;
CREATE TABLE products (
  id int NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  description varchar(500) DEFAULT NULL,
  price decimal(10,0) NOT NULL,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS fotolife.services;
CREATE TABLE fotolife.services (
  id int NOT NULL AUTO_INCREMENT,
  title varchar(100) NOT NULL,
  description text NOT NULL,
  price decimal(10,0) NOT NULL,
  working_time time NOT NULL,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS fotolife.ticket_detail;
CREATE TABLE fotolife.ticket_detail (
  id int NOT NULL AUTO_INCREMENT,
  amount decimal(10,0) NOT NULL,
  date_ticket datetime NOT NULL,
  id_ticket int NOT NULL,
  id_product int DEFAULT NULL,
  PRIMARY KEY (id),
  KEY ticket_detail_FK (id_ticket),
  KEY ticket_detail_FK_1 (id_product),
  CONSTRAINT ticket_detail_FK FOREIGN KEY (id_ticket) REFERENCES fotolife.ticket (id),
  CONSTRAINT ticket_detail_FK_1 FOREIGN KEY (id_product) REFERENCES fotolife.products (id) ON DELETE RESTRICT ON UPDATE RESTRICT
);