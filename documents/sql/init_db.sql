CREATE TABLE `devices` (
	`id` INT NOT NULL AUTO_INCREMENT,       -- ID de l'appareil
	`visible` BOOLEAN NOT NULL,             -- Remplace la suppression d'un appareil en cas d'erreur
	`name` VARCHAR(255) NOT NULL,           -- Nom de l'appareil
	`code` VARCHAR(255) NOT NULL,           -- Code spécifique à l'appareil
	`state` BOOLEAN NOT NULL,               -- Etat de l'appareil

	`prog_on_state` BOOLEAN NOT NULL,       -- Etat de la programmation d'allumage
	`prog_on_time` TIME NOT NULL,           -- Heure d'allumage
	`prog_on_code` VARCHAR(255) NOT NULL,   -- Code for on programmation
	`prog_on_persistent` BOOLEAN NOT NULL,  -- Etat de l'appareil

	`prog_off_state` BOOLEAN NOT NULL,      -- Etat de la programmation d'extinction
	`prog_off_time` TIME NOT NULL,          -- Heure d'extinction
	`prog_off_code` VARCHAR(255) NOT NULL,  -- Code for off programmation
	`prog_off_persistent` BOOLEAN NOT NULL, -- Etat de l'appareil

	PRIMARY KEY (`id`)
);
