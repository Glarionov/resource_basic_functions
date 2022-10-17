<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractUpdateOrCreateRequest extends FormRequest
{
    /**
     * List of rules for "update" request
     * @var array
     */
    public array $updateRequestRules = [];

    /**
     * Fields required to be in "Create" requests
     * @var array
     */
    public array $requiredToCreateFields = [];

    /**
     * Adds "required" fields from $requiredToCreateFields to the $updateRequestRules
     * @return array
     */
    public function generateInputRequestArray(): array
    {
        $result = [];

        foreach ($this->updateRequestRules as $ruleIndex => $rule) {
            $result[$ruleIndex] = $rule;
            if (in_array($ruleIndex, $this->requiredToCreateFields)) {
                $result[$ruleIndex][] = 'required';
            }
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
            return $this->generateInputRequestArray();
        }

        return $this->updateRequestRules;
    }
}
