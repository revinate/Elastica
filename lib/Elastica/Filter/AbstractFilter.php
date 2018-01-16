<?php
namespace Elastica\Filter;

use Elastica\Exception\InvalidException;
use Elastica\Param;

/**
 * Abstract filter object. Should be extended by all filter types.
 *
 * @author Nicolas Ruflin <spam@ruflin.com>
 *
 * @link http://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-filters.html
 */
abstract class AbstractFilter extends Param
{
    /**
     * Sets the filter cache.
     *
     * @param bool $cached Cached
     *
     * @return $this
     */
    public function setCached($cached = true)
    {
        return $this->setParam('_cache', (bool) $cached);
    }

    /**
     * Sets the filter cache key.
     *
     * @param string $cacheKey Cache key
     *
     * @throws \Elastica\Exception\InvalidException If given key is empty
     *
     * @return $this
     */
    public function setCacheKey($cacheKey)
    {
        $cacheKey = (string) $cacheKey;

        if (empty($cacheKey)) {
            throw new InvalidException('Invalid parameter. Has to be a non empty string');
        }

        return $this->setParam('_cache_key', (string) $cacheKey);
    }

    /**
     * Sets the filter name.
     *
     * @param string $name Name
     *
     * @return $this
     */
    public function setName($name)
    {
        return $this->setParam('_name', $name);
    }


    /**
     * Disable the filter cache by default
     *
     * @inheritdoc
     */
    public function toArray() {
        if (! $this->hasParam('_cache') && $this->isSupportingCache()) {
            $this->setCached(true);
        }

        return parent::toArray();
    }

    /**
     * Is _cache supported
     *
     * @return bool
     */
    public function isSupportingCache() {
        return true;
    }
}
