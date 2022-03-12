/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Mlando Sikhosana Khoza
 * Created: 18 Dec 2019
 */

DELIMITER //
CREATE PROCEDURE INSERT_ROOM_TYPE(IN _room_name VARCHAR(100),_price DECIMAL(10,2),_company_id INT)
BEGIN
    DECLARE _count INT;
    SET _count = (SELECT COUNT(*) FROM ROOM_TYPE RT WHERE RT.ROOM_NAME=LOWER(_room_name) AND RT.COMPANY_ID=_company_id);
    IF _count=0 THEN
        INSERT INTO ROOM_TYPE (ROOM_NAME,PRICE,COMPANY_ID) VALUES (_room_name,_price,_company_id);
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE INSERT_ROOM_NUM(IN _room_num INT,_room_type_id INT)
BEGIN
    DECLARE _count INT;
    SET _count = (SELECT COUNT(*) 
        FROM ROOM_NUM RN JOIN ROOM_TYPE RT
        ON RN.ROOM_TYPE_ID=RT.ROOM_TYPE_ID
        WHERE RN.ROOMNUM=_room_num AND RT.COMPANY_ID=_company_id);
    IF _count=0 THEN
        INSERT INTO ROOM_NUM (ROOMNUM,ROOM_TYPE_ID) VALUES (_room_num,_room_type_id);
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE SELECT_ROOM_NUMS(IN _company_id INT)
BEGIN
    SELECT * FROM ROOM_NUM RN
        JOIN ROOM_TYPE RT
        ON RN.`ROOM_TYPE_ID`=RT.`ROOM_TYPE_ID`
        WHERE RT.`COMPANY_ID`=_company_id;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE SELECT_ROOM_NUMS(IN _company_id INT)
BEGIN
    SELECT * FROM ROOM_NUM RN
        JOIN ROOM_TYPE RT
        ON RN.`ROOM_TYPE_ID`=RT.`ROOM_TYPE_ID`
        WHERE RT.`COMPANY_ID`=_company_id;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE SELECT_ROOM_NUMS_FOR_TYPE(IN _company_id INT)
BEGIN
    SELECT * FROM ROOM_NUM RN
        JOIN ROOM_TYPE RT
        ON RN.`ROOM_TYPE_ID`=RT.`ROOM_TYPE_ID`
        WHERE RT.`COMPANY_ID`=_company_id AND RN.`ROOM_TYPE_ID`=_room_type_id;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE SELECT_ROOM_TYPES(IN _company_id INT)
BEGIN
    SELECT * FROM ROOM_TYPE RT
        WHERE RT.`COMPANY_ID`=_company_id;
END //
DELIMITER ;