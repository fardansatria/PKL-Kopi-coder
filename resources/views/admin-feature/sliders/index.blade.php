<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Sliders - Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('admin/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('admin/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500,600,600i,700,700i" rel="stylesheet">

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

    <style>
        .action-buttons {
            display: flex;
            gap: 0.3rem;
            justify-content: center;
        }
        .table img {
            max-height: 100px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <x-header-admin></x-header-admin>
    <x-sidebar-admin></x-sidebar-admin>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Sliders</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/index">Home</a></li>
                    <li class="breadcrumb-item active">Sliders</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('sliders.create') }}" class="btn btn-md btn-success mb-3">Add Slider</a>

                            <h3>Header Sliders</h3>
                            @if($headerSliders->isEmpty())
                            <div class="alert alert-warning">
                                No header sliders available.
                            </div>
                            @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Image</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Type</th>
                                        <th scope="col" style="width: 20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($headerSliders as $slider)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ asset('images/'.$slider->image) }}" class="img-fluid rounded">
                                        </td>
                                        <td>{{ $slider->title }}</td>
                                        <td>{{ ucfirst($slider->type) }}</td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <a href="{{ route('sliders.show', $slider->id) }}" class="btn btn-sm btn-dark">Show</a>
                                                <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form onsubmit="return confirm('Are you sure?');" action="{{ route('sliders.destroy', $slider->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif

                            <h3 class="mt-5">Event Sliders</h3>
                            @if($eventSliders->isEmpty())
                            <div class="alert alert-warning">
                                No event sliders available.
                            </div>
                            @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Image</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Type</th>
                                        <th scope="col" style="width: 20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($eventSliders as $slider)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ asset('images/'.$slider->image) }}" class="img-fluid rounded">
                                        </td>
                                        <td>{{ $slider->title }}</td>
                                        <td>{{ ucfirst($slider->type) }}</td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <a href="{{ route('sliders.show', $slider->id) }}" class="btn btn-sm btn-dark">Show</a>
                                                <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form onsubmit="return confirm('Are you sure?');" action="{{ route('sliders.destroy', $slider->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "Success",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
        @elseif(session('error'))
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
        @endif
    </script>

</body>

</html>
