<?php declare(strict_types=1);

namespace Shopware\Core\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1536237796ListingSortingTranslation extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1536237796;
    }

    public function update(Connection $connection): void
    {
        $connection->executeQuery('
            CREATE TABLE `listing_sorting_translation` (
              `listing_sorting_id` binary(16) NOT NULL,
              `language_id` binary(16) NOT NULL,
              `label` varchar(255) COLLATE utf8mb4_unicode_ci NULL,
              `created_at` datetime(3) NOT NULL,
              `updated_at` datetime(3),
              PRIMARY KEY (`listing_sorting_id`, `language_id`),
              CONSTRAINT `fk.listing_sorting_translation.language_id` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `fk.listing_sorting_translation.listing_sorting_id` FOREIGN KEY (`listing_sorting_id`) REFERENCES `listing_sorting` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
