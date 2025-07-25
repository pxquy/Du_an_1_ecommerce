document.addEventListener("DOMContentLoaded", function () {
  // Modal Elements
  const productModal = document.getElementById("productModal");
  const deleteModal = document.getElementById("deleteModal");
  const addProductBtn = document.getElementById("addProductBtn");
  const closeModal = document.getElementById("closeModal");
  const cancelForm = document.getElementById("cancelForm");
  const closeDeleteModal = document.getElementById("closeDeleteModal");
  const cancelDelete = document.getElementById("cancelDelete");
  const confirmDelete = document.getElementById("confirmDelete");
  const productForm = document.getElementById("productForm");
  const productImage = document.getElementById("productImage");
  const fileName = document.getElementById("fileName");

  // Table Elements
  const editButtons = document.querySelectorAll(".edit-btn");
  const deleteButtons = document.querySelectorAll(".delete-btn");
  const selectAll = document.getElementById("selectAll");
  const productCheckboxes = document.querySelectorAll(
    'tbody input[type="checkbox"]'
  );

  // Filter Elements
  const categoryFilter = document.getElementById("categoryFilter");
  const statusFilter = document.getElementById("statusFilter");
  const productSearch = document.getElementById("productSearch");

  // Pagination Elements
  const paginationButtons = document.querySelectorAll(".pagination-btn");

  // Current product being edited or deleted
  let currentProductId = null;

  // Open Add Product Modal
  addProductBtn.addEventListener("click", function () {
    // Reset form
    productForm.reset();
    fileName.textContent = "No file chosen";

    // Change modal title to Add
    document.querySelector(".modal-title").textContent = "Add New Product";

    // Show modal
    productModal.classList.add("active");
    document.body.style.overflow = "hidden";
  });

  // Close Product Modal
  function closeProductModal() {
    productModal.classList.remove("active");
    document.body.style.overflow = "";
  }

  closeModal.addEventListener("click", closeProductModal);
  cancelForm.addEventListener("click", closeProductModal);

  // Close Delete Modal
  function closeDeleteModalFunc() {
    deleteModal.classList.remove("active");
    document.body.style.overflow = "";
  }

  closeDeleteModal.addEventListener("click", closeDeleteModalFunc);
  cancelDelete.addEventListener("click", closeDeleteModalFunc);

  // Handle Edit Button Click
  editButtons.forEach((button) => {
    button.addEventListener("click", function () {
      currentProductId = this.getAttribute("data-id");

      // In a real app, you would fetch product data from the server
      // For this demo, we'll just show the modal with a different title
      document.querySelector(".modal-title").textContent = "Edit Product";

      // Show modal
      productModal.classList.add("active");
      document.body.style.overflow = "hidden";

      // Pre-fill form with product data (demo only)
      // In a real app, you would populate the form with actual data
      const row = this.closest("tr");
      const productName = row.querySelector(".product-name").textContent;
      const category = row.cells[3].textContent;
      const price = row.cells[4].textContent.replace("$", "");
      const stock = row.cells[5].textContent;
      const status = row.querySelector(".status-badge").textContent;

      document.getElementById("productName").value = productName;
      document.getElementById("productSKU").value = row.cells[2].textContent;
      document.getElementById("productCategory").value = category.toLowerCase();
      document.getElementById("productPrice").value = price;
      document.getElementById("productStock").value = stock;
      document.getElementById("productStatus").value = row
        .querySelector(".status-badge")
        .classList.contains("in-stock")
        ? "in-stock"
        : row.querySelector(".status-badge").classList.contains("low-stock")
        ? "low-stock"
        : "out-of-stock";
    });
  });

  // Handle Delete Button Click
  deleteButtons.forEach((button) => {
    button.addEventListener("click", function () {
      currentProductId = this.getAttribute("data-id");

      // Show delete confirmation modal
      deleteModal.classList.add("active");
      document.body.style.overflow = "hidden";
    });
  });

  // Handle Confirm Delete
  confirmDelete.addEventListener("click", function () {
    // In a real app, you would send a delete request to the server
    // For this demo, we'll just remove the row from the table
    if (currentProductId) {
      const row = document
        .querySelector(`.delete-btn[data-id="${currentProductId}"]`)
        .closest("tr");
      row.remove();

      // Close modal
      closeDeleteModalFunc();

      // Reset current product ID
      currentProductId = null;
    }
  });

  // Handle Form Submit
  productForm.addEventListener("submit", function (e) {
    e.preventDefault();

    // In a real app, you would send form data to the server
    // For this demo, we'll just close the modal
    closeProductModal();

    // Show success message (optional)
    alert("Product saved successfully!");
  });

  // Handle File Input Change
  productImage.addEventListener("change", function () {
    if (this.files.length > 0) {
      fileName.textContent = this.files[0].name;
    } else {
      fileName.textContent = "No file chosen";
    }
  });

  // Handle Select All Checkbox
  selectAll.addEventListener("change", function () {
    productCheckboxes.forEach((checkbox) => {
      checkbox.checked = this.checked;
    });
  });

  // Update Select All when individual checkboxes change
  productCheckboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
      const allChecked = Array.from(productCheckboxes).every(
        (cb) => cb.checked
      );
      const someChecked = Array.from(productCheckboxes).some(
        (cb) => cb.checked
      );

      selectAll.checked = allChecked;
      selectAll.indeterminate = someChecked && !allChecked;
    });
  });

  // Handle Filters (demo only)
  // In a real app, you would filter data from the server or client-side
  categoryFilter.addEventListener("change", function () {
    console.log("Filter by category:", this.value);
  });

  statusFilter.addEventListener("change", function () {
    console.log("Filter by status:", this.value);
  });

  productSearch.addEventListener("input", function () {
    console.log("Search for:", this.value);
  });

  // Handle Pagination (demo only)
  paginationButtons.forEach((button) => {
    if (!button.disabled) {
      button.addEventListener("click", function () {
        // Remove active class from all buttons
        paginationButtons.forEach((btn) => btn.classList.remove("active"));

        // Add active class to clicked button if it's a number
        if (!this.querySelector("i")) {
          this.classList.add("active");
        }

        console.log("Go to page:", this.textContent.trim());
      });
    }
  });

  // Close modals when clicking outside
  window.addEventListener("click", function (event) {
    if (event.target === productModal) {
      closeProductModal();
    }
    if (event.target === deleteModal) {
      closeDeleteModalFunc();
    }
  });
});
