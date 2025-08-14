<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactSearchRequest extends FormRequest
{
public function authorize(): bool { return true; }

public function rules(): array
{
return [
'keyword' => ['nullable','string','max:255'], // 氏名・フルネーム
'email' => ['nullable','email','max:255'],
'gender' => ['nullable','in:all,0,1,9'], // all=全て, 0=男性,1=女性,9=その他（あなたの実装に合わせて）
'category_id' => ['nullable','integer','exists:categories,id'],
'from' => ['nullable','date'],
'to' => ['nullable','date','after_or_equal:from'],
];
}
}