CREATE TABLE `users` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `city` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `post_station` varchar(30) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` varchar(20) NOT NULL,
  `id_card` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `banks` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `note` text NOT NULL,
  `book_no` varchar(20) NOT NULL,
  `card_no` varchar(20) NOT NULL,
  `account_name` varchar(200) NOT NULL,
  `user_id` int(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `categories` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `note` text NOT NULL,
  `photo` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8


CREATE TABLE `products` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `note` text NOT NULL,
  `unit_price` int(10) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `user_id` int(7) NOT NULL,
  `category_id` int(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `orders` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `user_id` int(7) NOT NULL,
  `status` int(7) NOT NULL,
  `sell_at` datetime NOT NULL,
  `sell_by` int(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `order_item` (
  `order_id` int(7) NOT NULL,
  `product_id` int(7) NOT NULL,
  `quantity` int(7) NOT NULL,
  PRIMARY KEY (`order_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;