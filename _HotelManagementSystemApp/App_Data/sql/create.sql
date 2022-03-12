/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Mlando Sikhosana Khoza
 * Created: 11 Dec 2019
 */

CREATE TABLE ACCOUNT(
    ACCOUNT_ID INT AUTO_INCREMENT NOT NULL,
    USERNAME VARCHAR(50) NOT NULL,
    PASSWORD VARCHAR(256) NOT NULL,
    PRIMARY KEY(ACCOUNT_ID)
);
CREATE TABLE ACCOUNT_DETAIL(
    ACCOUNT_DETAIL_ID INT AUTO_INCREMENT NOT NULL,
    DETAIL_NAME VARCHAR(50) NOT NULL,
    DETAIL_VALUE VARCHAR(400) NOT NULL,
    ACCOUNT_ID INT NOT NULL,
    FOREIGN KEY (ACCOUNT_ID) REFERENCES ACCOUNT(ACCOUNT_ID),
    PRIMARY KEY(ACCOUNT_DETAIL_ID)
);
CREATE TABLE ACCOUNT_COOKIE(
    ACCOUNT_COOKIE_ID INT AUTO_INCREMENT NOT NULL,
    UID VARCHAR(400) NOT NULL,
    START_DATE DATETIME NOT NULL,
    EXPIRY_DATE DATETIME NOT NULL,
    ACCOUNT_ID INT NOT NULL,
    FOREIGN KEY (ACCOUNT_ID) REFERENCES ACCOUNT(ACCOUNT_ID),
    PRIMARY KEY(ACCOUNT_COOKIE_ID)
);
CREATE TABLE `ADMIN`(
    ADMIN_ID INT AUTO_INCREMENT NOT NULL,
    USERNAME VARCHAR(50) NOT NULL,
    PASSWORD VARCHAR(256) NOT NULL,
    PRIMARY KEY(ADMIN_ID)
);
CREATE TABLE ADMIN_DETAIL(
    ADMIN_DETAIL_ID INT AUTO_INCREMENT NOT NULL,
    DETAIL_NAME VARCHAR(50) NOT NULL,
    DETAIL_VALUE VARCHAR(400) NOT NULL,
    ADMIN_ID INT NOT NULL,
    FOREIGN KEY (ADMIN_ID) REFERENCES `ADMIN`(ADMIN_ID),
    PRIMARY KEY(ADMIN_DETAIL_ID)
);
CREATE TABLE ADMIN_COOKIE(
    ADMIN_COOKIE_ID INT AUTO_INCREMENT NOT NULL,
    UID VARCHAR(400) NOT NULL,
    START_DATE DATETIME NOT NULL,
    EXPIRY_DATE DATETIME NOT NULL,
    ADMIN_ID INT NOT NULL,
    FOREIGN KEY (ADMIN_ID) REFERENCES `ADMIN`(ADMIN_ID),
    PRIMARY KEY(ADMIN_COOKIE_ID)
);

