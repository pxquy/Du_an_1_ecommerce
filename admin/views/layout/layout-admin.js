document.addEventListener("DOMContentLoaded", function () {
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.querySelector(".sidebar");
  const adminContainer = document.querySelector(".admin-container");
  const sidebarOverlay = document.getElementById("sidebarOverlay");

  // Function to check if we're on mobile
  function isMobile() {
    return window.innerWidth < 768;
  }

  // Function to toggle sidebar
  function toggleSidebar() {
    if (isMobile()) {
      sidebar.classList.toggle("mobile-open");
      sidebarOverlay.classList.toggle("active");

      // Prevent body scrolling when sidebar is open on mobile
      if (sidebar.classList.contains("mobile-open")) {
        document.body.style.overflow = "hidden";
      } else {
        document.body.style.overflow = "";
      }
    } else {
      sidebar.classList.toggle("collapsed");
      adminContainer.classList.toggle("sidebar-collapsed");
    }
  }

  // Toggle sidebar when button is clicked
  sidebarToggle.addEventListener("click", function (event) {
    event.stopPropagation(); // Prevent event from bubbling up
    toggleSidebar();
  });

  // Close sidebar when clicking on the overlay
  sidebarOverlay.addEventListener("click", function () {
    if (sidebar.classList.contains("mobile-open")) {
      sidebar.classList.remove("mobile-open");
      sidebarOverlay.classList.remove("active");
      document.body.style.overflow = "";
    }
  });

  // Handle window resize
  window.addEventListener("resize", function () {
    if (!isMobile() && sidebar.classList.contains("mobile-open")) {
      sidebar.classList.remove("mobile-open");
      sidebarOverlay.classList.remove("active");
      document.body.style.overflow = "";
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
        sidebarOverlay.classList.remove("active");
        document.body.style.overflow = "";
      }
    });
  });
});
