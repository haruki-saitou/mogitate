<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>商品登録</title>
</head>
<style>
    /* style.css または <style> タグ内に記述 */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield;
    appearance: textfield; /* 標準的な書き方 (将来的な互換性のため) */
}
</style>
<body>
    <h1>商品登録 (PG03)</h1>

    <a href="{{ route('products.index') }}">← 一覧に戻る</a>

    {{-- resources/views/products/create.blade.php (修正版) --}}

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" novalidate>
    @csrf

    {{-- ★ 1. 商品名 ★ --}}
    <div style="margin-bottom: 15px;">
        <label for="name">商品名:</label> <span style="color: red;">必須</span>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
    </div>
    @if ($errors->has('name'))
        <div style="color: red; font-size: 0.9em; margin-top: 5px;">
            @foreach($errors->get('name') as $message)
                <div>{{ $message }}</div>
            @endforeach
        </div>
    @endif

    {{-- ★ 2. 価格 ★ --}}
    <div style="margin-bottom: 15px;">
        <label for="price">価格:</label> <span style="color: red;">必須</span>
        <input type="number" name="price" id="price" value="{{ old('price') }}">
        <div style="font-size: 0.9em; color: gray;">0-10000円以内で入力してください</div>
    </div>
    @if ($errors->has('price'))
        <ul style="color: red; font-size: 0.9em; margin-top: 5px;">
            @foreach($errors->get('price') as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @endif

    {{-- ★ 3. 商品画像 ★ --}}
    <div style="margin-bottom: 15px;">
        <label>商品画像</label> <span style="color: red;">必須</span>
        <div>
            <input type="file" name="image_file" id="image_file">
            <div style="font-size: 0.9em; color: gray;">
                「.png」または「.jpeg」形式でアップロードしてください
            </div>
            @if ($errors->has('image_file'))
                <div style="color: red; font-size: 0.9em; margin-top: 5px;">
                    @foreach($errors->get('image_file') as $message)
                        <div>{{ $message }}</div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- ★ 4. 季節 ★ --}}
    <div style="margin-bottom: 15px;">
        <label>季節</label> <span style="color: red;">必須 複数選択可</span><br>

        @if ($errors->has('seasons'))
            <div style="color: red; font-size: 0.9em; margin-top: 5px;">
                @foreach($errors->get('seasons') as $message)
                    <div>{{ $message }}</div>
                @endforeach
            </div>
        @endif
        @foreach ($seasons as $season)
            <label style="margin-right: 15px;">
                <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                    {{ in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
                {{ $season->name }}
            </label>
        @endforeach
    </div>

    {{-- ★ 5. 商品説明 ★ --}}
    <div style="margin-bottom: 15px;">
        <label for="description">商品説明</label> <span style="color: red;">必須</span>
        <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>
        <div style="font-size: 0.9em; color: gray;">120文字以内で入力してください</div>
    </div>
    @if ($errors->has('description'))
        <div style="color: red; font-size: 0.9em; margin-top: 5px;">
            @foreach ($errors->get('description') as $message)
                <div>{{ $message }}</div>
            @endforeach
        </div>
    @endif


    <div>
        <button type="submit">登録</button>
    </div>
</form>
