@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/create.css') . '?v=' . filemtime(public_path('css/create.css')) }}" />
@endsection

@section('content')
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="register">
            <h2>商品登録</h2>

            <div class="register__form">

                {{-- 1. 商品名 --}}
                <div class="register__form-group">
                    <div class="register__form-label">
                        <label for="name">商品名<span class="required-mark">必須</span></label>
                    </div>
                    <div class="register__form-input">
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            placeholder="商品名を入力" />
                    </div>
                </div>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                {{-- 2. 価格 --}}
                <div class="register__form-group">
                    <div class="register__form-label">
                        <label for="price">値段<span class="required-mark">必須</span></label>
                    </div>
                    <div class="register__form-input">
                        <input type="number" name="price" id="price" value="{{ old('price') }}"
                            placeholder="価格を入力" />
                    </div>
                </div>
                @error('price')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                {{-- 3. 商品画像 --}}
                <div class="register__form-group register__form-image">
                    <label for="image_file">商品画像<span class="required-mark">必須</span></label>

                    {{-- 画像プレビュー、ファイル名、ボタンを縦に並べるためのコンテナ --}}
                    <div class="image-upload-wrapper">

                        {{-- プレビュー画像 --}}
                        <div class="image-preview-area">
                            <img id="image_preview" src="{{ asset('images/no-image.png') }}" alt="画像プレビュー">
                        </div>

                        {{-- ファイル選択UI（ファイル名表示とカスタムボタン） --}}
                        <div class="file-select-ui">

                            {{-- カスタムファイル選択ボタン --}}
                            <label for="image_file" class="custom-file-select-button small-button">
                                ファイルを選択
                            </label>

                            {{-- 実際のファイルインプット (非表示) --}}
                            <input type="file" name="image_file" id="image_file" class="hidden-file-input" />
                            {{-- 選択後のファイル名 / 未選択時のプレースホルダー --}}
                            <span id="file-name-display" class="file-name-display">ファイルを選択</span>
                        </div>
                    </div>
                </div>
                @error('image_file')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                {{-- 4. 季節（チェックボックス） --}}
                <div class="register__form-group register__form-season">
                    {{-- グループを fieldset で囲む --}}
                    <fieldset class="season-group">
                        {{-- labelの代わりに legend を使用する --}}
                        <legend>季節<span class="required-mark">必須</span><span class="optional-mark">複数選択可</span></legend>

                        <div class="checkbox-group">
                            @foreach ($seasons as $season)
                                <span class="checkbox-item">
                                    <input type="checkbox" name="seasons[]" id="season-{{ $season->id }}"
                                        value="{{ $season->id }}"
                                        {{ in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
                                    <label for="season-{{ $season->id }}">{{ $season->name }}</label>
                                </span>
                            @endforeach
                        </div>
                    </fieldset>
                </div>
                @error('seasons')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                {{-- 5. 商品説明 --}}
                <div class="register__form-group register__form-description">
                    <div class="register__form-label">
                        <label for="description">商品説明<span class="required-mark">必須</span></label>
                    </div>
                    <div class="register__form-description__textarea">
                        <textarea name="description" id="description" cols="30" rows="10" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
                    </div>
                </div>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- 戻る/登録ボタン --}}
            <div class="register__actions">
                <button type="button" class="action-button back-button" onclick="history.back()">戻る</button>
                <button type="submit" class="action-button save-button">登録</button>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('image_file');
            const previewImage = document.getElementById('image_preview');
            const fileNameDisplay = document.getElementById('file-name-display');

            // 初期状態の設定
            // ファイルが選択されていない場合、ファイル名表示は「ファイルを選択」
            if (!fileInput.files.length) {
                fileNameDisplay.textContent = 'ファイルを選択';
            }

            fileInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    // 1. 画像プレビューの更新
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                    }
                    reader.readAsDataURL(file);

                    // 2. ファイル名表示の更新
                    fileNameDisplay.textContent = file.name;

                } else {
                    // ファイル選択がキャンセルされた場合
                    previewImage.src = '{{ asset('images/no-image.png') }}';
                    fileNameDisplay.textContent = 'ファイルを選択';
                }
            });
        });
    </script>
@endsection
