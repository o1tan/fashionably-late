@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<main class="admin">
    <div class="admin__inner">
        <h2 class="admin__title">Admin</h2>

        <form class="search-form" action="/admin" method="get">
            <input
                class="search-form__input"
                type="text"
                name="keyword"
                value="{{ request('keyword') }}"
                placeholder="名前やメールアドレスを入力してください"
            >

            <select class="search-form__select" name="gender">
                <option value="">性別</option>
                <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
            </select>

            <select class="search-form__select" name="category_id">
                <option value="">お問い合わせの種類</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->content }}
                    </option>
                @endforeach
            </select>

            <input
                class="search-form__date"
                type="date"
                name="date"
                value="{{ request('date') }}"
            >

            <button class="search-form__button" type="submit">検索</button>

            <a class="search-form__reset" href="{{ route('admin.index') }}">リセット</a>
        </form>

        <table class="admin-table">
            <tr class="admin-table__row">
                <th class="admin-table__header">お名前</th>
                <th class="admin-table__header">性別</th>
                <th class="admin-table__header">メールアドレス</th>
                <th class="admin-table__header">お問い合わせの種類</th>
                <th class="admin-table__header"></th>
            </tr>

            @foreach ($contacts as $contact)
                <tr class="admin-table__row">
                    <td class="admin-table__text">
                        {{ $contact->last_name }} {{ $contact->first_name }}
                    </td>
                    <td class="admin-table__text">
                        @if ($contact->gender == 1)
                            男性
                        @elseif ($contact->gender == 2)
                            女性
                        @else
                            その他
                        @endif
                    </td>
                    <td class="admin-table__text">
                        {{ $contact->email }}
                    </td>
                    <td class="admin-table__text">
                        {{ $contact->category->content ?? '' }}
                    </td>
                    <td class="admin-table__text">
                        <button
                            class="detail-button"
                            type="button"
                            onclick="document.getElementById('detail-modal-{{ $contact->id }}').showModal()"
                        >
                            詳細
                        </button>
                    </td>
                </tr>
            @endforeach
        </table>

        @foreach ($contacts as $contact)
            <dialog class="detail-modal" id="detail-modal-{{ $contact->id }}">
                <div class="detail-modal__content">
                    <button
                        class="detail-modal__close"
                        type="button"
                        onclick="document.getElementById('detail-modal-{{ $contact->id }}').close()"
                    >
                        ×
                    </button>

                    <dl class="detail-modal__list">
                        <div class="detail-modal__item">
                            <dt class="detail-modal__label">お名前</dt>
                            <dd class="detail-modal__text">
                                {{ $contact->last_name }} {{ $contact->first_name }}
                            </dd>
                        </div>

                        <div class="detail-modal__item">
                            <dt class="detail-modal__label">性別</dt>
                            <dd class="detail-modal__text">
                                @if ($contact->gender == 1)
                                    男性
                                @elseif ($contact->gender == 2)
                                    女性
                                @else
                                    その他
                                @endif
                            </dd>
                        </div>

                        <div class="detail-modal__item">
                            <dt class="detail-modal__label">メールアドレス</dt>
                            <dd class="detail-modal__text">
                                {{ $contact->email }}
                            </dd>
                        </div>

                        <div class="detail-modal__item">
                            <dt class="detail-modal__label">電話番号</dt>
                            <dd class="detail-modal__text">
                                {{ $contact->tel }}
                            </dd>
                        </div>

                        <div class="detail-modal__item">
                            <dt class="detail-modal__label">住所</dt>
                            <dd class="detail-modal__text">
                                {{ $contact->address }}
                            </dd>
                        </div>

                        <div class="detail-modal__item">
                            <dt class="detail-modal__label">建物名</dt>
                            <dd class="detail-modal__text">
                                {{ $contact->building }}
                            </dd>
                        </div>

                        <div class="detail-modal__item">
                            <dt class="detail-modal__label">お問い合わせの種類</dt>
                            <dd class="detail-modal__text">
                                {{ $contact->category->content ?? '' }}
                            </dd>
                        </div>

                        <div class="detail-modal__item">
                            <dt class="detail-modal__label">お問い合わせ内容</dt>
                            <dd class="detail-modal__text">
                                {{ $contact->detail }}
                            </dd>
                        </div>
                    </dl>
                    <form class="delete-form" action="{{ route('admin.destroy') }}" method="post">
                        @csrf
                        @method('DELETE')

                        <input type="hidden" name="id" value="{{ $contact->id }}">

                        <button
                            class="delete-form__button"
                            type="submit"
                            onclick="return confirm('削除してもよろしいですか？')"
                        >
                            削除
                        </button>
                    </form>
                </div>
            </dialog>
        @endforeach

        @if ($contacts->hasPages())
            <div class="pagination">
                @if ($contacts->onFirstPage())
                    <span class="pagination__link pagination__link--disabled">&lt;</span>
                @else
                    <a class="pagination__link" href="{{ $contacts->previousPageUrl() }}">&lt;</a>
                @endif

                @for ($i = 1; $i <= $contacts->lastPage(); $i++)
                    @if ($i == $contacts->currentPage())
                        <span class="pagination__link pagination__link--active">{{ $i }}</span>
                    @else
                        <a class="pagination__link" href="{{ $contacts->url($i) }}">{{ $i }}</a>
                    @endif
                @endfor

                @if ($contacts->hasMorePages())
                    <a class="pagination__link" href="{{ $contacts->nextPageUrl() }}">&gt;</a>
                @else
                    <span class="pagination__link pagination__link--disabled">&gt;</span>
                @endif
            </div>
        @endif
    </div>
</main>
@endsection