<?php

namespace Alice\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->user_type == 'admin') {
            return true;
        } else {
            return false;
        }
    }

    protected function getValidatorInstance()
    {

        $validator = parent::getValidatorInstance();

        $validator->sometimes('alias','unique:articles|max:255', function($input) {
            if($this->route()->hasParameter('information')) {
                $alias = $this->route()->parameter('information');
                //dd($input->alias);
                return ($alias !== $input->alias) && !empty($input->alias);
            }
            return !empty($input->alias);
        });
        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'file' => 'image',
            'category_id' => 'required|integer'
        ];
    }
}
