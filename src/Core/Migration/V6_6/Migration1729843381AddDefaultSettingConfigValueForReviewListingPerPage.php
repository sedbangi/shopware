<?php declare(strict_types=1);

namespace Shopware\Core\Migration\V6_6;

use Doctrine\DBAL\Connection;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Log\Package;
use Shopware\Core\Framework\Migration\MigrationStep;
use Shopware\Core\Framework\Uuid\Uuid;

/**
 * @internal
 */
#[Package('core')]
class Migration1729843381AddDefaultSettingConfigValueForReviewListingPerPage extends MigrationStep
{
    private const CONFIG_KEY = 'core.listing.reviewsPerPage';

    public function getCreationTimestamp(): int
    {
        return 1729843381;
    }

    public function update(Connection $connection): void
    {
        if ($this->configPresent($connection)) {
            return;
        }

        $connection->insert('system_config', [
            'id' => Uuid::randomBytes(),
            'configuration_key' => self::CONFIG_KEY,
            'configuration_value' => json_encode(['_value' => 10], \JSON_THROW_ON_ERROR),
            'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
        ]);
    }

    private function configPresent(Connection $connection): bool
    {
        return $connection->fetchOne(
            'SELECT `id` FROM `system_config` WHERE `configuration_key` = :config_key LIMIT 1;',
            ['config_key' => self::CONFIG_KEY]
        ) !== false;
    }
}
