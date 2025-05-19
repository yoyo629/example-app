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
            'tweet' => 'required|max:140'
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
}
