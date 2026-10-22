<?php

namespace Rapidmail\ApiClient\Http;

use Psr\Http\Message\RequestInterface;

/**
 * Guzzle client throttle middleware
 */
class ThrottleMiddleware
{

    /**
     *  Singleton instance
     *
     * @var static|null
     */
    private static ?self $instance = null;

    /**
     * Interval in seconds
     *
     * @var float
     */
    private float $interval;

    /**
     * Number of requests per interval
     *
     * @var int
     */
    private int $requestsPerInterval;

    /**
     * @var float[]
     */
    private array $timestampStack = [];

    /**
     * Constructor
     *
     * @param float $interval Interval in seconds
     * @param int $requestsPerInterval
     */
    private function __construct(float $interval, int $requestsPerInterval)
    {

        $this->interval = $interval;
        $this->requestsPerInterval = $requestsPerInterval;
    }

    /**
     * Get a global instance
     *
     * @param float $interval Interval in seconds
     * @param int $requestsPerInterval
     * @return static
     */
    public static function getInstance(float $interval, int $requestsPerInterval): self
    {

        if (static::$instance === null) {
            static::$instance = new static($interval, $requestsPerInterval);
        }

        return static::$instance;
    }

    /**
     * Create the throttle middleware
     *
     * @param callable $handler
     * @return callable
     */
    public function __invoke(callable $handler): callable
    {

        return function (RequestInterface $request, array $options) use ($handler) {
            $this->throttle();

            return $handler($request, $options);
        };

    }

    /**
     * Apply throttling when requests per interval being exceeded
     */
    private function throttle(): void
    {

        $now = microtime(true);

        // Expire outdated

        $this->timestampStack = array_values(
            array_filter(
                $this->timestampStack,
                fn($last) => $now - $last < $this->interval
            )
        );

        // Sleep at least until oldest timestamp expires

        if (count($this->timestampStack) >= $this->requestsPerInterval) {

            usleep(
                (int) abs(
                    min($now - $this->timestampStack[0] - $this->interval, 0)
                ) * 1000000
            );

        }

        $this->timestampStack[] = microtime(true);

    }

}