@extends('layouts.app')

    @section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') . '?v=' . filemtime(public_path('css/index.css')) }}" />
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success" id="flash-success-message">
            {{ session('success') }}
        </div>
    @endif
    @if ($is_empty ?? false)
        <div class="alert alert-danger" id="flash-error-message">
            「{{ $keyword }}」に一致する商品が見つかりませんでした。
        </div>
    @endif
    <div class="products-header">
        <h2>商品一覧</h2>
        <a href="{{ route('products.create') }}" class="products-header__btn">+ 商品登録</a>
    </div>

    <div class="products-layout">
        <aside class="products-filter">
            <form action="{{ route('products.search') }}" method="GET" id="search-sort-form">
                <div class="products-filter__input">
                    <input type="text" class="products-filter__input__text" name="keyword" placeholder="商品名で検索"
                        value="{{ old('keyword', $keyword ?? '') }}" />
                </div>
                <input type="hidden" name="sort" id="hidden-sort-input" value="{{ $sort ?? '' }}">
                <div class="products-filter__btn">
                    <button type="submit" class="btn-search" value="検索">
                        検索
                    </button>
                </div>
                <div class="products-filter__title">
                    <label for="sort" class="sort-title">価格順で表示</label>
                </div>
                <div class="select-wrapper">
                    <select id="sort" name="select__sort--ui">
                        <option value="" disabled selected hidden>価格で並べ替え</option>
                        <option value="price_asc" {{ ($sort ?? '') === 'price_asc' ? 'selected' : '' }}>低い順に表示</option>
                        <option value="price_desc" {{ ($sort ?? '') === 'price_desc' ? 'selected' : '' }}>高い順に表示</option>
                    </select>
                </div>
                <div id="sort-tag-wrapper">
                    <div id="sort-tag" class="sort-tag-item" style="display: none;">
                        <span id="sort-tag-text"></span>
                        <span id="sort-tag-close" class="sort-tag-close-btn">&times;</span>
                    </div>
                </div>
            </form>
        </aside>

        <section class="products-list">
            @foreach ($products as $product)
                <div class="product-card">
                    <a class="product-card__link" href="{{ route('products.show', $product->id) }}">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.png') }}"
                            class="product-image" />
                        <div class="product-card__info">
                            <p class="product-name">{{ $product->name }}</p>
                            <p class="product-price">
                                ¥{{ number_format($product->price) }}
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </section>
    </div>

    <div class="products-pagination">
        {{ $products->links('pagination::default') }}
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortSelect = document.getElementById('sort');
            const sortTag = document.getElementById('sort-tag');
            const sortTagText = document.getElementById('sort-tag-text');
            const sortTagCloseBtn = document.getElementById('sort-tag-close');
            const hiddenSortInput = document.getElementById('hidden-sort-input');
            const searchSortForm = document.getElementById('search-sort-form');


            sortSelect.addEventListener('change', function() {
                const selectedOption = sortSelect.options[sortSelect.selectedIndex];

                hiddenSortInput.value = selectedOption.value;


                if (sortSelect.value === "") {
                    sortTag.style.display = 'none';

                } else {
                    sortTagText.textContent = selectedOption.text;
                    sortTag.style.display = 'inline-flex';
                }

                searchSortForm.submit();

            });

            sortTagCloseBtn.addEventListener('click', function() {

                sortTag.style.display = 'none';

                sortSelect.value = "";
                hiddenSortInput.value = "";

                searchSortForm.submit();

            });

            if (hiddenSortInput.value !== "") {
                sortSelect.value = hiddenSortInput.value;

                const selectedOption = sortSelect.querySelector(`option[value="${hiddenSortInput.value}"]`);
                if (selectedOption) {
                    sortTagText.textContent = selectedOption.text;
                    sortTag.style.display = 'inline-flex';
                }
            }


        });
        function setupFlashMessage(id) {
            const flashMessage = document.getElementById(id);

            if (flashMessage) {
                setTimeout(() => {
                    flashMessage.classList.add('fade-out');
                }, 3000);

                flashMessage.addEventListener('transitionend', () => {
                    if (flashMessage.classList.contains('fade-out')) {
                        flashMessage.classList.add('hidden');
                    }
                });
            }
        }
        setupFlashMessage('flash-success-message');
        setupFlashMessage('flash-error-message');
    </script>
@endsection