CREATE TABLE COMPANY(
    COMPANY_ID INT AUTO_INCREMENT NOT NULL,
    USERNAME VARCHAR(50) NOT NULL,
    PASSWORD VARCHAR(256) NOT NULL,
    ADMIN_ID INT NOT NULL,
    FOREIGN KEY (ADMIN_ID) REFERENCES `ADMIN`(ADMIN_ID),
    PRIMARY KEY(COMPANY_ID)
);
CREATE TABLE COMPANY_DETAIL(
    COMPANY_DETAIL_ID INT AUTO_INCREMENT NOT NULL,
    DETAIL_NAME VARCHAR(50) NOT NULL,
    DETAIL_VALUE VARCHAR(400) NOT NULL,
    COMPANY_ID INT NOT NULL,
    FOREIGN KEY (COMPANY_ID) REFERENCES COMPANY(COMPANY_ID),
    PRIMARY KEY(COMPANY_DETAIL_ID)
);
CREATE TABLE COMPANY_COOKIE(
    COMPANY_COOKIE_ID INT AUTO_INCREMENT NOT NULL,
    UID VARCHAR(400) NOT NULL,
    START_DATE DATETIME NOT NULL,
    EXPIRY_DATE DATETIME NOT NULL,
    COMPANY_ID INT NOT NULL,
    FOREIGN KEY (COMPANY_ID) REFERENCES COMPANY(COMPANY_ID),
    PRIMARY KEY(COMPANY_COOKIE_ID)
);
CREATE TABLE EMPLOYEE(
    EMPLOYEE_ID INT AUTO_INCREMENT NOT NULL,
    USERNAME VARCHAR(50) NOT NULL,
    PASSWORD VARCHAR(256) NOT NULL,
    COMPANY_ID INT NOT NULL,
    FOREIGN KEY (COMPANY_ID) REFERENCES COMPANY(COMPANY_ID),
    PRIMARY KEY(EMPLOYEE_ID)
);
CREATE TABLE EMPLOYEE_DETAIL(
    EMPLOYEE_DETAIL_ID INT AUTO_INCREMENT NOT NULL,
    DETAIL_NAME VARCHAR(50) NOT NULL,
    DETAIL_VALUE VARCHAR(400) NOT NULL,
    EMPLOYEE_ID INT NOT NULL,
    FOREIGN KEY (EMPLOYEE_ID) REFERENCES EMPLOYEE(EMPLOYEE_ID),
    PRIMARY KEY(EMPLOYEE_DETAIL_ID)
);
CREATE TABLE EMPLOYEE_COOKIE(
    EMPLOYEE_COOKIE_ID INT AUTO_INCREMENT NOT NULL,
    UID VARCHAR(400) NOT NULL,
    START_DATE DATETIME NOT NULL,
    EXPIRY_DATE DATETIME NOT NULL,
    EMPLOYEE_ID INT NOT NULL,
    FOREIGN KEY (EMPLOYEE_ID) REFERENCES EMPLOYEE(EMPLOYEE_ID),
    PRIMARY KEY(EMPLOYEE_COOKIE_ID)
);
CREATE TABLE ROOM_TYPE(
    ROOM_TYPE_ID INT AUTO_INCREMENT NOT NULL,
    ROOM_NAME VARCHAR(300) NOT NULL,
    PRICE DECIMAL(10,2) NOT NULL,
    COMPANY_ID INT NOT NULL,
    FOREIGN KEY (COMPANY_ID) REFERENCES COMPANY(COMPANY_ID),
    PRIMARY KEY(ROOM_TYPE_ID)
);
CREATE TABLE ROOM_NUM(
    ROOM_NUM_ID INT AUTO_INCREMENT NOT NULL,
    ROOMNUM INT NOT NULL,
    ROOM_TYPE_ID INT NOT NULL,
    FOREIGN KEY (ROOM_TYPE_ID) REFERENCES ROOM_TYPE(ROOM_TYPE_ID),
    PRIMARY KEY(ROOM_NUM_ID),
    UNIQUE KEY ROOM_NUM_UNIQUE(ROOMNUM,ROOM_TYPE_ID)
);
CREATE TABLE ACCOUNT_ROOM(
    ACCOUNT_ROOM_ID INT AUTO_INCREMENT NOT NULL,
    ROOM_NUM_ID INT NOT NULL,
    ACCOUNT_ID INT NOT NULL,
    START_DATE DATETIME NOT NULL,
    EXPIRY_DATE DATETIME NOT NULL,
    NUM_PEOPLE INT NULL,
    PRICE DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (ROOM_NUM_ID) REFERENCES ROOM_NUM(ROOM_NUM_ID),
    FOREIGN KEY (ACCOUNT_ID) REFERENCES ACCOUNT(ACCOUNT_ID),
    PRIMARY KEY(ACCOUNT_ROOM_ID)
);
CREATE TABLE CATEGORY(
    CATEGORY_ID INT AUTO_INCREMENT NOT NULL,
    CATEGORY_NAME VARCHAR(300) NOT NULL,
    COMPANY_ID INT NOT NULL,
    FOREIGN KEY (COMPANY_ID) REFERENCES COMPANY(COMPANY_ID),
    PRIMARY KEY(CATEGORY_ID)
);
CREATE TABLE SUB_CATEGORY(
    SUB_CATEGORY_ID INT AUTO_INCREMENT NOT NULL,
    P_CAT_ID INT NOT NULL,
    S_CAT_ID INT NOT NULL,
    FOREIGN KEY (P_CAT_ID) REFERENCES CATEGORY(CATEGORY_ID),
    FOREIGN KEY (S_CAT_ID) REFERENCES CATEGORY(CATEGORY_ID),
    PRIMARY KEY(SUB_CATEGORY_ID)
);
CREATE TABLE SERVICE(
    SERVICE_ID INT AUTO_INCREMENT NOT NULL,
    CATEGORY_ID INT NULL,
    SERVICE_NAME VARCHAR(300) NOT NULL,
    DESCRIPTION VARCHAR(700) NOT NULL,
    PRICE DECIMAL(10,2) NOT NULL,
    COMPANY_ID INT NOT NULL,
    FOREIGN KEY (COMPANY_ID) REFERENCES COMPANY(COMPANY_ID),
    FOREIGN KEY (CATEGORY_ID) REFERENCES CATEGORY(CATEGORY_ID),
    PRIMARY KEY (SERVICE_ID)
);
CREATE TABLE SERVICE_ACCOUNT(
    SERVICE_ACCOUNT_ID INT AUTO_INCREMENT NOT NULL,
    SERVICE_ID INT NOT NULL,
    ACCOUNT_ID INT NOT NULL,
    IS_DELIVERED BIT DEFAULT 0 NOT NULL,
    ASK_DATE DATETIME NOT NULL,
    PRICE DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (SERVICE_ID) REFERENCES SERVICE(SERVICE_ID),
    FOREIGN KEY (ACCOUNT_ID) REFERENCES ACCOUNT(ACCOUNT_ID),
    PRIMARY KEY(SERVICE_ACCOUNT_ID)
);
CREATE TABLE EMPLOYEE_SERVICE(
    EMPLOYEE_SERVICE_ID INT AUTO_INCREMENT NOT NULL,
    SERVICE_ID INT NOT NULL,
    EMPLOYEE_ID INT NOT NULL,
    FOREIGN KEY (SERVICE_ID) REFERENCES SERVICE(SERVICE_ID),
    FOREIGN KEY (EMPLOYEE_ID) REFERENCES EMPLOYEE(EMPLOYEE_ID),
    PRIMARY KEY (EMPLOYEE_SERVICE_ID)
);
INSERT INTO `admin` (`USERNAME`, `PASSWORD`) 
	VALUES ('admin', 'd174127389351b400d9e16beefee3f8d9f8f58bbbf1c67b2ae352b4a39b459cc');

