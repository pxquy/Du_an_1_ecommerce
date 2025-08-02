document.addEventListener("DOMContentLoaded", function () {
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.querySelector(".sidebar");
  const adminContainer = document.querySelector(".admin-container");


// Chức năng kiểm tra xem chúng ta có đang ở trên thiết bị di động không
  function isMobile() {
    return window.innerWidth < 768;
  }

  //  Chức năng chuyển đổi thanh bên
  function toggleSidebar() {
    if (isMobile()) {
      sidebar.classList.toggle("mobile-open");
    } else {
      sidebar.classList.toggle("collapsed");
      adminContainer.classList.toggle("sidebar-collapsed");
    }
  }

  // Chuyển đổi nhanh khi nhấp chuột vào
  sidebarToggle.addEventListener("click", toggleSidebar);

  // Close sidebar when clicking outside on mobile
  document.addEventListener("click", function (event) {
    if (
      isMobile() &&
      sidebar.classList.contains("mobile-open") &&
      !sidebar.contains(event.target) &&
      event.target !== sidebarToggle
    ) {
      sidebar.classList.remove("mobile-open");
    }
  });
  // Sử lý thay đổi kích thước
  window.addEventListener("resize", function () {
    if (!isMobile() && sidebar.classList.contains("mobile-open")) {
      sidebar.classList.remove("mobile-open");
    }
  });

  // Thêm lớp hoạt động vào các mục menu khi được nhấp vào
  const menuItems = document.querySelectorAll(".menu-item");
  menuItems.forEach((item) => {
    item.addEventListener("click", function () {
      // Remove active class from all items
      menuItems.forEach((i) => i.classList.remove("active"));
      // Add active class to clicked item
      this.classList.add("active");

      // Trên thiết bị di động, hãy đóng thanh bên sau khi chọn một mục
      if (isMobile() && sidebar.classList.contains("mobile-open")) {
        sidebar.classList.remove("mobile-open");
      }
    });
  });
});
