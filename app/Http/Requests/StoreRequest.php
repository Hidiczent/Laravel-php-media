<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('api')->user()->hasRole('super-admin|admin');

    }
    public function prepareForValidation()
    {
        if ($this->isMethod('put') && $this->routeIs('edit.store') || $this->isMethod('delete') && $this->routeIs('delete.store')){
            $this->merge([
                'id' => $this->route()->parameters['id']
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        //Delect
        if ($this->isMethod('delete') && $this->routeIs('delete.store')) {
            return [
                'id' => [
                    'required',
                    'numeric',
                    Rule::exists('stores', 'id')->whereNull('deleted_at')
                ]
            ];

        }

        if ($this->isMethod('post') && $this->routeIs('add.store')) {
            return [
                'name' => 'required|max:10',
                'email_contract' => 'required|email',
                'phone_number' => 'required|max:13',
                'address' => 'required',
                'logo' => 'required|mimes:png,jpg,jpeg|max:12040',
                'email' => [
                    'required',
                    Rule::unique('users', 'email')
                ]
            ];
        }

        //edit
        if ($this->isMethod('put') && $this->routeIs('edit.store')) {
            return [
                'id' => [
                    'required',
                    'numeric',
                    Rule::exists('stores', 'id')->whereNull('deleted_at')
                ],
                'name' => 'required|max:10',
                'email_contract' => 'required|email',
                'phone_number' => 'required|max:13',
                'address' => 'required',
                'logo' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            ];
        }
    }
    public function messages()
    {
        return [
            'name.required' => __('validation.required'),
            'name.unique' => __('validation.unique'),
            'name.max' => 'ບໍ່ເກິນ10',
            // 'email_contract.required' => 'ກາລູນາປ້ອນອີເມວຂອງທ່ານ ',
            // 'phone_number.required' => 'ກາລູນາປ້ອນເບີຂອງທ່ານ ',
            // 'address.required' => 'ກາລູນາປ້ອນທີ່ຢູ່ຂອງທ່ານ ',
            // 'logo.required' => 'ກາລູນາໃສ່ຮູບ ',

            'email.required' => __('validation.required'),
            'email.unique' => __('validation.unique')

        ];
    }
}