CREATE TABLE parts (
	pno	INT NOT NULL,
	pname VARCHAR(30),
	qoh	INT,
	price DECIMAL(6,2),
	olevel INT,
	primary key (pno));

INSERT INTO parts VALUES ("10507", "Land Before Time II", 30, 19.99, "");
INSERT INTO parts VALUES ("10508", "Land Before Time III", 40, 19.99, "");
INSERT INTO parts VALUES ("10509", "Land Before Time IV", 50, 19.99, "");
INSERT INTO parts VALUES ("10601", "Sleeping Beauty", 15, 24.99, "");
INSERT INTO parts VALUES ("10701", "When Harry Met Sally", 10, 14.99, "");
INSERT INTO parts VALUES ("10800", "Dirty Harry", 10, 10.99, "");
INSERT INTO parts VALUES ("10900", "Dr. Meowington", 40, 24.99, "");

CREATE TABLE customers (
	cno	INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(30),
	street VARCHAR(50),
	city VARCHAR(30),
	state VARCHAR(30),
	zip INT,
	phone CHAR(12),
	email VARCHAR(50),
	password VARCHAR(255),
	primary key (cno)) AUTO_INCREMENT = 100;

CREATE TABLE cart (
	cartno INT(10) auto_increment,
	cno INT(10),
	pno INT(5),
	qty INT,
	primary key (cartno, pno),
	foreign key (cno) references customers (cno),
	foreign key (pno) references parts (pno));

INSERT INTO cart (cno, pno, qty) VALUES (100, 10507, 2);

CREATE TABLE orders (
	ono INT(5) NOT NULL auto_increment,
	cno INT(10),
	received date,
	shipped date,
	primary key (ono),
	foreign key (cno) references customers (cno))auto_increment=100;

INSERT INTO orders VALUES (100, CURDATE(), "Not Shipped");

CREATE TABLE odetails (
	ono INT(5) NOT NULL,
	pno INT(5) NOT NULL,
	qty INT,
	primary key (ono,pno),
	foreign key (ono) references orders (ono),
	foreign key (pno) references parts (pno));