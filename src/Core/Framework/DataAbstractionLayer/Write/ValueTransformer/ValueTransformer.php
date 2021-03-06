<?php declare(strict_types=1);

namespace Shopware\Core\Framework\DataAbstractionLayer\Write\ValueTransformer;

interface ValueTransformer
{
    /**
     * @param mixed $phpValue
     *
     * @return int|float|string
     */
    public function transform($phpValue);
}
