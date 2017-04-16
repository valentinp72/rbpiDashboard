CREATE TABLE `devices` (
	`id` INT NOT NULL AUTO_INCREMENT, 
	`name` VARCHAR(255) NOT NULL,
	`code` VARCHAR(255) NOT NULL,
	`state` BOOLEAN NOT NULL,
	`prog_on_state` BOOLEAN NOT NULL,
	`prog_on_time` TIME NOT NULL,
	`prog_off_state` BOOLEAN NOT NULL,
	`prog_off_time` TIME NOT NULL,
	PRIMARY KEY (`id`)
);
