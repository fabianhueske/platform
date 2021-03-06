CREATE TABLE `plugin` (
    `id`              BINARY(16)                              NOT NULL,
    `name`            VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `active`          TINYINT(1)                              NOT NULL DEFAULT 0,
    `author`          VARCHAR(255) COLLATE utf8mb4_unicode_ci NULL,
    `copyright`       VARCHAR(255) COLLATE utf8mb4_unicode_ci NULL,
    `license`         VARCHAR(255) COLLATE utf8mb4_unicode_ci NULL,
    `version`         VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `upgrade_version` VARCHAR(255) COLLATE utf8mb4_unicode_ci NULL,
    `installed_at`    DATETIME(3)                             NULL,
    `upgraded_at`     DATETIME(3)                             NULL,
    `created_at`      DATETIME(3)                             NOT NULL,
    `updated_at`      DATETIME(3)                             NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`)
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `migration` (
    `class`               VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `creation_timestamp`  INT(8)                                  NOT NULL,
    `update` TIMESTAMP(6)                                         NULL,
    `update_destructive`  TIMESTAMP(6)                            NULL,
    `message`             TEXT         COLLATE utf8mb4_unicode_ci NULL,
    PRIMARY KEY (`class`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE = utf8mb4_unicode_ci;