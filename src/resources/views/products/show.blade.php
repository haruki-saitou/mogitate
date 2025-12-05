@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}" />
@endsection

@section('content')
    <form action="{{ route('products.update', ['product_id' => $product_id->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="detail-container">
            <div class="detail-header">
                <a href="{{ route('products.index') }}" class="detail__link">商品一覧 > </a>
                <span>{{ $product_id->name }}</span>
            </div>

            <div class="detail-content">
                <div class="detail__image-section">
                    <div class="detail__image">
                        <img src="{{ $product_id->image ? asset('storage/' . $product_id->image) : asset('images/no-image.png') }}"
                            class="image" />
                    </div>

                    <div class="file-upload-container">
                        <input type="file" name="image_file" id="image_file" class="hidden-file-input">
                        <label for="image_file" class="custom-file-label">
                            ファイルを選択
                        </label>
                        <span id="file-name" class="file-name-display">
                            @if ($product_id->image)
                                {{ pathinfo($product_id->image, PATHINFO_BASENAME) }}
                            @else
                                選択されていません
                            @endif
                        </span>
                    </div>
                </div>

                <div class="detail__form">
                    <div class="detail__form-label">
                        <label for="name">商品名</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product_id->name) }}" />
                    </div>
                    <div class="detail__form-price">
                        <label for="price">価格</label>
                        <input type="number" name="price" id="price"
                            value="{{ old('price', $product_id->price) }}" />
                    </div>

                    <div class="detail__form-season">
                        <label>季節</label>
                        <div class="checkbox-group">
                            @php
                                $selected_seasons = $product_id->seasons->pluck('id')->toArray();
                                $seasons = [1 => '春', 2 => '夏', 3 => '秋', 4 => '冬'];
                            @endphp
                            @foreach ($seasons as $id => $name)
                                <span class="checkbox-item">
                                    <input type="checkbox" name="seasons[]" id="season-{{ $id }}"
                                        value="{{ $id }}"
                                        {{ in_array($id, old('seasons', $selected_seasons)) ? 'checked' : '' }}>
                                    <label for="season-{{ $id }}">{{ $name }}</label>
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail__form-description-section">
                <label for="description">商品説明</label>
                <textarea name="description" id="description" cols="30" rows="10">{{ old('description', $product_id->description) }}</textarea>
            </div>

            <div class="detail__actions">
                <div class="detail__actions-back">
                    <button type="button" class="action-button back-button" onclick="history.back()">戻る</button>
                </div>
                <div class="detail__actions-save">
                    <button type="submit" class="action-button save-button">変更を保存</button>
                </div>
            </div>
        </div>
    </form>
    <div class="detail__actions-delete">
        <form action="{{ route('products.destroy', ['product_id' => $product_id->id]) }}" method="POST"
            style="display:inline;">
            @method('DELETE')
            @csrf
            <button type="submit" class="action-button delete-button">
                <i class="fa-solid fa-trash-can"></i>
            </button>
        </form>
    </div>
@endsection
