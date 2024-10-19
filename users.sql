CREATE TABLE `users` (
     `id` INT(11) NOT NULL AUTO_INCREMENT,
     `username` VARCHAR(25) NOT NULL,
     `email` VARCHAR(100) NOT NULL,
     `password` VARCHAR(255) NOT NULL,
     `date_joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`id`)
) ENGINE=InnoDB;