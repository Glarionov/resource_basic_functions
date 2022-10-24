<?php

namespace App\Http\Resources;

use App\Models\Link;
use DateTime;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

abstract class AbstractResource extends JsonResource
{

    public $resource;


    const INCLUDE_ID = true;

    const SIMPLE_FIELDS = [];

    const PRETTY_DATE_FIELDS = [];

    const CHAIN_FIELDS = [];

    protected function doDefaultConversion($request)
    {
        $result = [];

        if (static::INCLUDE_ID) {
            $result['id'] = $this->resource->id;
        }

        foreach (static::SIMPLE_FIELDS as $field) {
            $result[$field] = $this->resource->{$field};
        }

        foreach (static::PRETTY_DATE_FIELDS as $field) {
            if (empty($this->resource->{$field})) {
                $result[$field] = null;
                continue;
            }
            $expireDate = new DateTime($this->resource->{$field});
            $result[$field] = $this->resource->{$field};
            $result[$field . '_pretty'] = $expireDate->format('d.m.Y');
        }

        foreach (static::CHAIN_FIELDS as $field => $fieldChain) {
            $currentPointer = &$this->resource;

            foreach ($fieldChain as $chainElement) {
                $currentPointer = $currentPointer->{$chainElement};
            }

            $result[$field] = $currentPointer;
        }
        return $result;
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     * @throws Exception
     */
    public function toArray($request): array
    {
        return $this->doDefaultConversion($request);
//        $expiresString = '';
//        $expiresStringPretty = '';
//
//        if ($this->resource->expires_at) {
//            $expireDate = new DateTime($this->resource->expires_at);
//            $expiresStringPretty = $expireDate->format('d.m.Y');
//            $expiresString = $this->resource->expires_at;
//        }
//
//        return [
//            'id' => $this->resource->id,
//            'text' => $this->resource->text,
//            'link' => route('get_image_by_link', ['uid' => $this->resource->text]),
//            'visits_left' => $this->resource->visits_left,
//            'expires_at' => $expiresString,
//            'expires_at_pretty' => $expiresStringPretty,
//            'image_id' => $this->resource->image->id,
//            'image_name' => $this->resource->image->name,
//        ];
    }
}
