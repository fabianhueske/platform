<?php declare(strict_types=1);

namespace Shopware\Core\System\Unit\Event;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Event\NestedEvent;
use Shopware\Core\Framework\Event\NestedEventCollection;
use Shopware\Core\System\Unit\Aggregate\UnitTranslation\Event\UnitTranslationBasicLoadedEvent;
use Shopware\Core\System\Unit\Collection\UnitDetailCollection;

class UnitDetailLoadedEvent extends NestedEvent
{
    public const NAME = 'unit.detail.loaded';

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var UnitDetailCollection
     */
    protected $units;

    public function __construct(UnitDetailCollection $units, Context $context)
    {
        $this->context = $context;
        $this->units = $units;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): Context
    {
        return $this->context;
    }

    public function getUnits(): UnitDetailCollection
    {
        return $this->units;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->units->getTranslations()->count() > 0) {
            $events[] = new UnitTranslationBasicLoadedEvent($this->units->getTranslations(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}