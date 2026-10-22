<?php

namespace Rapidmail\ApiClient\Util;

class CallbackIterator implements \Iterator
{

    private \Iterator $iterator;

    private \Closure $callback;

    /**
     * Constructor
     *
     * @param \Iterator $iterator
     * @param \Closure $callback
     */
    public function __construct(\Iterator $iterator, \Closure $callback)
    {
        $this->iterator = $iterator;
        $this->callback = $callback;
    }

    /**
     * @inheritDoc
     */
    #[\ReturnTypeWillChange]
    public function current()
    {

        return ($this->callback)($this->iterator->current());

    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {
        $this->iterator->next();
    }

    /**
     * @inheritDoc
     */
    #[\ReturnTypeWillChange]
    public function key()
    {
        return $this->iterator->key();
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return $this->iterator->valid();
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        $this->iterator->rewind();
    }

}