INSERT INTO admin_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `ADMIN_ID`) 
	VALUES ('firstname', 'Mlando', 1);
INSERT INTO admin_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `ADMIN_ID`) 
	VALUES ('lastname', 'Sikhosana Khoza', 1);
INSERT INTO admin_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `ADMIN_ID`) 
	VALUES ('email', 'mlando@mail.com', 1);

INSERT INTO account (`USERNAME`, `PASSWORD`) 
	VALUES ('jack', '19513fdc9da4fb72a4a05eb66917548d3c90ff94d5419e1f2363eea89dfee1dd');

INSERT INTO account_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `ACCOUNT_ID`) 
	VALUES ('firstname', 'Jack', 1);
INSERT INTO account_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `ACCOUNT_ID`) 
	VALUES ('lastname', 'Morris', 1);
INSERT INTO account_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `ACCOUNT_ID`) 
	VALUES ('email', 'jack@mail.com', 1);

INSERT INTO company (`USERNAME`, `PASSWORD`, `ADMIN_ID`) 
	VALUES ('hiltonadmin', '1be0222750aaf3889ab95b5d593ba12e4ff1046474702d6b4779f4b527305b23', 1);
INSERT INTO company (`USERNAME`, `PASSWORD`, `ADMIN_ID`) 
	VALUES ('gardenadmin', '19513fdc9da4fb72a4a05eb66917548d3c90ff94d5419e1f2363eea89dfee1dd', 1);

INSERT INTO company_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `COMPANY_ID`) 
	VALUES ('companyname', 'Hilton', 1);
INSERT INTO company_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `COMPANY_ID`) 
	VALUES ('address', '14 Walnut Road', 1);
INSERT INTO company_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `COMPANY_ID`) 
	VALUES ('city', 'Durban', 1);
INSERT INTO company_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `COMPANY_ID`) 
	VALUES ('postalcode', '4001', 1);
INSERT INTO company_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `COMPANY_ID`) 
	VALUES ('email', 'hotels@hilton.com', 1);
INSERT INTO company_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `COMPANY_ID`) 
	VALUES ('companyname', 'Garden Court', 2);
INSERT INTO company_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `COMPANY_ID`) 
	VALUES ('address', 'Centenary Boulevard', 2);
INSERT INTO company_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `COMPANY_ID`) 
	VALUES ('city', 'Umhlanga', 2);
INSERT INTO company_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `COMPANY_ID`) 
	VALUES ('postalcode', '4319', 2);
INSERT INTO company_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `COMPANY_ID`) 
	VALUES ('email', 'hotels@gardencourt.com', 2);

INSERT INTO employee (`USERNAME`, `PASSWORD`, `COMPANY_ID`) 
	VALUES ('mike', '19513fdc9da4fb72a4a05eb66917548d3c90ff94d5419e1f2363eea89dfee1dd', 1);
INSERT INTO employee (`USERNAME`, `PASSWORD`, `COMPANY_ID`) 
	VALUES ('jack', '19513fdc9da4fb72a4a05eb66917548d3c90ff94d5419e1f2363eea89dfee1dd', 1);
