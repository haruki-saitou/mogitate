@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/create.css') . '?v=' . filemtime(public_path('css/create.css')) }}" />
@endsection

@section('content')
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" >
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

                <div class="register__form-group">
                    <div class="register__form-label">
                        <label for="price">値段<span class="required-mark">必須</span></label>
                    </div>
                    <div class="register__form-input">
                        <input type="text" name="price" id="price" value="{{ old('price') }}"
                            placeholder="価格を入力" inputmode="numeric"/>
                    </div>
                </div>
                @error('price')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <div class="register__form-group register__form-image">
                    <label for="image_file">商品画像<span class="required-mark">必須</span></label>
                    <div class="image-upload-wrapper">
                        <div class="image-preview-area">
                            <img id="image_preview" src="{{ asset('images/no-image.png') }}" alt="画像プレビュー">
                        </div>
                        <div class="file-select-ui">
                            <label for="image_file" class="custom-file-select-button small-button">
                                ファイルを選択
                            </label>
                            <input type="file" name="image_file" id="image_file" class="hidden-file-input" />
                            <span id="file-name-display" class="file-name-display">ファイルを選択</span>
                        </div>
                    </div>
                </div>
                @error('image_file')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <div class="register__form-group register__form-season">
                    <fieldset class="season-group">
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
            <div class="register__actions">
                <button type="button" class="action-button back-button" onclick="location.href = '{{ route('products.index') }}'">戻る</button>
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

            if (!fileInput.files.length) {
                fileNameDisplay.textContent = 'ファイルを選択';
            }

            fileInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                    fileNameDisplay.textContent = file.name;

                } else {
                    previewImage.src = '{{ asset('images/no-image.png') }}';
                    fileNameDisplay.textContent = 'ファイルを選択';
                }
            });
        });
    </script>
@endsection
