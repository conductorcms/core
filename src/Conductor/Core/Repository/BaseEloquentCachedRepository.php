<?php namespace Conductor\Core\Repository;

use Illuminate\Cache\Repository as Cache;

class BaseEloquentCachedRepository implements BaseRepository {

    /**
     * The cache class
     *
     * @var Cache
     */
    private $cache;

    /**
     * The repository in use
     *
     * @var repository
     */
    private $repository;

    /**
     * The cache prefix (e.g 'pages')
     * @var
     */
    private $cachePrefix;

    /**
     * Setup the class
     *
     * @param Cache $cache
     * @param $repository
     * @param $cachePrefix
     */
    function __construct(Cache $cache, $repository, $cachePrefix)
    {
        $this->cache = $cache;
        $this->repository = $repository;
        $this->cachePrefix = $cachePrefix;
    }

    /**
     * Store all records in cache
     *
     * @return mixed
     */
    public function getAll()
    {
        return $this->cache->rememberForever($this->cachePrefix . ' :all', function()
        {
           return $this->repository->getAll();
        });
    }

    /**
     * Store record by id in cache
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->cache->rememberForever($this->cachePrefix . ' :' . $id, function() use ($id)
        {
            return $this->repository->find($id);
        });
    }

    /**
     * Store record with relationships in cache
     *
     * @param $id
     * @param array $relationships
     * @return mixed
     */

    public function findWithRelationships($id, array $relationships)
    {
        $cacheKey = $this->makeCacheKey($id, $relationships);

        return $this->cache->rememberForever($cacheKey, function() use ($id, $relationships)
        {
            return $this->repository->findWithRelationship($id, $relationships);
        });
    }

    /**
     * Clear cache and create record
     *
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        $this->clearCacheAll();

        return $this->repository->create($data);
    }

    /**
     * Clear cache and update record
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $this->clearCacheAll();
        $this->clearCacheId($id);

        return $this->repository->update($id, $data);
    }

    /**
     * Clear cache and delete record
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $this->clearCacheAll();
        $this->clearCacheId($id);

        return $this->repository->destroy($id);
    }

    /**
     * Clear cache and delete many records
     *
     * @param array $ids
     */
    public function destroyFromArray(array $ids)
    {
        $this->clearCacheAll();
        $this->clearCacheIdArray($ids);

        $this->repository->destroyFromArray($ids);
    }

    /**
     * Prepare the cache key for relationships
     *
     * @param $id
     * @param array $relationships
     * @return string
     */
    private function makeCacheKey($id, array $relationships)
    {
        $cacheKey = $this->cachePrefix . ':' . $id . ':with:';

        foreach($relationships as $relationship)
        {
            $cacheKey .= $relationship . ',';
        }

        return rtrim($cacheKey, ",");
    }

    /**
     * Clear the :all cache record
     *
     * @return mixed
     */
    private function clearCacheAll()
    {
        return $this->cache->forget($this->cachePrefix . ' :all');
    }

    /**
     * Clear id cache record
     *
     * @param $id
     * @return mixed
     */
    private function clearCacheId($id)
    {
        return $this->cache->forget($this->cachePrefix . ' :' . $id);
    }

    /**
     * Clear many id cache records
     *
     * @param $ids
     * @return bool
     */
    private function clearCacheIdArray($ids)
    {
        foreach($ids as $id)
        {
            $this->cache->forget($this->cachePrefix . ' :' . $id);
        }

        return true;
    }
}