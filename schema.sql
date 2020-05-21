CREATE TABLE IF NOT EXISTS php_skeleton.user
(
    `id`    INT AUTO_INCREMENT,
    `name`  VARCHAR(255) NOT NULL,
    `email` VARCHAR(255),
    PRIMARY KEY (`id`)
)
    ENGINE = InnoDB;
