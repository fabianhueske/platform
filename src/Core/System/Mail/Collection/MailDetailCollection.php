<?php declare(strict_types=1);

namespace Shopware\Core\System\Mail\Collection;

use Shopware\Core\Checkout\Order\Aggregate\OrderState\Collection\OrderStateBasicCollection;
use Shopware\Core\System\Mail\Aggregate\MailAttachment\Collection\MailAttachmentBasicCollection;
use Shopware\Core\System\Mail\Aggregate\MailTranslation\Collection\MailTranslationBasicCollection;
use Shopware\Core\System\Mail\Struct\MailDetailStruct;

class MailDetailCollection extends MailBasicCollection
{
    /**
     * @var MailDetailStruct[]
     */
    protected $elements = [];

    public function getOrderStates(): OrderStateBasicCollection
    {
        return new \Shopware\Core\Checkout\Order\Aggregate\OrderState\Collection\OrderStateBasicCollection(
            $this->fmap(function (MailDetailStruct $mail) {
                return $mail->getOrderState();
            })
        );
    }

    public function getAttachmentIds(): array
    {
        $ids = [];
        foreach ($this->elements as $element) {
            foreach ($element->getAttachments()->getIds() as $id) {
                $ids[] = $id;
            }
        }

        return $ids;
    }

    public function getAttachments(): MailAttachmentBasicCollection
    {
        $collection = new MailAttachmentBasicCollection();
        foreach ($this->elements as $element) {
            $collection->fill($element->getAttachments()->getElements());
        }

        return $collection;
    }

    public function getTranslationIds(): array
    {
        $ids = [];
        foreach ($this->elements as $element) {
            foreach ($element->getTranslations()->getIds() as $id) {
                $ids[] = $id;
            }
        }

        return $ids;
    }

    public function getTranslations(): MailTranslationBasicCollection
    {
        $collection = new MailTranslationBasicCollection();
        foreach ($this->elements as $element) {
            $collection->fill($element->getTranslations()->getElements());
        }

        return $collection;
    }

    protected function getExpectedClass(): string
    {
        return MailDetailStruct::class;
    }
}