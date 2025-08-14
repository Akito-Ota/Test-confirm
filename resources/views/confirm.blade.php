@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@php
// 性別表記
$genderLabel = [
0 => '男性',
1 => '女性',
2 => 'その他',
][$contact['gender'] ?? 0] ?? '-';

// 名前は姓と名の間に半角スペース
$fullName = trim(($contact['last_name'] ?? '').' '.($contact['first_name'] ?? ''));
@endphp

@section('content')
<div class="confirm">
    <h2 class="confirm__title">Confirm</h2>

    <table class="confirm__table">
        <tbody>
            <tr>
                <th>お名前</th>
                <td>{{ $fullName }}</td>
            </tr>
            <tr>
                <th>性別</th>
                <td>{{ $genderLabel }}</td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td>{{ $contact['email'] ?? '' }}</td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td>{{ $contact['tel'] ?? '' }}</td>
            </tr>
            <tr>
                <th>住所</th>
                <td>{{ $contact['address'] ?? '' }}</td>
            </tr>
            <tr>
                <th>建物名</th>
                <td>{{ $contact['building'] ?? '' }}</td>
            </tr>
            <tr>
                <th>お問い合わせの種類</th>
                <td>
                    {{-- 必要に応じてカテゴリIDをラベル化 --}}
                    {{ $contact['category_id'] ?? '' }}
                </td>
            </tr>
            <tr>
                <th>お問い合わせ内容</th>
                <td class="pre">{{ $contact['detail'] ?? '' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="confirm__actions">
        {{-- 送信：hidden に詰めて store へ --}}
        <form method="POST" action="{{ route('contact.store') }}" class="inline">
            @csrf
            @foreach ($contact as $key => $val)
            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
            @endforeach
            <button type="submit" class="btn btn--primary">送信</button>
        </form>

        {{-- 修正：GET / に戻る（confirm で flash してあるので old() が復元される）--}}
        <form method="GET" action="{{ route('contact.create') }}" class="inline">
            <button type="submit" class="btn btn--ghost">修正</button>
        </form>
    </div>
</div>
@endsection