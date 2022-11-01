<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractUpdateOrCreateRequest extends FormRequest
{
    /**
     * List of rules for "update" request
     * @var array
     */
    public static array $updateRequestRules = [];

    /**
     * Fields required to be in "Create" requests
     * @var array
     */
    public static array $requiredToCreateFields = [];

    /**
     * Adds "required" fields from $requiredToCreateFields to the $updateRequestRules
     * @return array
     */
    public static function generateInputRequestArray(): array
    {
        $result = [];

        foreach (static::$updateRequestRules as $ruleIndex => $rule) {
            $result[$ruleIndex] = $rule;
            if (in_array($ruleIndex, static::$requiredToCreateFields)) {
                $result[$ruleIndex][] = 'required';
            }
        }

        $otherKeys = array_diff(static::$requiredToCreateFields, array_keys(static::$updateRequestRules));

        foreach ($otherKeys as $ruleIndex) {
            $result[$ruleIndex] = ['required'];
        }

        return $result;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return static::generateInputRequestArray();
        }

        return $this->updateRequestRules;
    }
}
