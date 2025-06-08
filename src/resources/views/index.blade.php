<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Form</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
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
    <div class="contact-form__content">
      <div class="contact-form__heading">
        <h2>Contact</h2>
      </div>
      <form class="form" action="/confirm" method="post">
        @csrf
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">お名前</span>
            <span class="form__label--required">※</span>
          </div>
          <div class="form__group-content form__group-content--name">
            <div class="form__input--text__name-wrapper">
              <div class="form__input--text__name">
                <input type="text" name="last_name" placeholder="例：山田" value="{{ old('last_name')}}" />
              </div>
              <div class="form__error">
                @error('last_name')
                {{ $message }}
                @enderror
              </div>
            </div>
            <div class="form__input--text__name-wrapper">
              <div class="form__input--text__name">
                <input type="text" name="first_name" placeholder="例：太郎" value="{{ old('first_name')}}"/>
              </div>
              <div class="form__error">
                @error('first_name')
                {{ $message }}
                @enderror
              </div>
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">性別</span>
            <span class="form__label--required">※</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--radio">
                <label>
                    <input type="radio" name="gender" value="1" {{ old('gender', '1') == '1' ? 'checked' : '' }} />
                    男
                </label>
                <label>
                    <input type="radio" name="gender" value="2" {{ old('gender') == '2' ? 'checked' : '' }} />
                    女
                </label>
                <label>
                    <input type="radio" name="gender" value="3" {{ old('gender') == '3' ? 'checked' : '' }} />
                    その他
                </label>
            </div>
            <div class="form__error">
            @error('gender')
              {{ $message }}
              @enderror
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">メールアドレス</span>
            <span class="form__label--required">※</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--text">
              <input type="email" name="email" placeholder="test@example.com" value="{{ old('email')}}"/>
            </div>
            <div class="form__error">
            @error('email')
              {{ $message }}
            @enderror
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">電話番号</span>
            <span class="form__label--required">※</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--tel-group"> <div class="form__input--text__tel">
                <input type="tel" name="tel_1" id="tel_1" placeholder="090" value="{{ old('tel_1') }}" />
                <span>-</span>
                <input type="tel" name="tel_2" id="tel_2" placeholder="1234" value="{{ old('tel_2') }}" />
                <span>-</span>
                <input type="tel" name="tel_3" id="tel_3" placeholder="5678" value="{{ old('tel_3') }}" />
              </div>
              <input type="hidden" name="tel" id="tel" />
            </div>
            <div class="form__error form__error--tel">
              @error('tel_1')
                <div>{{ $message }}</div>
              @enderror
              @error('tel_2')
                <div>{{ $message }}</div>
              @enderror
              @error('tel_3')
                <div>{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">住所</span>
            <span class="form__label--required">※</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--text">
              <input type="text" name="address" placeholder="例：東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address')}}"/>
            </div>
            <div class="form__error">
              @error('address')
              {{$message}}
              @enderror
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">建物名</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--text">
              <input type="text" name="building" placeholder="千駄ヶ谷マンション101" value="{{ old('building')}}"/>
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">お問い合わせの種類</span>
            <span class="form__label--required">※</span>
          </div>
          <div class="form__group-content">
          <select name="category_id" id="category">
            <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>選択してください</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->content }}
              </option>
            @endforeach
          </select>
            <div class="form__error">
            @error('category_id')
                <span class="form_error">{{ $message }}</span>
            @enderror
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">お問い合わせ内容</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--textarea">
              <textarea name="detail" placeholder="お問合せ内容をご記載ください">{{ old('detail')}}</textarea>
            </div>
            <div class="form__error">
              @error('detail')
              {{$message}}
              @enderror
            </div>
          </div>
        </div>
        <div class="form__button">
          <button class="form__button-submit" type="submit">確認画面</button>
        </div>
      </form>
    </div>
  </main>
</body>

</html>
