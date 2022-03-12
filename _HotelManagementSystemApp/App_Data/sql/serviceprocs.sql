/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Mlando Sikhosana Khoza
 * Created: 16 Dec 2019
 */

DELIMITER //
CREATE PROCEDURE GET_SERVICES_FOR_COMPANY(IN _company_id INT)
BEGIN
    SELECT * FROM SERVICES
        WHERE COMPANY_ID=_company_id;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GET_SERVICES(IN _company_id INT)
BEGIN
    SELECT * FROM SERVICE S
        JOIN CATEGORY C
        ON S.`CATEGORY_ID`=C.`CATEGORY_ID`
        WHERE S.`COMPANY_ID`=_company_id OR C.`COMPANY_ID`=_company_id;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE INSERT_SERVICE(IN _category_id INT,_service_name VARCHAR(300), _description VARCHAR(700), _price DECIMAL(10,2),_company_id INT)
BEGIN
    DECLARE _count INT;
    SET _count= (SELECT COUNT(*) FROM SERVICE S WHERE S.SERVICE_NAME=_service_name);
    IF _count=0 THEN
        INSERT INTO SERVICE(CATEGORY_ID,SERVICE_NAME,DESCRIPTION,PRICE,COMPANY_ID)
            VALUES (_category_id,_service_name,_description,_price,_company_id);
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE INSERT_CATEGORY(IN _category_name VARCHAR(100),_company_id INT)
BEGIN
    DECLARE _count INT;
    SET _count = (SELECT COUNT(*) FROM CATEGORY C WHERE C.CATEGORY_NAME=LOWER(_category_name));
    IF _count=0 THEN
        INSERT INTO CATEGORY(CATEGORY_NAME,COMPANY_ID)
            VALUES (LOWER(_category_name),_company_id);
    END IF;
    
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GET_CATEGORIES(IN _company_id INT)
BEGIN
    SELECT * FROM CATEGORY C
        WHERE C.`COMPANY_ID`=_company_id;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE TOGGLE_EMPLOYEE_SERVICE(IN _service_id INT,_employee_id INT)
BEGIN
    DECLARE _count INT;
    SET _count = (SELECT COUNT(*) FROM EMPLOYEE_SERVICE ES WHERE ES.SERVICE_ID=_service_id AND ES.EMPLOYEE_ID=_employee_id);
    IF _count=0 THEN
        INSERT INTO EMPLOYEE_SERVICE (SERVICE_ID,EMPLOYEE_ID) VALUES(_service_id,_employee_id);
    ELSE
        DELETE FROM EMPLOYEE_SERVICE WHERE SERVICE_ID=_service_id AND EMPLOYEE_ID=_employee_id;
    END IF;
END //
DELIMITER ;