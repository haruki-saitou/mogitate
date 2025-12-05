@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}" />
@endsection

@section('content')
    {{-- エラーメッセージの表示 (必要に応じて) --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ★ フォームの送信先を store ルートに変更し、POSTメソッドを使用 ★ --}}
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="detail-container">
            <div class="detail-header">
                <a href="{{ route('products.index') }}" class="detail__link">商品一覧 > </a>
                <span>商品登録</span>
            </div>

            <div class="detail-content">
                {{-- ★ 商品画像セクション（プレビュー機能はJavaScriptで実装する必要あり）★ --}}
                <div class="detail__image-section">
                    <div class="detail__image">
                        {{-- 初期状態ではno-imageを表示 --}}
                        <img src="{{ asset('images/no-image.png') }}" id="image-preview" class="image" />
                    </div>

                    <div class="file-upload-container">
                        <input type="file" name="image_file" id="image_file" class="hidden-file-input">
                        <label for="image_file" class="custom-file-label">
                            ファイルを選択
                        </label>
                        {{-- ファイル名表示も初期は「選択されていません」 --}}
                        <span id="file-name" class="file-name-display">
                            選択されていません
                        </span>
                    </div>
                </div>

                <div class="detail__form">
                    {{-- ★ 商品名 ★ --}}
                    <div class="detail__form-label">
                        <label for="name">商品名</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" />
                    </div>
                    {{-- ★ 価格 ★ --}}
                    <div class="detail__form-price">
                        <label for="price">価格</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" />
                    </div>

                    {{-- ★ 季節（チェックボックス）★ --}}
                    <div class="detail__form-season">
                        <label>季節</label>
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
                    </div>
                </div>
            </div>

            {{-- ★ 商品説明 ★ --}}
            <div class="detail__form-description-section">
                <label for="description">商品説明</label>
                <textarea name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
            </div>

            {{-- ★ アクションボタン（登録）★ --}}
            <div class="detail__actions">
                <div class="detail__actions-back">
                    <button type="button" class="action-button back-button" onclick="history.back()">戻る</button>
                </div>
                <div class="detail__actions-save">
                    <button type="submit" class="action-button save-button">登録</button>
                    {{-- ★ 削除ボタンは不要のため削除 ★ --}}
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageFileInput = document.getElementById('image_file');
            const fileNameDisplay = document.getElementById('file-name');
            const imagePreview = document.getElementById('image-preview');

            // ファイルが選択されたら、ファイル名とプレビューを更新する
            imageFileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    // ファイル名を表示
                    fileNameDisplay.textContent = file.name;

                    // 画像プレビューを表示
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    // ファイルがキャンセルされた場合はリセット
                    fileNameDisplay.textContent = '選択されていません';
                    imagePreview.src = '{{ asset('images/no-image.png') }}'; // デフォルト画像に戻す
                }
            });
        });
    </script>
@endsection
