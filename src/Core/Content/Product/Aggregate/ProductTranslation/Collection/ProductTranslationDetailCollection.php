<?php declare(strict_types=1);

namespace Shopware\Core\Content\Product\Aggregate\ProductTranslation\Collection;

use Shopware\Core\System\Language\Collection\LanguageBasicCollection;
use Shopware\Core\Content\Product\Aggregate\ProductTranslation\Struct\ProductTranslationDetailStruct;
use Shopware\Core\Content\Product\Collection\ProductBasicCollection;

class ProductTranslationDetailCollection extends ProductTranslationBasicCollection
{
    /**
     * @var ProductTranslationDetailStruct[]
     */
    protected $elements = [];

    public function getProducts(): ProductBasicCollection
    {
        return new ProductBasicCollection(
            $this->fmap(function (ProductTranslationDetailStruct $productTranslation) {
                return $productTranslation->getProduct();
            })
        );
    }

    public function getLanguages(): LanguageBasicCollection
    {
        return new LanguageBasicCollection(
            $this->fmap(function (ProductTranslationDetailStruct $productTranslation) {
                return $productTranslation->getLanguage();
            })
        );
    }

    protected function getExpectedClass(): string
    {
        return ProductTranslationDetailStruct::class;
    }
}