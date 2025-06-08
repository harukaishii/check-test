<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use Symfony\Component\HttpFoundation\StreamedResponse;


class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        $query->nameEmailSearch($request->input('keyword')) // Bladeで name="keyword" にする
              ->genderSearch($request->input('gender'))
              ->categorySearch($request->input('category_id')) // Bladeで name="category_id" にする
              ->dateSearchFrom($request->input('date_from')) // Bladeで name="date_from" にする
              ->dateSearchTo($request->input('date_to'));   // Bladeで name="date_to" にする

        // 必ずwith('category')を適用
        $contacts = $query->with('category')->paginate(7);

        // カテゴリリストは検索フォーム用
        $categories = Category::all();

        // モーダル表示用の詳細データを取得 (ここをビューを返す前に移動)
        $showingDetailContact = null;
        if ($request->has('show_detail')) {
            $showingDetailContact = Contact::with('category')->find($request->input('show_detail'));
            if (!$showingDetailContact) {
                // 存在しないIDが指定された場合は404
                abort(404);
            }
        }

        // 最後に一度だけビューを返す
        return view('admin', compact('contacts', 'categories', 'request', 'showingDetailContact'));
    }
    public function destroy($id)
    {
        $contact = Contact::find($id);

        if(!$contact){
            return redirect() ->route('admin.index')->with('error','指定されたお問い合わせは見つかりませんでした');

        }
        $contact->delete();

        return redirect()->route('admin.index')->with('success', '問い合わせが正常に削除されました。');
    }

    public function export(Request $request): StreamedResponse
{
    $query = Contact::query();

    $query->nameEmailSearch($request->input('keyword'))
          ->genderSearch($request->input('gender'))
          ->categorySearch($request->input('category_id'))
          ->dateSearchFrom($request->input('date_from'))
          ->dateSearchTo($request->input('date_to'));

    $contacts = $query->with('category')->get();

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="contacts.csv"',
    ];

    $columns = ['お名前', '性別', 'メールアドレス', 'お問い合わせの種類'];

    return response()->stream(function () use ($contacts, $columns) {
        $handle = fopen('php://output', 'w');

        // 文字化け防止のためBOMを追加（Excel対応）
        fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($handle, $columns);

        foreach ($contacts as $contact) {
            $fullName = $contact->last_name . ' ' . $contact->first_name;

            // genderの値を文字列に変換
            switch ($contact->gender) {
                case 1:
                    $genderText = '男性';
                    break;
                case 2:
                    $genderText = '女性';
                    break;
                case 3:
                    $genderText = 'その他';
                    break;
                default:
                    $genderText = '不明';
                    break;
            }

            fputcsv($handle, [
                $fullName,
                $genderText,
                $contact->email,
                optional($contact->category)->content,
            ]);
        }
        fclose($handle);
    }, 200, $headers);
}


}
