<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="index.html" class="logo d-flex align-items-center">
      <img src="admin/assets/img/logo.png" alt="">
      <span class="d-none d-lg-block">CoderAdmin</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <div class="search-bar">
    <form class="search-form d-flex align-items-center" method="GET" action="{{ route('admin.search') }}">
      <input type="text" name="search" id="searchInput" placeholder="Search" title="Enter search keyword">
      <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form>
    <div id="searchResults" style="position: absolute; background-color: white; border: 1px solid #ccc; width: 300px; max-height: 300px; overflow-y: auto; display: none;">
    </div>
  </div>
  <!-- End Search Bar -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="{{ asset('/storage/web_image/coder.jpg') }}" alt="Profile" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2"> {{Auth::user()->name}} </span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h5> {{Auth::user()->name}} </h5>
            <span> {{Auth::user()->user_type}} </span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="/profile">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>

        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

      <li class="nav-item">
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-flex align-items-center">
          @csrf
          <a class="nav-link d-flex align-items-center pe-4" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i>
            <span class="d-none d-md-block ps-2">Sign Out</span>
          </a>
        </form>
      </li>

    </ul>
  </nav><!-- End Icons Navigation -->
</header><!-- End Header -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#searchInput').on('keyup', function() {
      let searchQuery = $(this).val();

      if (searchQuery.length > 0) {
        $.ajax({
          url: "{{ route('admin.search') }}", // URL untuk pencarian
          method: 'GET',
          data: {
            search: searchQuery
          },
          success: function(response) {
            $('#searchResults').html(response).show(); // Tampilkan hasil pencarian
          }
        });
      } else {
        $('#searchResults').hide(); // Sembunyikan popup jika input kosong
      }
    });

    // Sembunyikan hasil pencarian jika klik di luar
    $(document).click(function(e) {
      if (!$(e.target).closest('#searchInput, #searchResults').length) {
        $('#searchResults').hide();
      }
    });
  });
</script>