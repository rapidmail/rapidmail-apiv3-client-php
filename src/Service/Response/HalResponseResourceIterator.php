<?php

namespace Rapidmail\ApiClient\Service\Response;

use Rapidmail\ApiClient\Util\CallbackIterator;

/**
 * Iterate all resources within a paged HAL response collection
 */
class HalResponseResourceIterator implements ResponseInterface, \Iterator, \Countable
{

    private int $currentIndex = 0;

    private ?\Iterator $currentResourceIterator = null;

    private HalResponsePaginationIterator $responseCollection;

    private string $embeddedResourcePathKey;

    /**
     * Constructor
     */
    public function __construct(
        HalResponsePaginationIterator $responseCollection,
        string $embeddedResourcePathKey
    ) {
        $this->responseCollection = $responseCollection;
        $this->embeddedResourcePathKey = $embeddedResourcePathKey;
    }

    /**
     * @inheritDoc
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->currentResourceIterator->current();
    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {

        $this->currentResourceIterator->next();

        if (!$this->currentResourceIterator->valid()) {
            $this->responseCollection->next();
            $this->currentResourceIterator = $this->createIteratorFromInnerResource();
        }

        $this->currentIndex++;

    }

    /**
     * @inheritDoc
     */
    public function key(): int
    {
        return $this->currentIndex;
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return $this->currentResourceIterator !== null && $this->currentResourceIterator->valid();
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        $this->currentIndex = 0;
        $this->responseCollection->rewind();
        $this->currentResourceIterator = $this->createIteratorFromInnerResource();
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return $this->responseCollection->totalCount();
    }

    private function createIteratorFromInnerResource(): ?\Iterator
    {

        if (!$this->responseCollection->valid()) {
            return null;
        }

        /** @var HalResponse $halResponse */
        $halResponse = $this->responseCollection->current();

        $canAccessInnerResources = isset($halResponse['_embedded'])
            && isset($halResponse['_embedded'][$this->embeddedResourcePathKey]);

        if (!$canAccessInnerResources) {
            return null;
        }

        $innerResource = $halResponse['_embedded'][$this->embeddedResourcePathKey];

        if (!$innerResource instanceof HalResponse) {
            return null;
        }

        return $innerResource->getIterator();

    }

    protected function toArray(): array
    {

        return iterator_to_array(
            new CallbackIterator(
                $this,
                fn($item) => $item instanceof HalResponse ? $item->toArray() : $item
            )
        );

    }

    /**
     * @inheritDoc
     */
    public function __debugInfo(): array
    {
        return $this->toArray();
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return print_r($this->toArray(), true);
    }

}
