<?php

namespace Rapidmail\ApiClient\Util;

class CallbackIterator implements \Iterator
{

    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * @var \Closure
     */
    private $callback;

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
    public function current()
    {

        return $this->callback->__invoke(
            $this->iterator->current()
        );

    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        $this->iterator->next();
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->iterator->key();
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return $this->iterator->valid();
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->iterator->rewind();
    }

}