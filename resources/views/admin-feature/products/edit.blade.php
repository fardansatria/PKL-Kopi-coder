<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Favicons -->
    <link href="{{ asset('admin/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('admin/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <x-header-admin></x-header-admin>
    <x-sidebar-admin></x-sidebar-admin>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Edit Slider</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/index">Home</a></li>
                    <li class="breadcrumb-item active">Edit Slider</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <div class="container mt-5 mb-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">

                                @csrf
                                @method('PUT')

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">IMAGE</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">

                                    <!-- error message untuk image -->
                                    @error('image')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                @if($product->image)
                                <div class="mb-3">
                                    <img src="{{ asset('/storage/products/'.$product->image) }}" class="img-fluid rounded mb-2" style="max-width: 150px">
                                </div>
                                @endif

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">ADDITIONAL IMAGES</label>
                                    <input type="file" class="form-control @error('images.*') is-invalid @enderror" name="images[]" multiple>

                                    <!-- error message untuk additional images -->
                                    @error('images.*')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                @if($product->productImages)
                                <div class="mb-3">
                                    @foreach($product->productImages as $image)
                                    <img src="{{ asset('/storage/products/'.$image->image) }}" class="img-fluid rounded mb-2" style="max-width: 150px">
                                    @endforeach
                                </div>
                                @endif

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">TITLE</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $product->title) }}" placeholder="Masukkan Judul Product">

                                    <!-- error message untuk title -->
                                    @error('title')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">MEREK</label>
                                    <select class="form-control" name="merek_id" id="merek_id">
                                        @foreach ($mereks as $merek)
                                        <option value="{{ $merek->id }}" {{ $merek->id == $product->merek_id ? 'selected' : '' }}>{{ $merek->name }}</option>
                                        @endforeach
                                    </select>

                                    <!-- error message untuk merek -->
                                    @error('merek_id')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">DESCRIPTION</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" placeholder="Masukkan Description Product">{{ old('description', $product->description) }}</textarea>

                                    <!-- error message untuk description -->
                                    @error('description')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">PRICE</label>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price) }}" placeholder="Masukkan Harga Product">

                                            <!-- error message untuk price -->
                                            @error('price')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">STOCK</label>
                                            <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock', $product->stock) }}" placeholder="Masukkan Stock Product">

                                            <!-- error message untuk stock -->
                                            @error('stock')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">Berat (gram)</label>
                                            <input type="number" class="form-control @error('weight') is-invalid @enderror" name="weight" value="{{ old('weight', $product->weight) }}" placeholder="Masukkan Berat Product">

                                            <!-- error message untuk stock -->
                                            @error('weight')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-md btn-primary me-3">UPDATE</button>
                                <button type="reset" class="btn btn-md btn-warning">RESET</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
        <!-- Vendor JS Files -->
        <script src="{{ asset('admin/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/chart.js/chart.umd.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/echarts/echarts.min.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/quill/quill.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/php-email-form/validate.js') }}"></script>

        <!-- Template Main JS File -->
        <script src="{{ asset('admin/assets/js/main.js') }}"></script>
</body>

</html>