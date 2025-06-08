@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin__content">
      <h2 class="admin__title">Admin</h2>

      <div class="admin__panel">
        <form class="form" action="{{ route('admin.index') }}" method="GET">
          <div class="admin-search__form-group">
            <div class="admin-search__form-item admin-search__form-item--text">
              <input type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" />
            </div>
            <div class="admin-search__form-item admin-search__form-item--select">
                <select name="gender">
                    <option value="">性別</option>
                    <option value="1" {{ (string)request('gender') === '1' ? 'selected' : '' }}>男性</option>
                    <option value="2" {{ (string)request('gender') === '2' ? 'selected' : '' }}>女性</option>
                    <option value="3" {{ (string)request('gender') === '3' ? 'selected' : '' }}>その他</option>
                  </select>
            </div>
            <div class="admin-search__form-item admin-search__form-item--select">
                <select name="category_id">
                    <option value="">選択してください</option>
                    @foreach($categories as $category)
                      <option value="{{ $category->id }}" {{ (string)request('category_id') === (string)$category->id ? 'selected' : '' }}>
                        {{ $category->content }}
                      </option>
                    @endforeach
                  </select>
            </div>
            <div class="admin-search__form-item admin-search__form-item--date">
              <input type="date" name="date" />
            </div>
            <div class="admin-search__buttons">
                <button class="admin__button-submit-search" type="submit">検索</button>
                <a href="{{ route('admin.index') }}" class="admin__button-submit-reset">リセット</a>
            </div>
        </div>

        </form>

<!-- CSV出力ボタン（検索条件付き） -->
        <form method="GET" action="{{ route('admin.export') }}">
            <input type="hidden" name="keyword" value="{{ request('keyword') }}">
            <button class="admin__export-button" type="submit">エクスポート</button>
        </form>

        <div class="admin__results">
          <div class="admin__pagination">
            {{ $contacts->appends(request()->query())->links() }}
          </div>

          <div class="admin-table">
            <table class="admin-table__inner">
                <tr class="admin-table__row">
                    <th class="admin-table__header">お名前</th>
                    <th class="admin-table__header">性別</th>
                    <th class="admin-table__header">メールアドレス</th>
                    <th class="admin-table__header">お問い合わせの種類</th>
                    <th class="admin-table__header"></th>
                </tr>
                @foreach ($contacts as $contact)
                    <tr class="admin-table__row">
                        <td class="admin-table__item">{{ $contact['last_name'] }} {{ $contact['first_name'] }}</td>
                        <td class="admin-table__item">
                            {{ $contact['gender'] == 1 ? '男性' : ($contact['gender'] == 2 ? '女性' : 'その他') }}
                        </td>
                        <td class="admin-table__item">{{ $contact->email }}</td>
                        <td class="admin-table__item">
                            {{ $categories->firstWhere('id', $contact['category_id'])->content ?? '未設定' }}
                        </td>
                        <td class="admin-table__item">
                            <a href="{{ route('admin.index', ['show_detail' => $contact->id]) }}" class="detail__button ">詳細</a>
                        </td>
                    </tr>
                @endforeach
          </table>
        </div>
      </div>
      @if ($showingDetailContact)
        <div class="modal-overlay show-modal"></div>
        <div class="modal-content-php show-modal">
            {{-- 閉じるボタンは、show_detailパラメータをクリアしてページをリロードするリンク --}}
            <a href="{{ route('admin.index', array_filter(request()->except('show_detail'))) }}" class="close-button">&times;</a>

            <table class="detail-table">
                <tr>
                    <th>お名前</th>
                    <td>{{ $showingDetailContact->fullname ?? ($showingDetailContact->last_name . ' ' . $showingDetailContact->first_name) }}</td>
                </tr>
                <tr>
                    <th>性別</th>
                    <td>
                        @if ($showingDetailContact->gender == 1)
                            男性
                        @elseif ($showingDetailContact->gender == 2)
                            女性
                        @else
                            その他
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td>{{ $showingDetailContact->email }}</td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td>{{ $showingDetailContact->tel }}</td>
                </tr>
                <tr>
                    <th>住所</th>
                    <td>{{ $showingDetailContact->address }}</td>
                </tr>
                <tr>
                    <th>建物名</th>
                    <td>{{ $showingDetailContact->building_name ?? '' }}</td>
                </tr>
                <tr>
                    <th>お問い合わせの種類</th>
                    <td>{{ $showingDetailContact->category->content ?? '' }}</td>
                </tr>
                <tr>
                    <th>お問い合わせ内容</th>
                    <td>{{ $showingDetailContact->detail }}</td>
                </tr>
            </table>

            <div class="modal-actions">
                <form action="{{ route('contacts.delete', ['id' => $showingDetailContact->id]) }}" method="POST" class="delete-form"> {{-- 削除用のフォームに変更 --}}
                    @csrf
                    @method('DELETE') {{-- DELETEメソッドで送信 --}}
                    <button type="submit" class="admin__delete-button">削除</button>
                </form>
            </div>

        </div>
    @endif

    </div>
    @endsection
