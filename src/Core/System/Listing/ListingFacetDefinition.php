<?php declare(strict_types=1);

namespace Shopware\Core\System\Listing;

use Shopware\Core\Framework\ORM\EntityDefinition;
use Shopware\Core\Framework\ORM\EntityExtensionInterface;
use Shopware\Core\Framework\ORM\Field\BoolField;
use Shopware\Core\Framework\ORM\Field\DateField;
use Shopware\Core\Framework\ORM\Field\IdField;
use Shopware\Core\Framework\ORM\Field\IntField;
use Shopware\Core\Framework\ORM\Field\LongTextField;
use Shopware\Core\Framework\ORM\Field\StringField;
use Shopware\Core\Framework\ORM\Field\TenantIdField;
use Shopware\Core\Framework\ORM\Field\TranslatedField;
use Shopware\Core\Framework\ORM\Field\TranslationsAssociationField;
use Shopware\Core\Framework\ORM\Field\VersionField;
use Shopware\Core\Framework\ORM\FieldCollection;
use Shopware\Core\Framework\ORM\Write\Flag\CascadeDelete;
use Shopware\Core\Framework\ORM\Write\Flag\PrimaryKey;
use Shopware\Core\Framework\ORM\Write\Flag\Required;
use Shopware\Core\Framework\ORM\Write\Flag\SearchRanking;
use Shopware\Core\System\Listing\Collection\ListingFacetBasicCollection;
use Shopware\Core\System\Listing\Collection\ListingFacetDetailCollection;
use Shopware\Core\System\Listing\Definition\ListingFacetTranslationDefinition;
use Shopware\Core\System\Listing\Event\ListingFacetDeletedEvent;
use Shopware\Core\System\Listing\Event\ListingFacetWrittenEvent;
use Shopware\Core\System\Listing\Struct\ListingFacetBasicStruct;
use Shopware\Core\System\Listing\Struct\ListingFacetDetailStruct;

class ListingFacetDefinition extends EntityDefinition
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
        return 'listing_facet';
    }

    public static function getFields(): FieldCollection
    {
        if (self::$fields) {
            return self::$fields;
        }

        self::$fields = new FieldCollection([
            new TenantIdField(),
            (new IdField('id', 'id'))->setFlags(new PrimaryKey(), new Required()),
            new VersionField(),
            (new StringField('unique_key', 'uniqueKey'))->setFlags(new Required()),
            (new LongTextField('payload', 'payload'))->setFlags(new Required()),
            (new TranslatedField(new StringField('name', 'name')))->setFlags(new SearchRanking(self::HIGH_SEARCH_RANKING)),
            new BoolField('active', 'active'),
            new BoolField('display_in_categories', 'displayInCategories'),
            new BoolField('deletable', 'deletable'),
            new IntField('position', 'position'),
            new DateField('created_at', 'createdAt'),
            new DateField('updated_at', 'updatedAt'),
            (new TranslationsAssociationField('translations', ListingFacetTranslationDefinition::class, 'listing_facet_id', false, 'id'))->setFlags(new Required(), new CascadeDelete()),
        ]);

        foreach (self::$extensions as $extension) {
            $extension->extendFields(self::$fields);
        }

        return self::$fields;
    }

    public static function getRepositoryClass(): string
    {
        return ListingFacetRepository::class;
    }

    public static function getBasicCollectionClass(): string
    {
        return ListingFacetBasicCollection::class;
    }

    public static function getDeletedEventClass(): string
    {
        return ListingFacetDeletedEvent::class;
    }

    public static function getWrittenEventClass(): string
    {
        return ListingFacetWrittenEvent::class;
    }

    public static function getBasicStructClass(): string
    {
        return ListingFacetBasicStruct::class;
    }

    public static function getTranslationDefinitionClass(): ?string
    {
        return ListingFacetTranslationDefinition::class;
    }

    public static function getDetailStructClass(): string
    {
        return ListingFacetDetailStruct::class;
    }

    public static function getDetailCollectionClass(): string
    {
        return ListingFacetDetailCollection::class;
    }
}