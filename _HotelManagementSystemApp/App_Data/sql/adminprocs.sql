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
CREATE PROCEDURE SIGNUP_ADMIN(IN _firstname VARCHAR(50),_lastname VARCHAR(50),_email VARCHAR(150),_username VARCHAR(50),_password VARCHAR(256))
BEGIN
    DECLARE _count_username INT DEFAULT 0;
    DECLARE _count_email INT DEFAULT 0;
    DECLARE _admin_id INT;
    SET _count_username = 
        (SELECT COUNT(*) FROM `ADMIN` A 
            WHERE A.USERNAME=LOWER(_username));
    SET _count_email = 
        (SELECT COUNT(*) FROM ADMIN_DETAIL AD 
            WHERE AD.DETAIL_NAME='email' AND AD.DETAIL_VALUE=LOWER(_email));
    IF _count_username=0 AND _count_email=0 THEN
        INSERT INTO `ADMIN` (USERNAME,PASSWORD) VALUES (LOWER(_username),_password);
        SET _admin_id = (SELECT ADMIN_ID FROM `ADMIN` WHERE USERNAME=LOWER(_username));
        INSERT INTO ADMIN_DETAIL(DETAIL_NAME,DETAIL_VALUE,ADMIN_ID) 
            VALUES ('firstname',_firstname,_admin_id);
        INSERT INTO ADMIN_DETAIL(DETAIL_NAME,DETAIL_VALUE,ADMIN_ID) 
            VALUES ('lastname',_lastname,_admin_id);
        INSERT INTO ADMIN_DETAIL(DETAIL_NAME,DETAIL_VALUE,ADMIN_ID) 
            VALUES ('email',_email,_admin_id);
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ADMIN_QUERY (IN _username VARCHAR(50),_password VARCHAR(256))
BEGIN 
    SELECT A.`ADMIN_ID`,A.`USERNAME`,A.`PASSWORD`,AD.`ADMIN_DETAIL_ID`,AD.`DETAIL_NAME`,AD.`DETAIL_VALUE` FROM `ADMIN` A
        JOIN ADMIN_DETAIL AD
        ON AD.`ADMIN_ID`=A.`ADMIN_ID`
        WHERE A.`USERNAME`=LOWER(_username) AND A.`PASSWORD`=_password;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ADD_ADMIN_COOKIE(IN _uid VARCHAR(256),_start_date DATETIME,_expiry_date DATETIME,_admin_id INT)
BEGIN 
    INSERT INTO ADMIN_COOKIE (UID,START_DATE,EXPIRY_DATE,ADMIN_ID) VALUES (_uid,_start_date,_expiry_date,_admin_id);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ADMIN_COOKIE_QUERY(IN _admin_id INT,_uid VARCHAR(256))
BEGIN
    SELECT * FROM ADMIN_COOKIE AC
        WHERE AC.ADMIN_ID=_admin_id AND AC.`UID`=_uid;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE SELECT_USER_ADMIN_QUERY(IN _username VARCHAR(100))
BEGIN
    SELECT * FROM ADMIN A
        WHERE A.`USERNAME`=LOWER(_username);
END //
DELIMITER ;
