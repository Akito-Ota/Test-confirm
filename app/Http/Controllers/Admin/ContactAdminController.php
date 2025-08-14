<?php
namespace App\Http\Controllers;


use App\Http\Requests\Admin\ContactSearchRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactAdminController extends Controller
{
// 7件ずつ表示
private const PER_PAGE = 7;

public function index(ContactSearchRequest $request)
{
$q = Contact::query()->with('category'); // 既にリレーション作成済み想定

// キーワード（姓・名・フルネーム いずれもヒット可）
if ($kw = trim((string) $request->input('keyword'))) {
$q->where(function ($qq) use ($kw) {
$qq->where('first_name', 'like', "%{$kw}%")
->orWhere('last_name', 'like', "%{$kw}%")
->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$kw}%"]);
});
}

// メール
if ($email = $request->input('email')) {
$q->where('email', 'like', "%{$email}%");
}

// 性別（all のときは絞らない）
if (($gender = $request->input('gender','all')) !== 'all') {
$q->where('gender', (int)$gender);
}

// お問い合わせの種類
if ($cat = $request->input('category_id')) {
$q->where('category_id', (int)$cat);
}

// 日付範囲（created_at）
if ($from = $request->input('from')) $q->whereDate('created_at', '>=', $from);
if ($to = $request->input('to')) $q->whereDate('created_at', '<=', $to);

    $contacts=$q->orderByDesc('id')
    ->paginate(self::PER_PAGE)
    ->appends($request->query()); // ページングで検索条件維持

    return view('admin.contacts.index', [
    'contacts' => $contacts,
    'filters' => $request->validated() + ['gender' => $request->input('gender','all')],
    ]);
    }

    public function show(Contact $contact)
    {
    // モーダルで詳細表示するなら部分ビュー返却でもOK
    return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
    $contact->delete();
    return back()->with('message', '削除しました');
    }

    public function export(ContactSearchRequest $request): StreamedResponse
    {
    // index と同じ条件でクエリを作る
    $q = Contact::query()->with('category');
    if ($kw = trim((string) $request->input('keyword'))) {
    $q->where(function ($qq) use ($kw) {
    $qq->where('first_name', 'like', "%{$kw}%")
    ->orWhere('last_name', 'like', "%{$kw}%")
    ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$kw}%"]);
    });
    }
    if ($email = $request->input('email')) $q->where('email', 'like', "%{$email}%");
    if (($gender = $request->input('gender','all')) !== 'all') $q->where('gender', (int)$gender);
    if ($cat = $request->input('category_id')) $q->where('category_id', (int)$cat);
    if ($from = $request->input('from')) $q->whereDate('created_at', '>=', $from);
    if ($to = $request->input('to')) $q->whereDate('created_at', '<=', $to);

        $filename='contacts_' .now()->format('Ymd_His').'.csv';

        return response()->streamDownload(function () use ($q) {
        $out = fopen('php://output', 'w');
        // ヘッダ
        fputcsv($out, ['ID','氏名','性別','メール','電話番号','住所','建物名','種類','内容','作成日']);

        $q->orderBy('id')->chunk(500, function ($rows) use ($out) {
        foreach ($rows as $c) {
        fputcsv($out, [
        $c->id,
        $c->last_name.' '.$c->first_name,
        $this->genderLabel($c->gender),
        $c->email,
        $c->tel,
        $c->address,
        $c->building,
        optional($c->category)->content ?? '',
        $c->detail,
        $c->created_at->format('Y-m-d H:i'),
        ]);
        }
        });
        fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
        }

        private function genderLabel($value): string
        {
        return match ((int)$value) {
        0 => '男性', 1 => '女性', 9 => 'その他', default => '',
        };
        }
        }