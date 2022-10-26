<?php

namespace App\Http\Services;

use App\Http\Requests\AbstractUpdateOrCreateRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use ReflectionClass;
use voku\helper\ASCII;

class AbstractResourceService
{
    const NOT_FOUND_ERROR = 'not_found';

    protected static int $itemsPerPage = 20;

    protected static string $mainModel;

    /**
     * @throws \ReflectionException
     */
    protected static function getSingularModelName()
    {
        $reflect = new ReflectionClass(static::$mainModel);

        return $reflect->getShortName();
    }

    /**
     * @param Request|null $request
     * @param array $filter
     * @return LengthAwarePaginator|ResourceCollection
     */
    public static function list(array $requestData = null, array $filter = [], array $withs = [], $orderBy = ['id', 'desc'])
    {
        $baseQuery = static::$mainModel::query();

        if ($filter) {
            $baseQuery->where($filter);
        }

        if ($withs) {
            foreach ($withs as $with) {
                $baseQuery->with($with);
            }
        }

        $baseQuery->orderBy($orderBy[0], $orderBy[1]);

        return ['mainObjects' => $baseQuery->paginate(static::$itemsPerPage)];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $requestData
     * @return array
     */
    public static function store(array $requestData)
    {
        $object = new static::$mainModel();
        $object->fill($requestData);
        $object->save();
        return ['success' => true, 'data' => $object];
    }

    /**
     * Display the specified resource.
     *
     * @param Model $object
     * @return array
     */
    public static function show(int $id): array
    {
        $object = static::$mainModel::find($id);

        if (!$object) {
            $message = "Can't find " . static::getSingularModelName() . " by ID $id";
            return ['success' => false, 'message' => $message, 'error_type' => static::NOT_FOUND_ERROR];
        }
        return ['success' => true, 'data' => $object];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $request
     * @param Model $object
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
        return ['success' => true, 'data' => $object];
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
}
