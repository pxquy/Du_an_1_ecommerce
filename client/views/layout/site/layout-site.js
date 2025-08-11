document.addEventListener("DOMContentLoaded", function () {
  const mobileMenuToggle = document.querySelector(".mobile-menu-toggle");
  const mobileMenuClose = document.querySelector(".mobile-menu-close");
  const mobileMenu = document.querySelector(".mobile-menu");
  const overlay = document.querySelector(".mobile-menu-overlay");
  const body = document.body;

  // Open mobile menu
  mobileMenuToggle.addEventListener("click", function () {
    mobileMenu.classList.add("active");
    overlay.classList.add("active");
    body.classList.add("menu-open");
  });

  function closeMenu() {
    mobileMenu.classList.remove("active");
    overlay.classList.remove("active");
    body.classList.remove("menu-open");
  }

  mobileMenuClose.addEventListener("click", closeMenu);
  overlay.addEventListener("click", closeMenu);

  const mobileDropdownToggles = document.querySelectorAll(
    ".mobile-dropdown-toggle"
  );

  mobileDropdownToggles.forEach((toggle) => {
    toggle.addEventListener("click", function (e) {
      e.preventDefault();
      const parent = this.parentElement;

      document.querySelectorAll(".mobile-dropdown.active").forEach((item) => {
        if (item !== parent) {
          item.classList.remove("active");
        }
      });

      parent.classList.toggle("active");
    });
  });

  const dropdowns = document.querySelectorAll(".dropdown");

  dropdowns.forEach((dropdown) => {
    dropdown.addEventListener("mouseenter", function () {
      this.classList.add("active");
    });

    dropdown.addEventListener("mouseleave", function () {
      this.classList.remove("active");
    });
  });

  const userDropdownToggle = document.querySelector(".user-dropdown-toggle");
  const userDropdown = document.querySelector(".user-dropdown");

  userDropdownToggle.addEventListener("click", function (e) {
    e.stopPropagation();
    userDropdown.classList.toggle("active");

    // Close search dropdown if open
    searchDropdown.classList.remove("active");
    searchOverlay.classList.remove("active");
  });

  const searchIconBtn = document.querySelector(".search-icon-btn");
  const searchDropdown = document.querySelector(".search-dropdown");
  const searchOverlay = document.querySelector(".search-overlay");
  const searchInput = document.querySelector(".search-input");

  searchIconBtn.addEventListener("click", function (e) {
    e.stopPropagation();
    searchDropdown.classList.toggle("active");
    searchOverlay.classList.toggle("active");

    // Focus the search input when opening
    if (searchDropdown.classList.contains("active")) {
      setTimeout(() => {
        searchInput.focus();
      }, 100);
    }

    userDropdown.classList.remove("active");
  });

  searchOverlay.addEventListener("click", function () {
    searchDropdown.classList.remove("active");
    searchOverlay.classList.remove("active");
  });

  document.addEventListener("click", function (e) {
    if (!userDropdown.contains(e.target)) {
      userDropdown.classList.remove("active");
    }

    if (!searchDropdown.contains(e.target)) {
      searchDropdown.classList.remove("active");
      searchOverlay.classList.remove("active");
    }
  });

  // Close search dropdown on ESC key
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      searchDropdown.classList.remove("active");
      searchOverlay.classList.remove("active");
      userDropdown.classList.remove("active");
    }
  });

  searchForm.addEventListener("submit", function () {
    searchDropdown.classList.remove("active");
    searchOverlay.classList.remove("active");
  });
});
