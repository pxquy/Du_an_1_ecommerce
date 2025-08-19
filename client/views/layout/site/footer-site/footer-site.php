    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <div class="footer-logo">
                        <img src="./assets/images/LOGO.svg" width="150" alt="Arrowwai">
                    </div>
                    <p class="footer-description">
                        Arrowwai - Thương hiệu giày da nam cao cấp, mang đến phong cách lịch lãm và đẳng cấp cho quý ông Việt.
                    </p>
                    <div class="footer-contact">
                        <p><i class="fas fa-map-marker-alt"></i> Tòa nhà FPT Polytechnic, P. Trịnh Văn Bô, Xuân Phương, Nam Từ Liêm, Hà Nội</p>
                        <p><i class="fas fa-phone"></i> 1900 1234</p>
                        <p><i class="fas fa-envelope"></i> cskh@arrowwai.com</p>
                    </div>
                </div>

                <div class="footer-column">
                    <h3 class="footer-title">CHÍNH SÁCH</h3>
                    <ul class="footer-links">
                        <li><a href="#">Chính sách bảo hành</a></li>
                        <li><a href="#">Chính sách đổi trả</a></li>
                        <li><a href="#">Chính sách vận chuyển</a></li>
                        <li><a href="#">Chính sách thanh toán</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3 class="footer-title">THÔNG TIN</h3>
                    <ul class="footer-links">
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Tin tức</a></li>
                        <li><a href="#">Tuyển dụng</a></li>
                        <li><a href="#">Hệ thống cửa hàng</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3 class="footer-title">ĐĂNG KÝ NHẬN TIN</h3>
                    <p class="newsletter-text">Đăng ký nhận bản tin để cập nhật những sản phẩm mới, nhận thông tin ưu đãi đặc biệt và thông tin giảm giá khác.</p>
                    <form class="newsletter-form" id="formSubmit">
                        <input type="email" placeholder="Nhập email của bạn" class="newsletter-input">
                        <button type="submit" class="newsletter-button">ĐĂNG KÝ</button>
                    </form>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-tiktok"></i></a>
                    </div>

                    <div class="payment-methods">
                        <img src="./assets/images/bank-images.webp" alt="Phương thức thanh toán">
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="copyright">© <script>
                        document.write(new Date().getFullYear());
                    </script> Arrowwai. Tất cả các quyền được bảo lưu.</p>

            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const formSubmit = document.getElementById("formSubmit");
            if (formSubmit) {
                formSubmit.addEventListener("submit", (e) => {
                    e.preventDefault();
                    alert("Gửi thành công!");
                });
            }
        });
    </script>