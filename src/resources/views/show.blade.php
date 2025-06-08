<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ詳細 - FashionablyLate Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <header>
        <h1>FashionablyLate</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">logout</button>
        </form>
    </header>

    <main class="admin-container">
        <h2>お問い合わせ詳細</h2>

        <div class="detail-card">
            <table>
                <tr>
                    <th>お名前</th>
                    <td>{{ $contact->fullname ?? ($contact->last_name . ' ' . $contact->first_name) }}</td>
                </tr>
                <tr>
                    <th>性別</th>
                    <td>{{ $contact->gender == 1 ? '男性' : '女性' }}</td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td>{{ $contact->email }}</td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td>{{ $contact->tel }}</td>
                </tr>
                <tr>
                    <th>住所</th>
                    <td>{{ $contact->address }}</td>
                </tr>
                <tr>
                    <th>建物名</th>
                    <td>{{ $contact->building_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>お問い合わせの種類</th>
                    <td>{{ $contact->category->content ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>お問い合わせ内容</th>
                    <td>{{ $contact->detail }}</td>
                </tr>
            </table>
            <a href="{{ route('admin.index') }}" class="back-link">一覧に戻る</a>
        </div>

    </main>

    <style>
        /* detail-card のスタイルを admin.css に追加するか、ここに書く */
        .detail-card {
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            max-width: 600px;
            margin: 30px auto;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .detail-card table {
            width: 100%;
            border-collapse: collapse;
        }
        .detail-card th, .detail-card td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        .detail-card th {
            background-color: #f9f9f9;
            width: 35%;
        }
        .back-link {
            display: block;
            width: 150px;
            padding: 10px;
            margin-top: 20px;
            background-color: #555;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
        }
        .back-link:hover {
            background-color: #777;
        }
    </style>
</body>
</html>
