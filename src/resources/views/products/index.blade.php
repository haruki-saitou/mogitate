{{-- resources/views/products/index.blade.php --}}

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品一覧</title>
</head>
<body>
    <h1>商品一覧 (PG01)</h1>

    <div>
        @foreach ($products as $product)
            <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                <h3>{{ $product->name }}</h3>
                <p>価格: ¥{{ number_format($product->price) }}</p>
                <p>
                    旬の季節:
                    @foreach ($product->seasons as $season)
                        <span style="background-color: #eee; padding: 2px 5px;">{{ $season->name }}</span>
                    @endforeach
                </p>
                <a href="{{ route('products.show', ['product_id' => $product->id]) }}">詳細を見る</a>
            </div>
        @endforeach
    </div>

    <div style="margin-top: 20px;">
        {{ $products->links() }}
    </div>

</body>
</html>
