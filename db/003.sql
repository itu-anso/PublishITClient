CREATE TABLE setting (
	setting_id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	label VARCHAR(45) NOT NULL,
	`values` ENUM()
)