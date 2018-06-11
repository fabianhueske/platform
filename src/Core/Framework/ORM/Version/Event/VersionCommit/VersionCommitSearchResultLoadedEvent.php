<?php declare(strict_types=1);

namespace Shopware\Core\Framework\ORM\Version\Event\VersionCommit;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Event\NestedEvent;
use Shopware\Core\Framework\ORM\Version\Struct\VersionCommitSearchResult;

class VersionCommitSearchResultLoadedEvent extends NestedEvent
{
    public const NAME = 'version_commit.search.result.loaded';

    /**
     * @var VersionCommitSearchResult
     */
    protected $result;

    public function __construct(VersionCommitSearchResult $result)
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