<?php declare(strict_types=1);

namespace Shopware\Core\Framework\ORM\Version\Definition;

use Shopware\Core\Framework\ORM\EntityDefinition;
use Shopware\Core\Framework\ORM\EntityExtensionInterface;
use Shopware\Core\Framework\ORM\Field\DateField;
use Shopware\Core\Framework\ORM\Field\IdField;
use Shopware\Core\Framework\ORM\Field\OneToManyAssociationField;
use Shopware\Core\Framework\ORM\Field\StringField;
use Shopware\Core\Framework\ORM\Field\TenantIdField;
use Shopware\Core\Framework\ORM\FieldCollection;
use Shopware\Core\Framework\ORM\Version\Collection\VersionBasicCollection;
use Shopware\Core\Framework\ORM\Version\Event\Version\VersionDeletedEvent;
use Shopware\Core\Framework\ORM\Version\Event\Version\VersionWrittenEvent;
use Shopware\Core\Framework\ORM\Version\Repository\VersionRepository;
use Shopware\Core\Framework\ORM\Version\Struct\VersionBasicStruct;
use Shopware\Core\Framework\ORM\Write\EntityExistence;
use Shopware\Core\Framework\ORM\Write\Flag\PrimaryKey;
use Shopware\Core\Framework\ORM\Write\Flag\Required;
use Shopware\Core\Framework\ORM\Write\Flag\SearchRanking;

class VersionDefinition extends EntityDefinition
{
    /**
     * @var FieldCollection
     */
    protected static $primaryKeys;

    /**
     * @var FieldCollection
     */
    protected static $fields;

    /**
     * @var EntityExtensionInterface[]
     */
    protected static $extensions = [];

    public static function getEntityName(): string
    {
        return 'version';
    }

    public static function isVersionAware(): bool
    {
        return false;
    }

    public static function getFields(): FieldCollection
    {
        if (self::$fields) {
            return self::$fields;
        }

        self::$fields = new FieldCollection([
            new TenantIdField(),
            (new IdField('id', 'id'))->setFlags(new PrimaryKey(), new Required()),
            (new StringField('name', 'name'))->setFlags(new Required(), new SearchRanking(self::HIGH_SEARCH_RANKING)),
            new DateField('created_at', 'createdAt'),
            new DateField('updated_at', 'updatedAt'),
            new OneToManyAssociationField('commits', VersionCommitDefinition::class, 'version_id', true),
        ]);

        foreach (self::$extensions as $extension) {
            $extension->extendFields(self::$fields);
        }

        return self::$fields;
    }

    public static function getRepositoryClass(): string
    {
        return VersionRepository::class;
    }

    public static function getBasicCollectionClass(): string
    {
        return VersionBasicCollection::class;
    }

    public static function getDeletedEventClass(): string
    {
        return VersionDeletedEvent::class;
    }

    public static function getWrittenEventClass(): string
    {
        return VersionWrittenEvent::class;
    }

    public static function getBasicStructClass(): string
    {
        return VersionBasicStruct::class;
    }

    public static function getTranslationDefinitionClass(): ?string
    {
        return null;
    }

    public static function getDefaults(EntityExistence $existence): array
    {
        return [
            'name' => sprintf('Draft (%s)', date('Y-m-d H:i:s')),
            'createdAt' => date(\DateTime::ATOM),
        ];
    }
}