INSERT INTO employee (`USERNAME`, `PASSWORD`, `COMPANY_ID`) 
	VALUES ('leo', '19513fdc9da4fb72a4a05eb66917548d3c90ff94d5419e1f2363eea89dfee1dd', 2);
INSERT INTO employee (`USERNAME`, `PASSWORD`, `COMPANY_ID`) 
	VALUES ('mary', '19513fdc9da4fb72a4a05eb66917548d3c90ff94d5419e1f2363eea89dfee1dd', 2);
INSERT INTO employee (`USERNAME`, `PASSWORD`, `COMPANY_ID`) 
	VALUES ('alarine', '19513fdc9da4fb72a4a05eb66917548d3c90ff94d5419e1f2363eea89dfee1dd', 2);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('firstname', 'Mike', 1);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('lastname', 'Thatcher', 1);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('fullname', 'Mike Thatcher', 1);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('email', 'mike@mail.com', 1);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('firstname', 'Jack', 2);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('lastname', 'Black', 2);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('fullname', 'Jack Black', 2);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('email', 'jack@mail.com', 2);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('firstname', 'Leonardo', 3);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('lastname', 'Boujuar', 3);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('fullname', 'Leonardo Boujuar', 3);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('email', 'leo@cook.com', 3);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('firstname', 'Mary', 4);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('lastname', 'Maidman', 4);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('fullname', 'Mary Maidman', 4);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('email', 'mary@cleanup.com', 4);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('firstname', 'Alarine', 5);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('lastname', 'Matters', 5);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('fullname', 'Alarine Matters', 5);
INSERT INTO employee_detail (`DETAIL_NAME`, `DETAIL_VALUE`, `EMPLOYEE_ID`) 
	VALUES ('email', 'alarine@mail.com', 5);

INSERT INTO category (`CATEGORY_NAME`, `COMPANY_ID`) 
	VALUES ('breakfast', 1);
INSERT INTO category (`CATEGORY_NAME`, `COMPANY_ID`) 
	VALUES ('lunch', 1);
INSERT INTO category (`CATEGORY_NAME`, `COMPANY_ID`) 
	VALUES ('domestic', 2);
INSERT INTO category (`CATEGORY_NAME`, `COMPANY_ID`) 
	VALUES ('supper', 2);
INSERT INTO category (`CATEGORY_NAME`, `COMPANY_ID`) 
	VALUES ('desert', 2);
INSERT INTO category (`CATEGORY_NAME`, `COMPANY_ID`) 
	VALUES ('breakfast', 2);
INSERT INTO category (`CATEGORY_NAME`, `COMPANY_ID`) 
	VALUES ('lunch', 2);

INSERT INTO service (`CATEGORY_ID`, `SERVICE_NAME`, `DESCRIPTION`, `PRICE`, `COMPANY_ID`) 
	VALUES (1, 'Egg', 'Delicious', 30.90, 1);
INSERT INTO service (`CATEGORY_ID`, `SERVICE_NAME`, `DESCRIPTION`, `PRICE`, `COMPANY_ID`) 
	VALUES (1, 'Scrambled Eggs on Toast', 'Delicious breakfast', 45.00, 1);
INSERT INTO service (`CATEGORY_ID`, `SERVICE_NAME`, `DESCRIPTION`, `PRICE`, `COMPANY_ID`) 
	VALUES (2, 'Fish and Salad', 'Hake with avocados, tomatoes and chicken', 56.95, 1);
INSERT INTO service (`CATEGORY_ID`, `SERVICE_NAME`, `DESCRIPTION`, `PRICE`, `COMPANY_ID`) 
	VALUES (3, 'Clean room up', 'Request somebody to clean your room', 30.00, 2);
INSERT INTO service (`CATEGORY_ID`, `SERVICE_NAME`, `DESCRIPTION`, `PRICE`, `COMPANY_ID`) 
	VALUES (3, 'Laundry', 'Get up to 30kg of laundry done today', 400.00, 2);
INSERT INTO service (`CATEGORY_ID`, `SERVICE_NAME`, `DESCRIPTION`, `PRICE`, `COMPANY_ID`) 
	VALUES (6, 'Breakfast in Bed: Eggs and Bacon', '2 Eggs and 4 rashes of bacon delivered to your door', 44.99, 2);
INSERT INTO service (`CATEGORY_ID`, `SERVICE_NAME`, `DESCRIPTION`, `PRICE`, `COMPANY_ID`) 
	VALUES (6, 'Oats and raisins', 'Yoghurt with walnuts glazed with raisins', 18.99, 2);
