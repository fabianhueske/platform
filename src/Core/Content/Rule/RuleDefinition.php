<?php declare(strict_types=1);

namespace Shopware\Core\Content\Rule;

use Shopware\Core\Checkout\DiscountSurcharge\DiscountSurchargeDefinition;
use Shopware\Core\Content\Rule\Collection\RuleBasicCollection;
use Shopware\Core\Content\Rule\Event\RuleDeletedEvent;
use Shopware\Core\Content\Rule\Event\RuleWrittenEvent;
use Shopware\Core\Content\Rule\Struct\RuleBasicStruct;
use Shopware\Core\Framework\ORM\EntityDefinition;
use Shopware\Core\Framework\ORM\EntityExtensionInterface;
use Shopware\Core\Framework\ORM\Field\DateField;
use Shopware\Core\Framework\ORM\Field\IdField;
use Shopware\Core\Framework\ORM\Field\IntField;
use Shopware\Core\Framework\ORM\Field\JsonObjectField;
use Shopware\Core\Framework\ORM\Field\OneToManyAssociationField;
use Shopware\Core\Framework\ORM\Field\StringField;
use Shopware\Core\Framework\ORM\Field\TenantIdField;
use Shopware\Core\Framework\ORM\FieldCollection;
use Shopware\Core\Framework\ORM\Write\Flag\CascadeDelete;
use Shopware\Core\Framework\ORM\Write\Flag\PrimaryKey;
use Shopware\Core\Framework\ORM\Write\Flag\Required;
use Shopware\Core\Framework\ORM\Write\Flag\Serialized;
use Shopware\Core\Framework\ORM\Write\Flag\WriteOnly;

class RuleDefinition extends EntityDefinition
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
        return 'rule';
    }

    public static function getFields(): FieldCollection
    {
        if (self::$fields) {
            return self::$fields;
        }

        self::$fields = new FieldCollection([
            new TenantIdField(),
            (new IdField('id', 'id'))->setFlags(new PrimaryKey(), new Required()),
            (new StringField('name', 'name'))->setFlags(new Required()),
            (new IntField('priority', 'priority'))->setFlags(new Required()),
            (new JsonObjectField('payload', 'payload'))->setFlags(new Required(), new Serialized()),
            new DateField('created_at', 'createdAt'),
            new DateField('updated_at', 'updatedAt'),

            (new OneToManyAssociationField('contextCartModifers', DiscountSurchargeDefinition::class, 'rule_id', false, 'id'))->setFlags(new CascadeDelete(), new WriteOnly()),
        ]);

        foreach (self::$extensions as $extension) {
            $extension->extendFields(self::$fields);
        }

        return self::$fields;
    }

    public static function getRepositoryClass(): string
    {
        return RuleRepository::class;
    }

    public static function getBasicCollectionClass(): string
    {
        return RuleBasicCollection::class;
    }

    public static function getDeletedEventClass(): string
    {
        return RuleDeletedEvent::class;
    }

    public static function getWrittenEventClass(): string
    {
        return RuleWrittenEvent::class;
    }

    public static function getBasicStructClass(): string
    {
        return RuleBasicStruct::class;
    }

    public static function getTranslationDefinitionClass(): ?string
    {
        return null;
    }
}