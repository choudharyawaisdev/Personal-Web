// Main JavaScript file for Portfolio Website

document.addEventListener('DOMContentLoaded', () => {
    // 1. Page Loader Fade-out
    const loader = document.getElementById('loader');
    if (loader) {
        setTimeout(() => {
            loader.style.opacity = '0';
            loader.style.transition = 'opacity 0.4s ease';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 400);
        }, 300); // Small timeout to ensure styling is loaded
    }

    // 2. Scroll Progress and Header Sticky Effect
    const nav = document.getElementById('main-nav');
    const scrollProgress = document.getElementById('scroll-progress');
    
    window.addEventListener('scroll', () => {
        // Sticky navigation background update
        if (nav) {
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        }

        // Scroll Progress calculation
        if (scrollProgress) {
            const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            if (windowHeight > 0) {
                const scrolledPercentage = (window.scrollY / windowHeight) * 100;
                scrollProgress.style.width = `${scrolledPercentage}%`;
            }
        }
    });

    // 3. Mobile Navigation Menu Toggle
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileBtn && mobileMenu) {
        mobileBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            const icon = mobileBtn.querySelector('i');
            if (mobileMenu.classList.contains('hidden')) {
                icon.className = 'fa-solid fa-bars text-xl';
            } else {
                icon.className = 'fa-solid fa-xmark text-xl';
            }
        });

        // Close menu on navigation link click
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                const icon = mobileBtn.querySelector('i');
                icon.className = 'fa-solid fa-bars text-xl';
            });
        });
    }

    // 4. Dark / Light Theme Toggle Mode
    const themeBtn = document.getElementById('theme-toggle');
    const htmlEl = document.documentElement;

    // Check saved mode or default to system preferences (or default to dark as per user specs)
    const savedTheme = localStorage.getItem('theme') || 'dark';
    if (savedTheme === 'light') {
        htmlEl.classList.remove('dark');
        htmlEl.classList.add('light');
    } else {
        htmlEl.classList.remove('light');
        htmlEl.classList.add('dark');
    }

    if (themeBtn) {
        themeBtn.addEventListener('click', () => {
            if (htmlEl.classList.contains('dark')) {
                htmlEl.classList.remove('dark');
                htmlEl.classList.add('light');
                localStorage.setItem('theme', 'light');
                showToast('Switched to Light Mode', 'success');
            } else {
                htmlEl.classList.remove('light');
                htmlEl.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                showToast('Switched to Dark Mode', 'success');
            }
        });
    }

    // 5. Custom Animated Toast Notifications
    window.showToast = function(message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;
        
        const toast = document.createElement('div');
        toast.className = `glass-card p-4 flex items-center justify-between gap-3 translate-y-5 opacity-0 transition duration-300 pointer-events-auto rounded-xl border border-opacity-35 ${
            type === 'success' ? 'border-emerald-500/40 bg-emerald-950/20' : 'border-rose-500/40 bg-rose-950/20'
        }`;
        
        const iconClass = type === 'success' ? 'fa-circle-check text-emerald-500' : 'fa-circle-exclamation text-rose-500';
        
        toast.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="fa-solid ${iconClass} text-lg"></i>
                <span class="text-xs sm:text-sm font-medium text-white">${message}</span>
            </div>
            <button class="text-neutral-500 hover:text-white transition" onclick="this.parentElement.remove()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        `;
        
        container.appendChild(toast);
        
        // Trigger transition
        setTimeout(() => {
            toast.classList.remove('translate-y-5', 'opacity-0');
        }, 50);
        
        // Auto remove toast
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-[-10px]');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 4500);
    };

    // 6. Scroll Fade-in effects using Intersection Observer
    const fadeElements = document.querySelectorAll('.fade-in-scroll');
    if ('IntersectionObserver' in window && fadeElements.length > 0) {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        fadeElements.forEach(el => observer.observe(el));
    } else {
        // Fallback for older browsers
        fadeElements.forEach(el => el.classList.add('is-visible'));
    }

    // 7. Portfolio Dynamic Sorting Filters
    const filterButtons = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-card-item');

    if (filterButtons.length > 0 && projectCards.length > 0) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                // Update active state class
                filterButtons.forEach(b => b.classList.remove('bg-accent', 'text-white'));
                filterButtons.forEach(b => b.classList.add('btn-outline-custom'));
                
                btn.classList.add('bg-accent', 'text-white');
                btn.classList.remove('btn-outline-custom');

                const filterValue = btn.getAttribute('data-filter');

                projectCards.forEach(card => {
                    const projectCategory = card.getAttribute('data-category');
                    
                    if (filterValue === 'all' || projectCategory === filterValue) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1)';
                        }, 50);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.9)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 250);
                    }
                });
            });
        });
    }

    // 8. Contact AJAX form submission handler
    const contactForm = document.getElementById('contact-ajax-form');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Fetch form elements
            const nameInput = document.getElementById('contact-name');
            const emailInput = document.getElementById('contact-email');
            const messageInput = document.getElementById('contact-message');
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const csrfInput = contactForm.querySelector('input[name="csrf_token"]');

            if (!nameInput || !emailInput || !messageInput || !submitBtn) {
                return;
            }

            // Client side validation
            if (!nameInput.value.trim() || !emailInput.value.trim() || !messageInput.value.trim()) {
                showToast('All contact fields are required.', 'danger');
                return;
            }

            // Simple email validation regex
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(emailInput.value.trim())) {
                showToast('Please enter a valid email address.', 'danger');
                return;
            }

            // Show loading state on button
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<i class="fa-solid fa-spinner animate-spin mr-2"></i> Sending...`;

            // Setup AJAX form data
            const formData = new FormData();
            formData.append('name', nameInput.value.trim());
            formData.append('email', emailInput.value.trim());
            formData.append('message', messageInput.value.trim());
            formData.append('csrf_token', csrfInput ? csrfInput.value : '');
            formData.append('ajax_submit', '1');

            // Send POST request to contact.php
            fetch('contact.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response error.');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    showToast(data.message, 'success');
                    contactForm.reset();
                } else {
                    showToast(data.message || 'An error occurred. Please try again.', 'danger');
                }
            })
            .catch(error => {
                console.error('AJAX Error:', error);
                showToast('Something went wrong. Message failed to send.', 'danger');
            })
            .finally(() => {
                // Restore button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            });
        });
    }
});
