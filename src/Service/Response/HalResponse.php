<?php

namespace Rapidmail\ApiClient\Service\Response;

use Rapidmail\ApiClient\Exception\ApiException;
use Rapidmail\ApiClient\Exception\NotImplementedException;
use Rapidmail\ApiClient\Http\HttpClientInterface;

class HalResponse implements ResponseInterface, \ArrayAccess, \IteratorAggregate
{

    private HttpClientInterface $client;

    private ResponseFactory $responseFactory;

    private array $links = [];

    private array $data = [];

    /**
     * Constructor
     */
    public function __construct(HttpClientInterface $client, ResponseFactory $responseFactory, array $data = [])
    {

        $this->client = $client;
        $this->responseFactory = $responseFactory;

        if (isset($data['_links'])) {
            $this->links = $data['_links'];
            unset($data['_links']);
        }

        $this->data = array_map(
            fn($item) => is_array($item) ? new static($this->client, $this->responseFactory, $item) : $item,
            $data
        );
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    /**
     * @inheritDoc
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
    {
        throw new NotImplementedException('Write access is not implemented for ' . static::class);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset): void
    {
        throw new NotImplementedException('Write access is not implemented for ' . static::class);
    }

    public function toArray(): array
    {

        return array_map(
            fn($item) => $item instanceof static ? $item->toArray() : $item,
            $this->data
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

    /**
     * @return HalResponse
     */
    public function self(): self
    {
        return $this;
    }

    /**
     * @return HalResponse|null
     * @throws ApiException
     */
    public function next(): ?self
    {
        return $this->navigate('next');
    }

    /**
     * @return HalResponse|null
     * @throws ApiException
     */
    public function prev(): ?self
    {
        return $this->navigate('prev');
    }

    /**
     * @return HalResponse|null
     * @throws ApiException
     */
    public function first(): ?self
    {
        return $this->navigate('first');
    }

    /**
     * @return HalResponse|null
     * @throws ApiException
     */
    public function last(): ?self
    {
        return $this->navigate('last');
    }

    /**
     * Navigate Hal links
     *
     * @return HalResponse|null
     * @throws ApiException
     */
    protected function navigate(string $target): ?self
    {

        if (!isset($this->links[$target]) || !isset($this->links[$target]['href'])) {
            return null;
        }

        return $this->responseFactory->newHalResponse(
            $this->client,
            $this
                ->client
                ->request(
                    'GET',
                    $this->links[$target]['href']
                )
        );

    }

    /**
     * @inheritDoc
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->data);
    }

}
