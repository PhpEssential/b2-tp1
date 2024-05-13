SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE stock_movement;
TRUNCATE TABLE article_shop;
TRUNCATE TABLE article;
TRUNCATE TABLE user_shop;
TRUNCATE TABLE shop;

INSERT INTO shop(id, `name`) VALUES(1, 'test');

INSERT INTO user_shop(shop_id, user_id) SELECT u.id, 1 FROM users u;

INSERT INTO article(`id`, `name`, `image`) 
VALUES
	(1, 'Boites de 12 oeufs', 'https://tb-static.uber.com/prod/image-proc/processed_images/d4950c3370465bc0604076519a13e123/4218ca1d09174218364162cd0b1a8cc1.jpeg'),
	(2, 'Boites de 24 oeufs', 'https://www.coursesu.com/dw/image/v2/BBQX_PRD/on/demandware.static/-/Sites-digitalu-master-catalog/default/dw2f0796c6/3435760053244_A_317323435760053244_S01.jpeg'),
	(3, 'Boites de 6 oeufs', 'https://www.mon-emballage.com/12969-large_default/boite-a-oeufs-grise-pour-6-oeufs-tous-calibres-par-270.jpg'),
	(4, 'Boites de 30 oeufs', 'https://cahutefermiere.com/cdn/shop/products/oeufsfermierx48_1024x1024.jpg?v=1704363696');

INSERT INTO article_shop(id, shop_id, article_id) 
VALUES
	(1, 1, 1),
	(2, 1, 2),
	(3, 1, 3),
	(4, 1, 4);

LOAD DATA INFILE 'C:\\Workspace\\Cours\\tp1 - Copie\\stock_movement_data.csv'
INTO TABLE stock_movement
FIELDS TERMINATED BY ',' 
ENCLOSED BY '\''
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

SET FOREIGN_KEY_CHECKS = 1;