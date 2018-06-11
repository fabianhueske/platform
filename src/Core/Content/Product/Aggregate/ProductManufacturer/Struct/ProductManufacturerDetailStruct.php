<?php declare(strict_types=1);

namespace Shopware\Core\Content\Product\Aggregate\ProductManufacturer\Struct;

use Shopware\Core\Content\Media\Struct\MediaBasicStruct;
use Shopware\Core\Content\Product\Aggregate\ProductManufacturerTranslation\Collection\ProductManufacturerTranslationBasicCollection;

class ProductManufacturerDetailStruct extends ProductManufacturerBasicStruct
{
    /**
     * @var MediaBasicStruct|null
     */
    protected $media;

    /**
     * @var \Shopware\Core\Content\Product\Aggregate\ProductManufacturerTranslation\Collection\ProductManufacturerTranslationBasicCollection
     */
    protected $translations;

    public function __construct()
    {
        $this->translations = new ProductManufacturerTranslationBasicCollection();
    }

    public function getMedia(): ?MediaBasicStruct
    {
        return $this->media;
    }

    public function setMedia(?MediaBasicStruct $media): void
    {
        $this->media = $media;
    }

    public function getTranslations(): ProductManufacturerTranslationBasicCollection
    {
        return $this->translations;
    }

    public function setTranslations(ProductManufacturerTranslationBasicCollection $translations): void
    {
        $this->translations = $translations;
    }
}