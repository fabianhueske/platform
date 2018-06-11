<?php declare(strict_types=1);

namespace Shopware\Core\Framework\ORM\Version\Definition;

use Shopware\Core\Framework\ORM\EntityDefinition;
use Shopware\Core\Framework\ORM\EntityExtensionInterface;
use Shopware\Core\Framework\ORM\Field\BoolField;
use Shopware\Core\Framework\ORM\Field\DateField;
use Shopware\Core\Framework\ORM\Field\FkField;
use Shopware\Core\Framework\ORM\Field\IdField;
use Shopware\Core\Framework\ORM\Field\IntField;
use Shopware\Core\Framework\ORM\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\ORM\Field\OneToManyAssociationField;
use Shopware\Core\Framework\ORM\Field\StringField;
use Shopware\Core\Framework\ORM\Field\TenantIdField;
use Shopware\Core\Framework\ORM\FieldCollection;
use Shopware\Core\Framework\ORM\Version\Collection\VersionCommitBasicCollection;
use Shopware\Core\Framework\ORM\Version\Event\VersionCommitData\VersionCommitDataDeletedEvent;
use Shopware\Core\Framework\ORM\Version\Event\VersionCommitData\VersionCommitDataWrittenEvent;
use Shopware\Core\Framework\ORM\Version\Repository\VersionCommitRepository;
use Shopware\Core\Framework\ORM\Version\Struct\VersionCommitBasicStruct;
use Shopware\Core\Framework\ORM\Write\EntityExistence;
use Shopware\Core\Framework\ORM\Write\Flag\CascadeDelete;
use Shopware\Core\Framework\ORM\Write\Flag\PrimaryKey;
use Shopware\Core\Framework\ORM\Write\Flag\ReadOnly;
use Shopware\Core\Framework\ORM\Write\Flag\Required;
use Shopware\Core\Framework\ORM\Write\Flag\SearchRanking;

class VersionCommitDefinition extends EntityDefinition
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
        return 'version_commit';
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
            (new FkField('version_id', 'versionId', VersionDefinition::class))->setFlags(new Required()),
            new IdField('user_id', 'userId'),
            (new IntField('auto_increment', 'autoIncrement'))->setFlags(new ReadOnly()),
            new BoolField('is_merge', 'isMerge'),
            (new StringField('message', 'message'))->setFlags(new SearchRanking(self::HIGH_SEARCH_RANKING)),
            (new DateField('created_at', 'createdAt'))->setFlags(new Required()),
            (new OneToManyAssociationField('data', VersionCommitDataDefinition::class, 'version_commit_id', true))->setFlags(new CascadeDelete()),
            new ManyToOneAssociationField('version', 'version_id', VersionDefinition::class, false),
        ]);

        foreach (self::$extensions as $extension) {
            $extension->extendFields(self::$fields);
        }

        return self::$fields;
    }

    public static function getRepositoryClass(): string
    {
        return VersionCommitRepository::class;
    }

    public static function getBasicCollectionClass(): string
    {
        return VersionCommitBasicCollection::class;
    }

    public static function getDeletedEventClass(): string
    {
        return VersionCommitDataDeletedEvent::class;
    }

    public static function getWrittenEventClass(): string
    {
        return VersionCommitDataWrittenEvent::class;
    }

    public static function getBasicStructClass(): string
    {
        return VersionCommitBasicStruct::class;
    }

    public static function getTranslationDefinitionClass(): ?string
    {
        return null;
    }

    public static function getDefaults(EntityExistence $existence): array
    {
        return [
            'name' => 'auto-save',
            'createdAt' => date(\DateTime::ATOM),
        ];
    }
}