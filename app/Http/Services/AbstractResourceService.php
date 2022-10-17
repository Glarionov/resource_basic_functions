<?php

namespace App\Http\Services;

use App\Http\Requests\AbstractUpdateOrCreateRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Request;
use voku\helper\ASCII;

class AbstractResourceService
{
    protected int $itemsPerPage = 20;

    protected Model $mainModel;

    public function __construct(Model $mainModel)
    {
        $this->mainModel = $mainModel;
    }

    /**
     * @param Request|null $request
     * @param array $filter
     * @return LengthAwarePaginator|ResourceCollection
     */
    public function list(Request $request = null, array $filter = [], array $withs = [], $orderBy = ['id', 'desc'])
    {
        $baseQuery = $this->mainModel::query();

        if ($filter) {
            $baseQuery->where($filter);
        }

        if ($withs) {
            foreach ($withs as $with) {
                $baseQuery->with($with);
            }
        }

        $baseQuery->orderBy($orderBy[0], $orderBy[1]);

        return $baseQuery->paginate($this->itemsPerPage);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $requestData
     * @return Model
     */
    public function store(array $requestData)
    {
        $object = new $this->mainModel;
        $object->fill($requestData);
        $object->save();
        return $object;
    }

    /**
     * Display the specified resource.
     *
     * @param Model $object
     * @return Model
     */
    public function show(Model $object): Model
    {
        return $object;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $request
     * @param Model $object
     * @return Model
     */
    public function update($request, Model $object): Model
    {
        $object->fill($request->all());
        $object->save();
        return $object;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Model $object
     * @return bool
     */

    public function destroy(Model $object): bool
    {
        return $object->delete();
    }
}