INSERT INTO service (`CATEGORY_ID`, `SERVICE_NAME`, `DESCRIPTION`, `PRICE`, `COMPANY_ID`) 
	VALUES (7, 'Garden Court Pie: Mutton Curry', 'Mutton Curry Pie with a side of chips or salad', 45.89, 2);
INSERT INTO service (`CATEGORY_ID`, `SERVICE_NAME`, `DESCRIPTION`, `PRICE`, `COMPANY_ID`) 
	VALUES (7, 'Rice with Mutton Curry', 'Taste our famous rice and mutton curry with a dash of salad', 68.90, 2);
INSERT INTO service (`CATEGORY_ID`, `SERVICE_NAME`, `DESCRIPTION`, `PRICE`, `COMPANY_ID`) 
	VALUES (4, 'Gravy Steak and Chips', 'Chips with Peppered Gravy and Steak', 62.99, 2);
INSERT INTO service (`CATEGORY_ID`, `SERVICE_NAME`, `DESCRIPTION`, `PRICE`, `COMPANY_ID`) 
	VALUES (5, 'Suflae Cake', 'Cheese Cake and famous garden court recipe', 40.78, 2);

INSERT INTO room_type (`ROOM_NAME`, `PRICE`, `COMPANY_ID`) 
	VALUES ('Bronze league', 350.00, 1);
INSERT INTO room_type (`ROOM_NAME`, `PRICE`, `COMPANY_ID`) 
	VALUES ('Silver league', 750.00, 1);
INSERT INTO room_type (`ROOM_NAME`, `PRICE`, `COMPANY_ID`) 
	VALUES ('Golden Lux', 1205.60, 1);
INSERT INTO room_type (`ROOM_NAME`, `PRICE`, `COMPANY_ID`) 
	VALUES ('Basic', 350.09, 2);
INSERT INTO room_type (`ROOM_NAME`, `PRICE`, `COMPANY_ID`) 
	VALUES ('Comforts Client', 449.50, 2);
INSERT INTO room_type (`ROOM_NAME`, `PRICE`, `COMPANY_ID`) 
	VALUES ('Queens Suite', 769.50, 2);

INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (101, 1);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (101, 4);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (102, 1);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (102, 4);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (103, 1);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (103, 4);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (104, 4);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (201, 2);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (201, 5);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (202, 2);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (202, 5);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (203, 2);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (203, 5);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (204, 5);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (205, 5);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (301, 3);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (301, 6);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (302, 3);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (302, 6);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (303, 6);
INSERT INTO room_num (`ROOMNUM`, `ROOM_TYPE_ID`) 
	VALUES (304, 6);

INSERT INTO employee_service (`SERVICE_ID`, `EMPLOYEE_ID`) 
	VALUES (2, 1);
INSERT INTO employee_service (`SERVICE_ID`, `EMPLOYEE_ID`) 
	VALUES (1, 2);
INSERT INTO employee_service (`SERVICE_ID`, `EMPLOYEE_ID`) 
	VALUES (3, 2);
INSERT INTO employee_service (`SERVICE_ID`, `EMPLOYEE_ID`) 
	VALUES (10, 3);
INSERT INTO employee_service (`SERVICE_ID`, `EMPLOYEE_ID`) 
	VALUES (8, 3);
INSERT INTO employee_service (`SERVICE_ID`, `EMPLOYEE_ID`) 
	VALUES (9, 3);
INSERT INTO employee_service (`SERVICE_ID`, `EMPLOYEE_ID`) 
	VALUES (11, 3);
INSERT INTO employee_service (`SERVICE_ID`, `EMPLOYEE_ID`) 
	VALUES (5, 4);
INSERT INTO employee_service (`SERVICE_ID`, `EMPLOYEE_ID`) 
	VALUES (4, 4);
INSERT INTO employee_service (`SERVICE_ID`, `EMPLOYEE_ID`) 
	VALUES (5, 5);
INSERT INTO account_room (`ROOM_NUM_ID`, `ACCOUNT_ID`, `START_DATE`, `EXPIRY_DATE`, `NUM_PEOPLE`, `PRICE`) 
	VALUES (1, 1, '2019-12-20 12:00:00.0', '2019-12-26 12:00:00.0', 1, 2100.00);
INSERT INTO account_room (`ROOM_NUM_ID`, `ACCOUNT_ID`, `START_DATE`, `EXPIRY_DATE`, `NUM_PEOPLE`, `PRICE`) 
	VALUES (11, 1, '2019-12-20 12:00:00.0', '2019-12-25 12:00:00.0', 1, 1750.45);

