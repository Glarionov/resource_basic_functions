<?php

namespace App\Http\Services;

use App\Http\Requests\AbstractUpdateOrCreateRequest;
use App\Http\Resources\LinkCollection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Request;
use voku\helper\ASCII;

class AbstractAdvancedResourceService extends AbstractResourceService
{
    protected static int $itemsPerPage = 20;

    protected static string $mainModel;

    protected static string $mainCollection;

    protected static string $mainResource;

    protected static array $listSearchParams = [
        'user_id' => ['range', 'list']
    ];

    /**
     *
     *
     * @param $baseQuery
     * @param $requestData
     * @return void
     */
    protected static function applyDefaultFilters(&$baseQuery, $requestData, $isStringData = true) {
        foreach (static::$listSearchParams as $param => $paramConfig) {
            $baseQuery->where(function ($paramQuery) use ($param, $paramConfig, $requestData, $isStringData) {
                if (isset($requestData[$param])) {
                    $rawValue = $requestData[$param];
                    if (in_array('list', $paramConfig)) {
                        if ($isStringData) {
                            $valuesList = explode(',', $rawValue);
                        } else {
                            $valuesList = is_array($rawValue)? $rawValue: [$rawValue];
                        }
                    } else {
                        $valuesList = [$rawValue];
                    }

                    foreach ($valuesList as $value) {
                        $paramQuery->orWhere(function($paramSubQuery) use ($param, $value, $paramConfig, $isStringData) {
                            $filter = [];
                            $isSimple = empty($paramConfig) || in_array('simple', $paramConfig);
                            if ($isSimple) {
                                $filter[] = [$param, $value];
                            } else {
                                if (in_array('range', $paramConfig)) {
                                    if ($isStringData) {
                                        $values = explode('-', $value);
                                    } else {
                                        $values = $value;
                                    }

                                    $min = $values[0];
                                    $max = $values[1];
                                    if (!empty($min) || $min === 0) {
                                        $filter[] = [$param, '>=', $min];
                                    }
                                    if (!empty($max) || $max === 0) {
                                        $filter[] = [$param, '<=', $max];
                                    }
                                }
                            }
                            $paramSubQuery->orWhere($filter);
                        });
                    }
                }
            });
        }
    }

    /**
     * @param array|null $requestData
     * @param array $filter
     * @param array $withs
     * @param string[] $orderBy
     * @return LengthAwarePaginator|ResourceCollection
     */
    public static function list(array $requestData = null, array $filter = [], array $withs = [], $orderBy = ['id', 'desc'])
    {
        $baseQuery = static::$mainModel::query();

        static::applyDefaultFilters($baseQuery, $requestData);

        if ($filter) {
            $baseQuery->where($filter);
        }

        if ($withs) {
            foreach ($withs as $with) {
                $baseQuery->with($with);
            }
        }

        $baseQuery->orderBy($orderBy[0], $orderBy[1]);

        $paginationResult = $baseQuery->paginate(static::$itemsPerPage);

        if (!empty(static::$mainCollection)) {
            return new static::$mainCollection(
                $paginationResult
            );
        }
        return $paginationResult;
    }

    protected static function createResultFromObject($object)
    {
        if (!empty(static::$mainResource)) {
            $object =  new static::$mainResource(
                $object
            );
        }

        return ['success' => true, 'data' => $object];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $requestData
     * @return array
     */
    public static function store(array $requestData): array
    {
        $object = new static::$mainModel();
        $object->fill($requestData);
        $object->save();

        return static::createResultFromObject($object);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return array
     */
    public static function show(int $id): array
    {
        $object = static::$mainModel::find($id);

        if (!$object) {
            $message = "Can't find " . static::$mainModel . " by ID $id";
            return ['success' => false, 'message' => $message];
        }
        return static::createResultFromObject($object);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $requestData
     * @param int $id
     * @return array
     */
    public static function update($requestData, int $id): array
    {
        $objectData = static::show($id);
        if (!$objectData['success']) {
            return $objectData;
        }
        $object = $objectData['data'];

        $object->fill($requestData);
        $object->save();
        return static::createResultFromObject($object);
    }

    /**
     * Update resources in storage by filter
     *
     * @param array $requestData
     * @param array $filter
     * @return array
     */
    public static function updateByFilter(array $requestData, array $filter = []): array
    {
        $baseQuery = static::$mainModel::query();

        static::applyDefaultFilters($baseQuery, $requestData['filter'], false);
        if ($filter) {
            $baseQuery->where($filter);
        }

        $baseQuery->update($requestData['new_values']);

        return ['success' => true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return array
     */
    public static function destroy(int $id): array
    {
        $objectData = static::show($id);
        if (!$objectData['success']) {
            return $objectData;
        }
        $object = $objectData['data'];
        $object->delete();

        return ['success' => true];
    }

    /**
     * Remove resources from storage.
     *
     * @param array $requestData
     * @param array $filter
     * @return array
     */
    public static function destroyByFilter(array $requestData, array $filter = []): array
    {
        $baseQuery = static::$mainModel::query();

        static::applyDefaultFilters($baseQuery, $requestData, false);
        if ($filter) {
            $baseQuery->where($filter);
        }

        $baseQuery->delete();

        return ['success' => true];
    }
}
