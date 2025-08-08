document.addEventListener("DOMContentLoaded", () => {
  // Modal Elements
  const deleteModal = document.getElementById("deleteModal");
  const deleteProductBtn = document.getElementById("deleteProductBtn");
  const closeDeleteModal = document.getElementById("closeDeleteModal");
  const cancelDelete = document.getElementById("cancelDelete");
  const confirmDelete = document.getElementById("confirmDelete");

  // Filter Elements
  const filterButtons = document.querySelectorAll(".filter-btn");
  const sortSelect = document.querySelector(".sort-select");
  const commentItems = document.querySelectorAll(".comment-item");

  // Action Buttons
  const helpfulButtons = document.querySelectorAll(".helpful-btn");
  const replyButtons = document.querySelectorAll(".reply-btn");
  const reportButtons = document.querySelectorAll(".report-btn");
  const loadMoreBtn = document.querySelector(".load-more-btn");

  // Close Delete Modal
  function closeDeleteModalFunc() {
    deleteModal.classList.remove("active");
    document.body.style.overflow = "";
  }

  // Delete Product Modal
  if (deleteProductBtn) {
    deleteProductBtn.addEventListener("click", () => {
      deleteModal.classList.add("active");
      document.body.style.overflow = "hidden";
    });
  }

  if (closeDeleteModal) {
    closeDeleteModal.addEventListener("click", closeDeleteModalFunc);
  }

  if (cancelDelete) {
    cancelDelete.addEventListener("click", closeDeleteModalFunc);
  }

  if (confirmDelete) {
    confirmDelete.addEventListener("click", () => {
      // In a real app, you would send a delete request to the server
      alert("Bạn chắc chắn muốn xoá sản phẩm này!");
      window.location.href = "product.html";
    });
  }

  // Filter Comments
  filterButtons.forEach((button) => {
    button.addEventListener("click", function () {
      // Remove active class from all buttons
      filterButtons.forEach((btn) => btn.classList.remove("active"));

      // Add active class to clicked button
      this.classList.add("active");

      const filterValue = this.getAttribute("data-filter");

      // Show/hide comments based on filter
      commentItems.forEach((comment) => {
        const rating = comment.getAttribute("data-rating");

        if (filterValue === "all" || rating === filterValue) {
          comment.style.display = "block";
        } else {
          comment.style.display = "none";
        }
      });
    });
  });

  // Sort Comments
  if (sortSelect) {
    sortSelect.addEventListener("change", function () {
      const sortValue = this.value;
      console.log("Sort by:", sortValue);
      // In a real app, you would sort the comments based on the selected option
    });
  }

  // Helpful Button Actions
  helpfulButtons.forEach((button) => {
    button.addEventListener("click", function () {
      // Toggle helpful state
      this.classList.toggle("active");

      // In a real app, you would send this to the server
      console.log("Helpful button clicked");
    });
  });

  // Reply Button Actions
  replyButtons.forEach((button) => {
    button.addEventListener("click", () => {
      // In a real app, you would show a reply form
      console.log("Reply button clicked");
      alert("Reply functionality would be implemented here");
    });
  });

  // Report Button Actions
  reportButtons.forEach((button) => {
    button.addEventListener("click", () => {
      // In a real app, you would show a report form
      console.log("Report button clicked");
      alert("Report functionality would be implemented here");
    });
  });

  // Load More Reviews
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener("click", () => {
      // In a real app, you would load more reviews from the server
      console.log("Load more reviews");
      alert("Loading more reviews...");
    });
  }

  // Close modals when clicking outside
  window.addEventListener("click", (event) => {
    if (event.target === deleteModal) {
      closeDeleteModalFunc();
    }
  });
});

// Change Main Product Image
function changeMainImage(thumbnail) {
  const mainImage = document.getElementById("mainProductImage");
  const thumbnails = document.querySelectorAll(".thumbnail");

  // Remove active class from all thumbnails
  thumbnails.forEach((thumb) => thumb.classList.remove("active"));

  // Add active class to clicked thumbnail
  thumbnail.classList.add("active");

  // Change main image source
  mainImage.src = thumbnail.src.replace("80x80", "400x400");
}
