{{-- resources/views/products/show.blade.php --}}

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品詳細 - {{ $product_id->name }}</title>
</head>
<body>
    <h1>商品詳細</h1>

    <a href="{{ route('products.index') }}">← 一覧に戻る</a>

    <div style="border: 2px solid #000; padding: 20px; margin-top: 15px;">
        <h2>{{ $product_id->name }}</h2>

        <p><strong>価格:</strong> ¥{{ number_format($product_id->price) }}</p>

        <p>
            <strong>旬の季節:</strong>
            @foreach ($product_id->seasons as $season)
                <span style="background-color: #f0f0f0; padding: 3px 7px;">{{ $season->name }}</span>
            @endforeach
        </p>

        <p><strong>商品説明:</strong></p>
        <p>{{ $product_id->description }}</p>

        </div>

</body>
</html>
