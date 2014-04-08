CREATE TABLE modules (
	module_id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	page_id INT(10),
	class_name VARCHAR(45),
	sort_order INT(10),
	settings TEXT,
	content_area VARCHAR(45)	
) ENGINE=MYISAM, CHARSET=utf8, COLLATE=utf8_unicode_ci;