GRANT ALL PRIVILEGES ON *.* TO 'root'@'%';

CREATE DATABASE IF NOT EXISTS signaturit;


CREATE USER 'dh_user_test'@'%' IDENTIFIED WITH mysql_native_password BY '*43i0;l+6=7:*lA';
GRANT ALL PRIVILEGES ON `signaturit`.* TO 'dh_user_test'@'%';


use signaturit;
CREATE TABLE `contracts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_letter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract_letter_score` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contract_letter` (`contract_letter`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT INTO contracts (contract_letter, contract_letter_score) VALUES ('K', 5), ('N', 2), ('V', 1);