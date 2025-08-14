@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
<div class="contact">
    <h2 class="contact__title">Contact</h2>

    @if ($errors->any())
    <div class="form__errors">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <form action="{{ route('contacts.confirm') }}" method="POST" class="contact__form" novalidate>
        @csrf


        <div class="form__row">
            <label class="form__label">お名前 <span class="req">*</span></label>
            <div class="form__cols">
                <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="例: 山田" class="input w-1/2">
                <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="例: 太郎" class="input w-1/2 ml-2">
            </div>
            @error('last_name') <p class="form__error">{{ $message }}</p> @enderror
            @error('first_name') <p class="form__error">{{ $message }}</p> @enderror
        </div>


        <div class="form__row">
            <label class="form__label">性別 <span class="req">*</span></label>
            <div class="radios">
                <label><input type="radio" name="gender" value="0" {{ old('gender','0')==='0' ? 'checked' : '' }}> 男性</label>
                <label><input type="radio" name="gender" value="1" {{ old('gender')==='1' ? 'checked' : '' }}> 女性</label>
                <label><input type="radio" name="gender" value="2" {{ old('gender')==='2' ? 'checked' : '' }}> その他</label>
            </div>
            @error('gender') <p class="form__error">{{ $message }}</p> @enderror
        </div>

        <div class="form__row">
            <label class="form__label">メールアドレス <span class="req">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="例: test@example.com" class="input">
            @error('email') <p class="form__error">{{ $message }}</p> @enderror
        </div>

        <div class="form__row">
            <label class="form__label">電話番号 <span class="req">*</span></label>
            <div class="tel-group">
                <input type="text" name="tel1" value="{{ old('tel1') }}" class="input tel"> ー
                <input type="text" name="tel2" value="{{ old('tel2') }}" class="input tel"> ー
                <input type="text" name="tel3" value="{{ old('tel3') }}" class="input tel">
            </div>
            @error('tel1') <p class="form__error">{{ $message }}</p> @enderror
            @error('tel2') <p class="form__error">{{ $message }}</p> @enderror
            @error('tel3') <p class="form__error">{{ $message }}</p> @enderror
        </div>

        <div class="form__row">
            <label class="form__label">住所</label>
            <input type="text" name="address" value="{{ old('address') }}" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" class="input">
            @error('address') <p class="form__error">{{ $message }}</p> @enderror
        </div>

        <div class="form__row">
            <label class="form__label">建物名</label>
            <input type="text" name="building" value="{{ old('building') }}" placeholder="例: 千駄ヶ谷マンション101" class="input">
            @error('building') <p class="form__error">{{ $message }}</p> @enderror
        </div>

        <div class="form__row">
            <label class="form__label">お問い合わせの種類 <span class="req">*</span></label>
            <select name="category_id" class="input">
                <option value="">選択してください</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->content }}
                </option>
                @endforeach
            </select>
            @error('category_id') <p class="form__error">{{ $message }}</p> @enderror
        </div>


        <div class="form__row">
            <label class="form__label">お問い合わせ内容 <span class="req">*</span></label>
            <textarea name="detail" rows="6" class="input" placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
            @error('detail') <p class="form__error">{{ $message }}</p> @enderror
        </div>


        <div class="form__actions">
            <button type="submit" class="btn btn--primary">確認画面</button>
        </div>
    </form>
</div>
@endsection