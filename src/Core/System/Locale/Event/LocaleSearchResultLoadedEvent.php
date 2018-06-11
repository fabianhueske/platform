<?php declare(strict_types=1);

namespace Shopware\Core\System\Locale\Event;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Event\NestedEvent;
use Shopware\Core\System\Locale\Struct\LocaleSearchResult;

class LocaleSearchResultLoadedEvent extends NestedEvent
{
    public const NAME = 'locale.search.result.loaded';

    /**
     * @var LocaleSearchResult
     */
    protected $result;

    public function __construct(LocaleSearchResult $result)
    {
        $this->result = $result;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): Context
    {
        return $this->result->getContext();
    }
}