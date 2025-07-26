document.addEventListener("DOMContentLoaded", function () {
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.querySelector(".sidebar");
  const adminContainer = document.querySelector(".admin-container");

  // Function to check if we're on mobile
  function isMobile() {
    return window.innerWidth < 768;
  }

  // Function to toggle sidebar
  function toggleSidebar() {
    if (isMobile()) {
      sidebar.classList.toggle("mobile-open");
    } else {
      sidebar.classList.toggle("collapsed");
      adminContainer.classList.toggle("sidebar-collapsed");
    }
  }

  // Toggle sidebar when button is clicked
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

  // Handle window resize
  window.addEventListener("resize", function () {
    if (!isMobile() && sidebar.classList.contains("mobile-open")) {
      sidebar.classList.remove("mobile-open");
    }
  });

  // Add active class to menu items when clicked
  const menuItems = document.querySelectorAll(".menu-item");
  menuItems.forEach((item) => {
    item.addEventListener("click", function () {
      // Remove active class from all items
      menuItems.forEach((i) => i.classList.remove("active"));
      // Add active class to clicked item
      this.classList.add("active");

      // On mobile, close the sidebar after selecting an item
      if (isMobile() && sidebar.classList.contains("mobile-open")) {
        sidebar.classList.remove("mobile-open");
      }
    });
  });
});
