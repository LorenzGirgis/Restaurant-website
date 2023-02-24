DROP DATABASE IF EXISTS `restaurant`;

CREATE DATABASE `restaurant`;

USE `restaurant`;

CREATE TABLE `categorie` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `categorie` varchar(100) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `categorie` (`categorie`) VALUES ('menu'), ('sales');

CREATE TABLE IF NOT EXISTS `products` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`naam` varchar(200) NOT NULL,
  `short_desc` text NOT NULL,
	`desc` text NOT NULL,
	`quantity` int(11) NOT NULL,
	`image` text NOT NULL,
   `price` decimal(7,2) NOT NULL,
	`date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `omzet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maand` varchar(200) NOT NULL,
  `omzet` decimal(7,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `omzet` (`maand`, `omzet`) VALUES ('Juli',1000), ('Augustus', 2500), ('September', 3000), ('Oktober', 2500), ('November', 2400);

INSERT INTO `products` (`id`, `naam`, `short_desc`, `desc`, `quantity`, `image`, `price`) VALUES ('','Mozzarella sticks','Met verse olie gebakken','Verse zelfgemaakte mozzarella sticks met olie uit italie', 14, 'mozzarela.png',12),
  ('','Penne','Met verse kruiden','verse zelfgemaakte penne met groenten uit italie', 6, 'penne.png', 14),
  ('', 'Tosti caprese', 'De tosti caprese, een lekkere tosti met een Italiaanse tintje', 'Tosti met mozzarella en pesto', 12, 'tosti.png', 10),
  ('', 'Italiaanse rijstsalade', 'Heerlijke rijstsalade', 'Een lekkere maaltijdsalade met rijst en mozzarella', 12, 'salade.png', 6),
  ('', 'Kip gehaktballatjes', 'Vers uit de oven', 'Met verse kruiden uit spanje', 12, 'kip.png', 5),('','Lasagne','Vers uit de oven','Lekkere lasagne uit de oven zonder allergieen', 15, 'lasagne.png',12),
  ('','Pizza','Zelfgebakken pizza','Lekkere pizza vers gebakken door onze chef-kok ', 13, 'pizza.png',5), ('','Spaghetti','Vers uit de pan','Onze spaghetti wordt met liefde gemaakt met zelfgemaakte kruiden', 20, 'Spaghetti.jpg', 8), 
  ('', 'Regenboog ijs', 'Lekker voor het desert', 'Dit is onze huis speciale ijs die wordt gemaakt met een speciale melk uit italie', 30, 'ijs.png', 2), ('','Italiaans broodje bal','Een broodje bal met satesaus','Met uien en verse kaas', 12, 'broodje.png',7.50),
  ('','Tortellini carbonara','Heerlijke carbonara','Een romige pastagerecht met spekjes en ei', 12, 'carbonara.png', 12.45),
  ('', 'Pasta met broccoli en roomsaus', 'Heerlijke Pasta', 'Een lekkere pasta in romige saus met broccoli, champignons, spek en prei', 12, 'pasta.png', 9.67),
  ('', 'Risotto', 'Heerlijke Risotto', 'Ingrediënten variërend van vis of vlees tot alle mogelijke soorten kaas', 12, 'rissoto.png', 12.45),
  ('', 'Bruschetta met advocaat en tomaat', 'Heerlijke bruschetta', 'Deze bruschetta met avocado en tomaat kun je als bijgerecht maken of op tafel zetten tijdens een gezellige borrel of als tapas hapje.', 12, 'brucheta.png', 5);

INSERT INTO `products` (`id`, `naam`, `short_desc`, `desc`, `quantity`, `image`, `price`) VALUES ('','Lasagne','Vers uit de oven','Lekkere lasagne uit de oven zonder allergieen', 15, 'lasagne.png',12),
 ('','Pizza','Zelfgebakken pizza','Lekkere pizza vers gebakken door onze chef-kok ', 13, 'pizza.png',5), ('','Spaghetti','Vers uit de pan','Onze spaghetti wordt met liefde gemaakt met zelfgemaakte kruiden', 20, 'Spaghetti.jpg', 8), 
 ('', 'Regenboog ijs', 'Lekker voor het desert', 'Dit is onze huis speciale ijs die wordt gemaakt met een speciale melk uit italie', 30, 'ijs.png', 2);


CREATE TABLE IF NOT EXISTS `product_categorie` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`product_id` int(11) NOT NULL,
`categorie_id` int(11) NOT NULL,
PRIMARY KEY (`id`),
FOREIGN KEY (product_id) REFERENCES products(id),
FOREIGN KEY (categorie_id) REFERENCES categorie(cid)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','1','1');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','2','1');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','3','1');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','4','1');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','5','1');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','6','1');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','7','1');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','8','1');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','9','1');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','10','1');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','11','1');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','12','1');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','13','1');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','14','1');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','15','2');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','16','2');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','17','2');
INSERT INTO `product_categorie`(`id`, `product_id`, `categorie_id`) VALUES ('','18','2');


CREATE TABLE `cart` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `naam` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `orders` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `userid` int(100) NOT NULL,
  `naam` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `price` int(100) NOT NULL,
  `placed_on` DATE NOT NULL, 
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `copy_orders` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `bid` int(100) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (bid) references orders(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `completed_orders` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
    `bid` int(100) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (bid) references orders(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users` (
    id INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    username TINYTEXT NOT NULL,
    firstname TINYTEXT NOT NULL,
    lastname TINYTEXT NOT NULL,
    email TINYTEXT NOT NULL,
    password LONGTEXT NOT NULL,
    geboortedatum TINYTEXT NOT NULL,
    last_seen varchar(100) NOT NULL
);


  CREATE TABLE `adminpanel` (
    id MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(100) NOT NULL, 
      products VARCHAR(100) NOT NULL,
      price VARCHAR(100) NOT NULL,
      adress VARCHAR(100) NOT NULL,
      date VARCHAR(100) NOT NULL,
      status VARCHAR(100) NOT NULL
  );

  CREATE TABLE `product_bestellingen` (
  `bid` int(100) NOT NULL,
  `pid` int(100),
  `aantal` int(100) NOT NULL,
   FOREIGN KEY (bid) references orders(id),
   FOREIGN KEY (pid) references products(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
