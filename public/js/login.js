
            // Clear error messages when user starts typing
            document.addEventListener('DOMContentLoaded', function() {
                const inputs = document.querySelectorAll('input, select');
                const errorMessage = document.querySelector('.error-message');
                const successMessage = document.querySelector('.success-message');
                
                // Clear error/success messages when user starts typing
                inputs.forEach(input => {
                    input.addEventListener('input', function() {
                        if (errorMessage) {
                            errorMessage.style.display = 'none';
                        }
                        if (successMessage) {
                            successMessage.style.display = 'none';
                        }
                        
                        // Remove error styling
                        this.classList.remove('error');
                    });
                    
                    // Add focus effects
                    input.addEventListener('focus', function() {
                        this.classList.remove('error');
                    });
                });
                
                // Auto-hide messages after 5 seconds
                if (errorMessage || successMessage) {
                    setTimeout(function() {
                        if (errorMessage) errorMessage.style.display = 'none';
                        if (successMessage) successMessage.style.display = 'none';
                    }, 5000);
                }
            });
