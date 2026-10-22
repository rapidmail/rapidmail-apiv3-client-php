<?php

namespace Rapidmail\ApiClient\Service\Response;

use Rapidmail\ApiClient\Util\CallbackIterator;

class HalResponsePaginationIterator implements ResponseInterface, \Iterator, \Countable
{

    private HalResponse $initial;

    private ?HalResponse $current;

    /**
     * Constructor
     *
     * @param HalResponse $response
     */
    public function __construct(HalResponse $response)
    {
        $this->initial = $response;
        $this->current = $this->initial;
    }

    /**
     * @inheritDoc
     */
    public function current(): ?HalResponse
    {
        return $this->current;
    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {
        $this->current = $this->current->next();
    }

    /**
     * @inheritDoc
     */
    #[\ReturnTypeWillChange]
    public function key()
    {
        return $this->current['page'];
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return $this->current !== null;
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        $this->current = $this->initial;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return $this->current['page_count'];
    }

    /**
     * @return int
     */
    public function totalCount(): int
    {
        return $this->current['total_items'];
    }

    /**
     * @return array
     */
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
