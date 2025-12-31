<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<aside class="app-sidebar bg-dark text-white shadow" data-bs-theme="dark">
  <div class="sidebar-brand text-center py-3">
    <span class="fs-5 fw-semibold">Quản trị Thư viện</span>
  </div>

  <nav class="mt-2">
    <ul class="nav nav-pills flex-column" id="sidebarMenu">

      <!-- Trang chủ -->
      <li class="nav-item">
        <a href="admin_dashboard.php?pages=dashboard" class="nav-link text-white">
          <i class="fa-solid fa-gauge me-2"></i> Tổng quan
        </a>
      </li>

      <!-- Quản lý thành viên -->
      <li class="nav-item">
        <a class="nav-link text-white d-flex justify-content-between align-items-center"
           data-bs-toggle="collapse" href="#collapseThanhVien" role="button">
          <span><i class="fa-solid fa-users me-2"></i> Quản lý thành viên</span>
          <i class="fa-solid fa-chevron-down small"></i>
        </a>

        <div class="collapse ps-4" id="collapseThanhVien">
          <ul class="nav flex-column">
            <li class="nav-item"><a href="admin_dashboard.php?pages=sinhvien" class="nav-link text-white">Thành viên</a></li>
            <li class="nav-item"><a href="admin_dashboard.php?pages=muontra" class="nav-link text-white">Mượn - Trả</a></li>
            
          </ul>
        </div>
      </li>

      <!-- Quản lý sách -->
      <li class="nav-item">
        <a href="admin_dashboard.php?pages=sach" class="nav-link text-white">
          <i class="fa-solid fa-gauge me-2"></i> Quản lý sách
        </a>
      </li>

    </ul>
  </nav>
</aside>

