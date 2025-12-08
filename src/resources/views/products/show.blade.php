@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') . '?v=' . filemtime(public_path('css/show.css')) }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection

@section('content')
    <div class="detail-container">
        <form action="{{ route('products.update', ['product_id' => $product_id->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="detail-header">
                <a href="{{ route('products.index') }}" class="detail__link">商品一覧 > </a>
                <span>{{ $product_id->name }}</span>
            </div>

            <div class="detail-content">
                <div class="detail__image-section">
                    <div class="detail__image">
                        @php
                            $isClearedOnOld = old('image_is_cleared') === '1';
                        @endphp
                        <img id="product-image-display"
                            src="{{ $product_id->image && !$isClearedOnOld ? asset('storage/' . $product_id->image) : asset('images/no-image.png') }}"
                            class="image" />
                    </div>

                    <div class="file-upload-container">
                        <input type="file" name="image_file" id="image_file" class="hidden-file-input">
                        <label for="image_file" class="custom-file-label">
                            ファイルを選択
                        </label>
                        <span id="file-name" class="file-name-display">
                            @if ($product_id->image && !$isClearedOnOld)
                                {{ pathinfo($product_id->image, PATHINFO_BASENAME) }}
                            @else
                                選択されていません
                            @endif
                        </span>
                        <button type="button" class="action-button clear-image-button" onclick="clearImageDisplay()">
                            クリア
                        </button>
                        <input type="hidden" name="image_is_cleared" id="image_is_cleared"
                            value="{{ old('image_is_cleared', 0) }}">
                    </div>
                    @error('image_file')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="detail__form">
                    <div class="detail__form-label">
                        <label for="name">商品名</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product_id->name) }}" />
                    </div>
                    @error('name')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="detail__form-price">
                        <label for="price">価格</label>
                        <input type="number" name="price" id="price"
                            value="{{ old('price', $product_id->price) }}" />
                    </div>
                    @error('price')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="detail__form-season">
                        <label>季節</label>
                        <div class="checkbox-group">
                            @php
                                $selected_seasons = $product_id->seasons->pluck('id')->toArray();
                            @endphp
                            @foreach ($allSeasons as $season)
                                <span class="checkbox-item">
                                    <input type="checkbox" name="seasons[]" id="season-{{ $season->id }}"
                                        value="{{ $season->id }}"
                                        {{ in_array($season->id, old('seasons', $selected_seasons)) ? 'checked' : '' }}>
                                    <label for="season-{{ $season->id }}">{{ $season->name }}</label>
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @error('seasons')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="detail__form-description-section">
                <label for="description">商品説明</label>
                <textarea name="description" id="description" cols="30" rows="10">{{ old('description', $product_id->description) }}</textarea>
            </div>
            @error('description')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

            <div class="detail__actions">
                <div class="detail__actions-back">
                    <button type="button" class="action-button back-button" onclick="history.back()">戻る</button>
                </div>
                <div class="detail__actions-save">
                    <button type="submit" class="action-button save-button">変更を保存</button>
                </div>
            </div>

        </form>
        <div class="detail__actions-delete">
            <form action="{{ route('products.destroy', ['product_id' => $product_id->id]) }}" method="POST"
                onsubmit="return confirm('本当に削除してもよろしいですか？');">
                @method('DELETE')
                @csrf
                <button type="submit" class="action-button delete-button">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('image_file');
            const display = document.getElementById('product-image-display');
            const fileNameDisplay = document.getElementById('file-name');
            const clearFlag = document.getElementById('image_is_cleared');

            fileInput.addEventListener('change', function() {
                clearFlag.value = '0';
                const file = this.files[0];

                if (file) {
                    fileNameDisplay.textContent = file.name;
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        display.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    fileNameDisplay.textContent = '選択されていません';
                }
            });

            window.clearImageDisplay = function() {
                if (display) {
                    display.src = '{{ asset('/images/no-image.png') }}';
                }

                if (fileInput) {
                    fileInput.value = null;
                }
                if (fileNameDisplay) {
                    fileNameDisplay.textContent = '選択されていません';
                }

                if (clearFlag) {
                    clearFlag.value = '1';
                }
            };
        });
    </script>
@endsection
