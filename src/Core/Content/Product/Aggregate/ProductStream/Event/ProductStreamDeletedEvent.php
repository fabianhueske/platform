<?php declare(strict_types=1);

namespace Shopware\Core\Content\Product\Aggregate\ProductStream\Event;

use Shopware\Core\Content\Product\Aggregate\ProductStream\ProductStreamDefinition;
use Shopware\Core\Framework\ORM\Write\DeletedEvent;
use Shopware\Core\Framework\ORM\Write\WrittenEvent;

class ProductStreamDeletedEvent extends WrittenEvent implements DeletedEvent
{
    public const NAME = 'product_stream.deleted';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return ProductStreamDefinition::class;
    }
}