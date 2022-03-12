/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Mlando Sikhosana Khoza
 * Created: 15 Dec 2019
 */
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Admin
 * Created: 14 Dec 2019
 */
DELIMITER //
CREATE PROCEDURE SIGNUP_COMPANY(IN _company_name VARCHAR(50),_address VARCHAR(200),_city VARCHAR(100),_postalcode VARCHAR(10),_email VARCHAR(150),_username VARCHAR(50),_password VARCHAR(256))
BEGIN
    DECLARE _count_username INT DEFAULT 0;
    DECLARE _count_email INT DEFAULT 0;
    DECLARE _company_id INT;
    SET _count_username = 
        (SELECT COUNT(*) FROM `COMPANY` A 
            WHERE A.USERNAME=LOWER(_username));
    SET _count_email = 
        (SELECT COUNT(*) FROM COMPANY_DETAIL AD 
            WHERE AD.DETAIL_NAME='email' AND AD.DETAIL_VALUE=LOWER(_email));
    IF _count_username=0 AND _count_email=0 THEN
        INSERT INTO `COMPANY` (USERNAME,PASSWORD) VALUES (LOWER(_username),_password);
        SET _company_id = (SELECT COMPANY_ID FROM `COMPANY` WHERE USERNAME=LOWER(_username));
        INSERT INTO COMPANY_DETAIL(DETAIL_NAME,DETAIL_VALUE,COMPANY_ID) 
            VALUES ('companyname',_company_name,_company_id);
        INSERT INTO COMPANY_DETAIL(DETAIL_NAME,DETAIL_VALUE,COMPANY_ID) 
            VALUES ('address',_address,_company_id);
        INSERT INTO COMPANY_DETAIL(DETAIL_NAME,DETAIL_VALUE,COMPANY_ID) 
            VALUES ('city',_city,_company_id);
        INSERT INTO COMPANY_DETAIL(DETAIL_NAME,DETAIL_VALUE,COMPANY_ID) 
            VALUES ('postalcode',_postalcode,_company_id);
        INSERT INTO COMPANY_DETAIL(DETAIL_NAME,DETAIL_VALUE,COMPANY_ID) 
            VALUES ('email',_email,_company_id);
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE COMPANY_QUERY (IN _username VARCHAR(50),_password VARCHAR(256))
BEGIN 
    SELECT A.`COMPANY_ID`,A.`USERNAME`,A.`PASSWORD`,AD.`COMPANY_DETAIL_ID`,AD.`DETAIL_NAME`,AD.`DETAIL_VALUE` FROM `COMPANY` A
        JOIN COMPANY_DETAIL AD
        ON AD.`COMPANY_ID`=A.`COMPANY_ID`
        WHERE A.`USERNAME`=LOWER(_username) AND A.`PASSWORD`=_password;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ADD_COMPANY_COOKIE(IN _uid VARCHAR(256),_start_date DATETIME,_expiry_date DATETIME,_company_id INT)
BEGIN 
    INSERT INTO COMPANY_COOKIE (UID,START_DATE,EXPIRY_DATE,COMPANY_ID) VALUES (_uid,_start_date,_expiry_date,_company_id);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE COMPANY_COOKIE_QUERY(IN _company_id INT,_uid VARCHAR(256))
BEGIN
    SELECT * FROM COMPANY_COOKIE AC
        WHERE AC.COMPANY_ID=_company_id AND AC.`UID`=_uid;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE SELECT_USER_COMPANY_QUERY(IN _username VARCHAR(100))
BEGIN
    SELECT * FROM COMPANY A
        WHERE A.`USERNAME`=LOWER(_username);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE SELECT_COMPANY_LIST(IN _admin_id INT)
BEGIN
    SELECT C.*,CD.`DETAIL_VALUE` AS COMPANYNAME FROM COMPANY C 
        JOIN COMPANY_DETAIL CD
        ON CD.`COMPANY_ID`=C.`COMPANY_ID`
        WHERE C.`ADMIN_ID`=_admin_id AND CD.`DETAIL_NAME`='companyname';
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GET_COMPANY_DETAIL(IN _company_id INT,_detail_name VARCHAR(100))
BEGIN
    SELECT * FROM COMPANY_DETAIL CD 
        WHERE CD.`COMPANY_ID`=_company_id AND CD.`DETAIL_NAME`=_detail_name;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GET_COMPANY_DETAILS(IN _company_id INT)
BEGIN
    SELECT * FROM COMPANY_DETAILS CD WHERE CD.COMPANY_ID=_company_id;
END //
DELIMITER ;