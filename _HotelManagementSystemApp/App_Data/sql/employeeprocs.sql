/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Mlando Sikhosana Khoza
 * Created: 17 Dec 2019
 */

DELIMITER //
CREATE PROCEDURE SIGNUP_EMPLOYEE(IN _firstname VARCHAR(50),_lastname VARCHAR(50),_email VARCHAR(150),_username VARCHAR(50),_password VARCHAR(256),_company_id INT)
BEGIN
    DECLARE _count_username INT DEFAULT 0;
    DECLARE _count_email INT DEFAULT 0;
    DECLARE _employee_id INT;
    SET _count_username = 
        (SELECT COUNT(*) FROM `EMPLOYEE` A 
            WHERE A.USERNAME=LOWER(_username));
    SET _count_email = 
        (SELECT COUNT(*) FROM EMPLOYEE_DETAIL AD 
            WHERE AD.DETAIL_NAME='email' AND AD.DETAIL_VALUE=LOWER(_email));
    IF _count_username=0 AND _count_email=0 THEN
        INSERT INTO `EMPLOYEE` (USERNAME,PASSWORD,COMPANY_ID) VALUES (LOWER(_username),_password,_company_id);
        SET _employee_id = (SELECT EMPLOYEE_ID FROM `EMPLOYEE` WHERE USERNAME=LOWER(_username));
        INSERT INTO EMPLOYEE_DETAIL(DETAIL_NAME,DETAIL_VALUE,EMPLOYEE_ID) 
            VALUES ('firstname',_firstname,_employee_id);
        INSERT INTO EMPLOYEE_DETAIL(DETAIL_NAME,DETAIL_VALUE,EMPLOYEE_ID) 
            VALUES ('lastname',_lastname,_employee_id);
        INSERT INTO EMPLOYEE_DETAIL(DETAIL_NAME,DETAIL_VALUE,EMPLOYEE_ID) 
            VALUES ('fullname',CONCAT(_firstname,' ',_lastname),_employee_id);
        INSERT INTO EMPLOYEE_DETAIL(DETAIL_NAME,DETAIL_VALUE,EMPLOYEE_ID) 
            VALUES ('email',_email,_employee_id);
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE LOGIN_EMPLOYEE_QUERY (IN _username VARCHAR(50),_password VARCHAR(256))
BEGIN 
    SELECT * FROM `EMPLOYEE` A
        JOIN EMPLOYEE_DETAIL AD
        ON AD.`EMPLOYEE_ID`=A.`EMPLOYEE_ID`
        WHERE A.`USERNAME`=LOWER(_username) AND A.`PASSWORD`=_password;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ADD_EMPLOYEE_COOKIE(IN _uid VARCHAR(256),_start_date DATETIME,_expiry_date DATETIME,_employee_id INT)
BEGIN 
    INSERT INTO EMPLOYEE_COOKIE (UID,START_DATE,EXPIRY_DATE,EMPLOYEE_ID) VALUES (_uid,_start_date,_expiry_date,_employee_id);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE EMPLOYEE_COOKIE_QUERY(IN _employee_id INT,_uid VARCHAR(256))
BEGIN
    SELECT * FROM EMPLOYEE_COOKIE EC
        WHERE EC.EMPLOYEE_ID=_employee_id AND EC.`UID`=_uid;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE SELECT_USER_EMPLOYEE_QUERY(IN _username VARCHAR(100))
BEGIN
    SELECT * FROM EMPLOYEE E
        WHERE E.`USERNAME`=LOWER(_username);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE SELECT_EMPLOYEE_FOR_COMPANY(IN _company_id INT)
BEGIN
    SELECT E.`EMPLOYEE_ID`,ED.`DETAIL_VALUE` AS FULLNAME FROM EMPLOYEE E
        JOIN EMPLOYEE_DETAIL ED
        ON E.`EMPLOYEE_ID`=ED.`EMPLOYEE_ID`
        WHERE E.`COMPANY_ID`=_company_id AND ED.`DETAIL_NAME`='fullname';
END //
DELIMITER ;
