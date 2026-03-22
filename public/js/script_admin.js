
document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const loading = document.querySelector('.loading');
            const formContainer = document.getElementById('formContainer');
            const scrollToTopBtn = document.getElementById('scrollToTop');
            
            // Xác thực form
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                let isValid = true;
                
                // Xóa thông báo lỗi trước đó
                clearErrors();
                
                // Kiểm tra username
                const username = document.getElementById('username').value.trim();
                if (!username) {
                    showError('usernameError', 'Vui lòng nhập tên đăng nhập');
                    isValid = false;
                } else if (username.length < 4) {
                    showError('usernameError', 'Tên đăng nhập phải có ít nhất 4 ký tự');
                    isValid = false;
                }
                
                // Kiểm tra password
                const password = document.getElementById('password').value;
                if (!password) {
                    showError('passwordError', 'Vui lòng nhập mật khẩu');
                    isValid = false;
                } else if (password.length < 6) {
                    showError('passwordError', 'Mật khẩu phải có ít nhất 6 ký tự');
                    isValid = false;
                }
                
                // Kiểm tra email
                const email = document.getElementById('email').value.trim();
                if (!email) {
                    showError('emailError', 'Vui lòng nhập email');
                    isValid = false;
                } else if (!isValidEmail(email)) {
                    showError('emailError', 'Email không hợp lệ');
                    isValid = false;
                }
                
                // Kiểm tra họ tên
                const fullName = document.getElementById('full_name').value.trim();
                if (!fullName) {
                    showError('fullNameError', 'Vui lòng nhập họ và tên');
                    isValid = false;
                }
                
                // Kiểm tra vai trò
                const roleId = document.getElementById('role_id').value;
                if (roleId === '') {
                    showError('roleError', 'Vui lòng chọn vai trò');
                    isValid = false;
                }
                
                // Kiểm tra trạng thái
                const status = document.querySelector('input[name="status"]:checked');
                if (!status) {
                    showError('statusError', 'Vui lòng chọn trạng thái');
                    isValid = false;
                }
                
                if (isValid) {
                    // Hiển thị loading
                    document.querySelector('.btn-register span').style.opacity = '0';
                    loading.style.display = 'block';
                    
                    // Mô phỏng gửi dữ liệu (trong thực tế sẽ gửi đến server)
                    setTimeout(() => {
                        loading.style.display = 'none';
                        document.querySelector('.btn-register span').style.opacity = '1';
                        alert('Đăng ký thành công!');
                        form.reset();
                    }, 2000);
                }
            });
            
            // Hiển thị nút scroll to top khi cuộn
            formContainer.addEventListener('scroll', function() {
                if (formContainer.scrollTop > 200) {
                    scrollToTopBtn.classList.add('show');
                } else {
                    scrollToTopBtn.classList.remove('show');
                }
            });
            
            // Xử lý sự kiện click nút scroll to top
            scrollToTopBtn.addEventListener('click', function() {
                formContainer.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
            
            function showError(id, message) {
                const errorElement = document.getElementById(id);
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }
            
            function clearErrors() {
                const errorElements = document.querySelectorAll('.error-message');
                errorElements.forEach(element => {
                    element.style.display = 'none';
                });
            }
            
            function isValidEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
        });

// Chức năng hiển thị/ẩn mật khẩu
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.querySelector('.password-toggle i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
window.togglePassword = togglePassword; 