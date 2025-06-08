<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Form</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/confirm.css') }}" />
</head>

<body>
    <header class="header">
        <div class="header__inner">
          <a class="header__logo" href="/">
          Fashionably Late
          </a>
        </div>
      </header>

  <main>
    <div class="confirm__content">
      <div class="confirm__heading">
        <h2>Confirm</h2>
      </div>
      <form class="form" action="/store" method="post">
        @csrf
        <div class="confirm-table">
          <table class="confirm-table__inner">
            <tr class="confirm-table__row">
              <th class="confirm-table__header">お名前</th>
              <td class="confirm-table__text">
                {{ $contact['last_name'] }} {{ $contact['first_name'] }}
                <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}">
                <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}">
              </td>
            </tr>

            <tr class="confirm-table__row">
              <th class="confirm-table__header">性別</th>
              <td class="confirm-table__text">
                {{ $contact['gender'] == 1 ? '男性' : ($contact['gender'] == 2 ? '女性' : 'その他') }}
                <input type="hidden" name="gender" value="{{ $contact['gender'] }}">
              </td>
            </tr>

            <tr class="confirm-table__row">
              <th class="confirm-table__header">メールアドレス</th>
              <td class="confirm-table__text">
                {{ $contact['email'] }}
                <input type="hidden" name="email" value="{{ $contact['email'] }}">
              </td>
            </tr>

            <tr class="confirm-table__row">
              <th class="confirm-table__header">電話番号</th>
              <td class="confirm-table__text">
                {{ $contact['tel'] }}
                <input type="hidden" name="tel" value="{{ $contact['tel'] }}">
              </td>
            </tr>

            <tr class="confirm-table__row">
              <th class="confirm-table__header">住所</th>
              <td class="confirm-table__text">
                {{ $contact['address'] }}
                <input type="hidden" name="address" value="{{ $contact['address'] }}">
              </td>
            </tr>

            <tr class="confirm-table__row">
              <th class="confirm-table__header">建物名</th>
              <td class="confirm-table__text">
                {{ $contact['building'] }}
                <input type="hidden" name="building" value="{{ $contact['building'] }}">
              </td>
            </tr>

            <tr class="confirm-table__row">
              <th class="confirm-table__header">お問い合わせの種類</th>
              <td class="confirm-table__text">
              {{ $categories->firstWhere('id', $contact['category_id'])->content ?? '未設定' }}
              <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
              </td>
            </tr>

            <tr class="confirm-table__row">
              <th class="confirm-table__header">お問い合わせ内容</th>
              <td class="confirm-table__text">
                {!! nl2br(e($contact['detail'])) !!}
                <input type="hidden" name="detail" value="{{ $contact['detail'] }}">
              </td>
            </tr>
          </table>
        </div>

        <button class="confirm__button-submit" type="submit">送信する</button>
      </form>

      <div class="confirm__buttons-wrapper">
        <form action="/edit" method="post" class="confirm__form--edit">
          @csrf
          <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}">
          <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}">
          <input type="hidden" name="gender" value="{{ $contact['gender'] }}">
          <input type="hidden" name="email" value="{{ $contact['email'] }}">
          <input type="hidden" name="tel_1" value="{{ $contact['tel_1'] }}">
          <input type="hidden" name="tel_2" value="{{ $contact['tel_2'] }}">
          <input type="hidden" name="tel_3" value="{{ $contact['tel_3'] }}">
          <input type="hidden" name="address" value="{{ $contact['address'] }}">
          <input type="hidden" name="building" value="{{ $contact['building'] }}">
          <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
          <input type="hidden" name="detail" value="{{ $contact['detail'] }}">
          <button class="confirm__button-back" type="submit">修正</button>
        </form>
      </div>
    </div>
  </main>
</body>

</html>
