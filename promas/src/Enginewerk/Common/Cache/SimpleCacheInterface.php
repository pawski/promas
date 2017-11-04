<?php
declare(strict_types=1);
namespace Enginewerk\Common\Cache;

interface SimpleCacheInterface
{
    /**
     * @param object|array|string $cacheable
     * @param string|null $key If key is empty it will be generated
     *
     * @return null|string
     */
    public function write($cacheable, string $key = null):? string;

    /**
     * @param string $key
     *
     * @return object|array|string|null
     */
    public function read(string $key);

    /**
     * @param string $key
     *
     * @return bool
     */
    public function remove(string $key): bool;
}

