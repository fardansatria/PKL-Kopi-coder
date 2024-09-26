<style>
    .search-results-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .search-result-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        transition: background-color 0.3s, transform 0.2s;
    }

    .search-result-item:hover {
        background-color: #f2f2f2;
        transform: scale(1.02);
    }

    .result-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: inherit;
        width: 100%;
    }

    .result-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin-right: 15px;
        border-radius: 4px;
        border: 1px solid #ddd;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .result-details {
        display: flex;
        flex-direction: column;
    }

    .no-results {
        padding: 10px;
        font-style: italic;
        color: #888;
    }

    h3,
    h4 {
        margin: 10px 0;
        font-weight: bold;
        color: #333;
    }

    
    a:hover .result-details strong {
        color: #007bff;
    }

   
    @media (max-width: 600px) {
        .result-image {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .search-result-item {
            padding: 8px;
        }
    }
</style>


<h3>Hasil Pencarian</h3>

@if($products->count() > 0)
<h4>Produk</h4>
<ul class="search-results-list">
    @foreach($products as $product)
    <li class="search-result-item">
        <a href="{{ route('products.show', $product->id) }}" class="result-link">
            <img src="{{ asset('/storage/products/' . $product->image) }}" alt="{{ $product->title }}" class="result-image">
            <div class="result-details">
                <strong>{{ $product->title }}</strong><br>
            </div>
        </a>
    </li>
    @endforeach
</ul>
@else
<p class="no-results">Tidak ada produk yang ditemukan.</p>
@endif

@if($mereks->count() > 0)
<h4>Merek</h4>
<ul class="search-results-list">
    @foreach($mereks as $merek)
    <li class="search-result-item">
        <a href="{{ route('merek.index', $merek->id) }}" class="result-link">
            <img src="{{ asset('/storage/mereks/' . $merek->image) }}" alt="{{ $merek->name }}" class="result-image">
            <div class="result-details">
                <strong>{{ $merek->name }}</strong><br>
            </div>
        </a>
    </li>
    @endforeach
</ul>
@else
<p class="no-results">Tidak ada merek yang ditemukan.</p>
@endif