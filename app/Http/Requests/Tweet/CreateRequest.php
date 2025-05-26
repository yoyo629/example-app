<?php

namespace App\Http\Requests\Tweet;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // 誰でもリクエストできるようにtrueに設定
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'tweet' => 'required|max:140',
            'images' => 'array|max:4', // 4件の制限
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' //1つの画像につき2MB
        ];
    }

    //今自分がログインしているユーザーを取得
    public function userId(): int
    {
        // Requestクラスのuser関数を使用
        return $this->user()->id;
    }

    public function tweet(): string
    {
        return $this->input('tweet');
    }

    public function images(): array
    {
        return $this->file('images', []);
    }
}
