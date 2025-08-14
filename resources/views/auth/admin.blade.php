@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin">

    <div class="admin__header">
        <h1>Admin</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn--sm">logout</button>
        </form>
    </div>

    {{-- 検索フォーム --}}
    <form method="GET" action="{{ route('admin.contacts.index') }}" class="search">
        <input type="text" name="keyword"
            value="{{ $filters['keyword'] ?? '' }}"
            placeholder="名前・フルネーム">

        <input type="text" name="email"
            value="{{ $filters['email'] ?? '' }}"
            placeholder="メールアドレス">

        @php($g = old('gender', $filters['gender'] ?? 'all'))
        <select name="gender">
            <option value="all" @selected($g==='all' )>全て</option>
            <option value="0" @selected($g==='0' )>男性</option>
            <option value="1" @selected($g==='1' )>女性</option>
            <option value="9" @selected($g==='9' )>その他</option>
        </select>

        <select name="category_id">
            <option value="">お問い合わせの種類(全て)</option>
            @foreach(\App\Models\Category::orderBy('id')->get() as $cat)
            <option value="{{ $cat->id }}"
                @selected((string)($filters['category_id'] ?? '' )===(string)$cat->id)>
                {{ $cat->content }}
            </option>
            @endforeach
        </select>

        <input type="date" name="from" value="{{ $filters['from'] ?? '' }}"> 〜
        <input type="date" name="to" value="{{ $filters['to']   ?? '' }}">

        <button class="btn" type="submit">検索</button>

        {{-- リセット：クエリを落として index に戻す --}}
        <a class="btn btn--ghost" href="{{ route('admin.contacts.index') }}">リセット</a>

        {{-- エクスポート：今の絞り込みを付けたまま --}}
        <a class="btn btn--secondary"
            href="{{ route('admin.contacts.export', request()->query()) }}">
            エクスポート
        </a>
    </form>

    <div class="pager-top">
        {{ $contacts->links() }}
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせの種類</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($contacts as $c)
            <tr>
                <td>{{ $c->last_name }} {{ $c->first_name }}</td>
                <td>{{ ['0'=>'男性','1'=>'女性','9'=>'その他'][$c->gender] ?? '' }}</td>
                <td>{{ $c->email }}</td>
                <td>{{ optional($c->category)->content }}</td>
                <td class="td-actions">
                    <button class="btn btn--sm" onclick="openDetail({{ $c->id }})">詳細</button>

                    <form action="{{ route('admin.contacts.destroy', $c) }}"
                        method="POST"
                        onsubmit="return confirm('削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn--danger btn--sm">削除</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">該当データがありません</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pager-bottom">
        {{ $contacts->links() }}
    </div>
</div>
@endsection