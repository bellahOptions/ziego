// Ziego Furniture & Interiors — App JS

// ========================
// CART COUNT UPDATE
// ========================
function updateCartCount() {
    fetch('/cart', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .catch(() => {});
}

// ========================
// SMOOTH REVEAL ON SCROLL (Intersection Observer)
// ========================
document.addEventListener('DOMContentLoaded', () => {
    const revealEls = document.querySelectorAll('.product-card, .category-card, .testimonial-card, .stat-card');

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        revealEls.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(el);
        });
    }
});

// ========================
// NAV SCROLL EFFECT
// ========================
document.addEventListener('DOMContentLoaded', () => {
    const nav = document.querySelector('nav');
    if (!nav) return;

    const updateNav = () => {
        if (window.scrollY > 60) {
            nav.style.boxShadow = '0 4px 30px rgba(52,28,2,0.3)';
        } else {
            nav.style.boxShadow = 'none';
        }
    };

    window.addEventListener('scroll', updateNav, { passive: true });
    updateNav();
});

// ========================
// FORM SUBMIT LOADING STATE
// ========================
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function () {
            const btn = this.querySelector('button[type="submit"]');
            if (btn && !btn.dataset.noLoading) {
                const original = btn.innerHTML;
                btn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span>Processing...';
                btn.disabled = true;
                setTimeout(() => {
                    btn.innerHTML = original;
                    btn.disabled = false;
                }, 8000);
            }
        });
    });
});

// ========================
// QUANTITY INPUT BUTTONS
// ========================
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-qty-dec]').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.querySelector(btn.dataset.qtyDec);
            if (input && parseInt(input.value) > parseInt(input.min || 1)) {
                input.value = parseInt(input.value) - 1;
                input.dispatchEvent(new Event('change'));
            }
        });
    });

    document.querySelectorAll('[data-qty-inc]').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.querySelector(btn.dataset.qtyInc);
            if (input && parseInt(input.value) < parseInt(input.max || 999)) {
                input.value = parseInt(input.value) + 1;
                input.dispatchEvent(new Event('change'));
            }
        });
    });
});
