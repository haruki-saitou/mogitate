<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $stopOnFirstFailure = false;
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $isStore = $this->routeIs('products.store');
        $isImageCleared = $this->input('image_is_cleared') == 1;

        $rules = [
            'name' => 'required',
            'price' => 'required|integer|min:0|max:10000',
            'seasons' => 'required',
            'description' => 'required|max:120',
            'image_is_cleared' => ['nullable', 'in:0,1']
        ];

        $imageRules = [
        'nullable',
        'mimes:png,jpeg',
        ];

        $rules['image_file'] = $imageRules;

        if ($isStore|| $isImageCleared) {
            $rules['image_file'][] = 'required';
        }

        return $rules;
    }


    public function messages() {
        return  [
            'name.required' => '商品名を入力してください',

            'price.required' => '値段を入力してください',
            'price.integer' => '数値で入力してください',
            'price.min' => '0〜10000円以内で入力してください',
            'price.max' => '0〜10000円以内で入力してください',

            'image_file.required' => '商品画像を登録してください',
            'image_file.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',

            'seasons.required' => '季節を選択してください',

            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
        ];
    }
}