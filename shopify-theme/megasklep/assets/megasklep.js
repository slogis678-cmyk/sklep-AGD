/* ============================================================
   MegaSklep Theme — megasklep.js
   ============================================================ */

(function () {
  'use strict';

  /* ---- Utility ---- */
  function $(sel, ctx) { return (ctx || document).querySelector(sel); }
  function $$(sel, ctx) { return Array.from((ctx || document).querySelectorAll(sel)); }
  function qs(sel) { return document.querySelector(sel); }

  function formatMoney(cents) {
    return (cents / 100).toLocaleString('pl-PL', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' zł';
  }

  /* ---- Header scroll state ---- */
  var header = qs('#ms-header');
  if (header) {
    window.addEventListener('scroll', function () {
      header.classList.toggle('is-scrolled', window.scrollY > 10);
    }, { passive: true });
  }

  /* ---- Mobile menu ---- */
  var mobileMenu = qs('#ms-mobile-menu');
  var menuOpen = false;

  function openMenu() {
    if (!mobileMenu) return;
    mobileMenu.classList.add('is-open');
    mobileMenu.setAttribute('aria-hidden', 'false');
    menuOpen = true;
  }

  function closeMenu() {
    if (!mobileMenu) return;
    mobileMenu.classList.remove('is-open');
    mobileMenu.setAttribute('aria-hidden', 'true');
    menuOpen = false;
  }

  $$('[data-menu-toggle]').forEach(function (btn) { btn.addEventListener('click', openMenu); });
  $$('[data-menu-close]').forEach(function (btn) { btn.addEventListener('click', closeMenu); });

  /* ---- Slideshow ---- */
  var slideshow = qs('.ms-slideshow');
  if (slideshow) {
    var slides = $$('.ms-slide', slideshow);
    var dots = $$('.ms-slideshow__dot', slideshow);
    var current = 0;
    var autoplay = slideshow.dataset.autoplay === 'true';
    var speed = parseInt(slideshow.dataset.speed || '5', 10) * 1000;
    var timer = null;

    function goTo(idx) {
      slides[current].classList.remove('is-active');
      if (dots[current]) dots[current].classList.remove('is-active');
      current = (idx + slides.length) % slides.length;
      slides[current].classList.add('is-active');
      if (dots[current]) dots[current].classList.add('is-active');
    }

    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }

    function startTimer() {
      if (autoplay && slides.length > 1) timer = setInterval(next, speed);
    }
    function stopTimer() { clearInterval(timer); }

    var prevBtn = qs('.ms-slideshow__arrow--prev', slideshow);
    var nextBtn = qs('.ms-slideshow__arrow--next', slideshow);
    if (prevBtn) prevBtn.addEventListener('click', function () { stopTimer(); prev(); startTimer(); });
    if (nextBtn) nextBtn.addEventListener('click', function () { stopTimer(); next(); startTimer(); });

    dots.forEach(function (dot, i) {
      dot.addEventListener('click', function () { stopTimer(); goTo(i); startTimer(); });
    });

    startTimer();

    // Touch support
    var touchStartX = 0;
    slideshow.addEventListener('touchstart', function (e) { touchStartX = e.touches[0].clientX; }, { passive: true });
    slideshow.addEventListener('touchend', function (e) {
      var diff = touchStartX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 40) { stopTimer(); diff > 0 ? next() : prev(); startTimer(); }
    });
  }

  /* ---- Countdown timer ---- */
  var countdown = qs('.ms-countdown');
  if (countdown) {
    var h = parseInt(countdown.querySelector('#ms-cd-hours').textContent, 10) || 5;
    var m = parseInt(countdown.querySelector('#ms-cd-minutes').textContent, 10) || 42;
    var s = parseInt(countdown.querySelector('#ms-cd-seconds').textContent, 10) || 17;

    var hEl = qs('#ms-cd-hours');
    var mEl = qs('#ms-cd-minutes');
    var sEl = qs('#ms-cd-seconds');

    function pad(n) { return String(n).padStart(2, '0'); }

    setInterval(function () {
      s--;
      if (s < 0) { s = 59; m--; }
      if (m < 0) { m = 59; h--; }
      if (h < 0) { h = 23; m = 59; s = 59; }
      if (hEl) hEl.textContent = pad(h);
      if (mEl) mEl.textContent = pad(m);
      if (sEl) sEl.textContent = pad(s);
    }, 1000);
  }

  /* ---- Toast ---- */
  var toast = qs('#ms-toast');
  var toastTimer = null;

  function showToast(message, duration) {
    if (!toast) return;
    clearTimeout(toastTimer);
    toast.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><span>' + message + '</span><button class="ms-toast__close" onclick="this.parentElement.classList.remove(\'is-visible\')" aria-label="Zamknij"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>';
    toast.classList.add('is-visible');
    toastTimer = setTimeout(function () { toast.classList.remove('is-visible'); }, duration || 3000);
  }

  /* ---- Cart Drawer ---- */
  var cartDrawer = qs('#ms-cart-drawer');
  var cartOverlay = qs('#ms-overlay');
  var cartCount = qs('#ms-cart-count');
  var drawerBody = qs('#ms-cart-drawer-body');
  var drawerFooter = qs('#ms-cart-drawer-footer');
  var drawerTotal = qs('#ms-drawer-total');
  var drawerItemCount = qs('#ms-drawer-count');
  var shippingNotice = qs('#ms-shipping-notice');

  function openCart() {
    if (!cartDrawer) return;
    cartDrawer.classList.add('is-open');
    cartDrawer.setAttribute('aria-hidden', 'false');
    if (cartOverlay) { cartOverlay.style.display = 'block'; setTimeout(function () { cartOverlay.classList.add('is-visible'); }, 10); }
    document.body.style.overflow = 'hidden';
    refreshCartDrawer();
  }

  function closeCart() {
    if (!cartDrawer) return;
    cartDrawer.classList.remove('is-open');
    cartDrawer.setAttribute('aria-hidden', 'true');
    if (cartOverlay) { cartOverlay.classList.remove('is-visible'); setTimeout(function () { cartOverlay.style.display = 'none'; }, 300); }
    document.body.style.overflow = '';
  }

  // Cart triggers
  $$('[data-cart-trigger]').forEach(function (btn) { btn.addEventListener('click', openCart); });
  var closeBtn = qs('#ms-cart-close');
  if (closeBtn) closeBtn.addEventListener('click', closeCart);
  if (cartOverlay) cartOverlay.addEventListener('click', closeCart);
  var continueBtn = qs('#ms-continue-shopping');
  if (continueBtn) continueBtn.addEventListener('click', closeCart);

  function updateCartCount(count) {
    if (!cartCount) return;
    if (count > 0) { cartCount.textContent = count; cartCount.style.display = 'flex'; }
    else { cartCount.style.display = 'none'; }
  }

  function renderCartDrawer(cart) {
    if (!drawerBody) return;
    var freeShipping = 29900;

    if (cart.item_count === 0) {
      drawerBody.innerHTML = '<div class="ms-cart-drawer__empty"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg><p style="font-weight:600;color:#374151;">Koszyk jest pusty</p><p>Dodaj produkty, aby kontynuować</p></div>';
      if (drawerFooter) drawerFooter.style.display = 'none';
      return;
    }

    var html = '';
    cart.items.forEach(function (item) {
      var imgSrc = item.featured_image && item.featured_image.url ? item.featured_image.url.split('?')[0] + '?width=144' : '';
      var imgHtml = imgSrc
        ? '<img class="ms-cart-drawer__item-img" src="' + imgSrc + '" alt="' + (item.title || '') + '" loading="lazy" width="72" height="72">'
        : '<div class="ms-cart-drawer__item-img" style="background:#f3f4f6;border-radius:.625rem;"></div>';

      html += '<div class="ms-cart-drawer__item" data-key="' + item.key + '">';
      html += '<a href="' + item.url + '">' + imgHtml + '</a>';
      html += '<div class="ms-cart-drawer__item-info">';
      html += '<div class="ms-cart-drawer__item-brand">' + (item.vendor || '') + '</div>';
      html += '<a href="' + item.url + '" class="ms-cart-drawer__item-title">' + item.product_title + '</a>';
      if (item.variant_title && item.variant_title !== 'Default Title') {
        html += '<div class="ms-cart-drawer__item-variant">' + item.variant_title + '</div>';
      }
      html += '<div class="ms-cart-drawer__item-row">';
      html += '<span class="ms-cart-drawer__item-price">' + formatMoney(item.final_line_price) + '</span>';
      html += '<div class="ms-qty-input">';
      html += '<button class="ms-qty-btn" data-cart-qty-minus data-key="' + item.key + '" aria-label="Zmniejsz"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/></svg></button>';
      html += '<span class="ms-qty-num">' + item.quantity + '</span>';
      html += '<button class="ms-qty-btn" data-cart-qty-plus data-key="' + item.key + '" aria-label="Zwiększ"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></button>';
      html += '</div>';
      html += '</div>';
      html += '</div>';
      html += '<button class="ms-cart-drawer__item-remove" data-cart-remove data-key="' + item.key + '" aria-label="Usuń"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg></button>';
      html += '</div>';
    });

    drawerBody.innerHTML = html;

    // Footer
    if (drawerFooter) {
      drawerFooter.style.display = 'block';
      if (drawerTotal) drawerTotal.textContent = formatMoney(cart.total_price);
      if (drawerItemCount) {
        var c = cart.item_count;
        drawerItemCount.textContent = c;
        drawerItemCount.style.display = c > 0 ? 'flex' : 'none';
      }

      // Shipping notice
      if (shippingNotice) {
        if (cart.total_price < freeShipping) {
          var remaining = freeShipping - cart.total_price;
          var pct = Math.min(Math.round(cart.total_price / freeShipping * 100), 100);
          shippingNotice.innerHTML = '<p class="ms-cart-drawer__shipping-text">Do darmowej dostawy: <strong>' + formatMoney(remaining) + '</strong></p><div class="ms-progress-bar"><div class="ms-progress-bar__fill" style="width:' + pct + '%"></div></div>';
        } else {
          shippingNotice.innerHTML = '<p style="color:#059669;font-size:.8rem;font-weight:600;margin-bottom:.5rem;">✓ Masz darmową dostawę!</p>';
        }
      }
    }

    // Bind qty/remove events
    bindCartEvents(drawerBody);
    updateCartCount(cart.item_count);
  }

  function bindCartEvents(ctx) {
    $$(('[data-cart-remove]'), ctx).forEach(function (btn) {
      btn.addEventListener('click', function () { cartChange(btn.dataset.key, 0); });
    });
    $$('[data-cart-qty-minus]', ctx).forEach(function (btn) {
      btn.addEventListener('click', function () { cartChangeByDelta(btn.dataset.key, -1); });
    });
    $$('[data-cart-qty-plus]', ctx).forEach(function (btn) {
      btn.addEventListener('click', function () { cartChangeByDelta(btn.dataset.key, 1); });
    });
  }

  function cartChange(key, quantity) {
    fetch('/cart/change.js', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id: key, quantity: quantity })
    })
    .then(function (r) { return r.json(); })
    .then(function (cart) { renderCartDrawer(cart); updateCartCount(cart.item_count); });
  }

  function cartChangeByDelta(key, delta) {
    // Find current qty from DOM
    var item = qs('[data-key="' + key + '"]');
    if (!item) return;
    var qtyEl = item.querySelector('.ms-qty-num');
    var current = qtyEl ? parseInt(qtyEl.textContent, 10) : 1;
    var newQty = Math.max(0, current + delta);
    cartChange(key, newQty);
  }

  function refreshCartDrawer() {
    if (drawerBody) drawerBody.innerHTML = '<div class="ms-cart-drawer__loading"><svg class="ms-spinner" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg></div>';
    fetch('/cart.js')
    .then(function (r) { return r.json(); })
    .then(function (cart) { renderCartDrawer(cart); })
    .catch(function () {
      if (drawerBody) drawerBody.innerHTML = '<p style="padding:1rem;color:#6b7280;text-align:center;">Nie można załadować koszyka.</p>';
    });
  }

  /* ---- Add to cart (AJAX) ---- */
  document.addEventListener('click', function (e) {
    var btn = e.target.closest('[data-variant-id].ms-add-to-cart-btn, .ms-add-to-cart');

    // Product card button
    if (btn && btn.dataset.variantId) {
      e.preventDefault();
      var id = btn.dataset.variantId;
      var title = btn.dataset.productTitle || 'Produkt';
      btn.classList.add('is-loading');
      fetch('/cart/add.js', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id, quantity: 1 })
      })
      .then(function (r) { return r.json(); })
      .then(function () {
        btn.classList.remove('is-loading');
        return fetch('/cart.js');
      })
      .then(function (r) { return r.json(); })
      .then(function (cart) {
        updateCartCount(cart.item_count);
        showToast('Dodano do koszyka: ' + title);
        openCart();
      })
      .catch(function () { btn.classList.remove('is-loading'); });
      return;
    }

    // Product page form add to cart
    var addBtn = e.target.closest('.ms-add-to-cart');
    if (addBtn && addBtn.closest('#ms-product-form')) {
      e.preventDefault();
      var form = addBtn.closest('#ms-product-form');
      var variantId = form.querySelector('#ms-variant-id') ? form.querySelector('#ms-variant-id').value : null;
      var qty = form.querySelector('#ms-qty') ? parseInt(form.querySelector('#ms-qty').value, 10) : 1;
      if (!variantId) return;
      addBtn.disabled = true;
      addBtn.innerHTML = '<svg class="ms-spinner" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Dodawanie...';
      fetch('/cart/add.js', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: variantId, quantity: qty })
      })
      .then(function (r) { return r.json(); })
      .then(function () { return fetch('/cart.js'); })
      .then(function (r) { return r.json(); })
      .then(function (cart) {
        updateCartCount(cart.item_count);
        addBtn.disabled = false;
        addBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg> Dodano!';
        showToast('Dodano do koszyka');
        openCart();
        setTimeout(function () {
          addBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg> Dodaj do koszyka';
        }, 2000);
      })
      .catch(function () { addBtn.disabled = false; });
    }
  });

  /* ---- Cart page AJAX qty/remove ---- */
  var cartPage = qs('.ms-cart-items');
  if (cartPage) {
    function handleCartPage(key, qty) {
      fetch('/cart/change.js', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: key, quantity: qty })
      })
      .then(function () { window.location.reload(); });
    }
    cartPage.addEventListener('click', function (e) {
      var minusBtn = e.target.closest('[data-cart-qty-minus]');
      var plusBtn = e.target.closest('[data-cart-qty-plus]');
      var removeBtn = e.target.closest('[data-cart-remove]');
      if (minusBtn) {
        var row = minusBtn.closest('.ms-cart-item');
        var qtyEl = row.querySelector('.ms-qty-num');
        handleCartPage(minusBtn.dataset.key, Math.max(0, parseInt(qtyEl.textContent, 10) - 1));
      }
      if (plusBtn) {
        var row2 = plusBtn.closest('.ms-cart-item');
        var qtyEl2 = row2.querySelector('.ms-qty-num');
        handleCartPage(plusBtn.dataset.key, parseInt(qtyEl2.textContent, 10) + 1);
      }
      if (removeBtn) { handleCartPage(removeBtn.dataset.key, 0); }
    });
  }

  /* ---- Product page: gallery thumbs ---- */
  var galleryThumbs = $$('.ms-gallery-thumb');
  var galleryImg = qs('#ms-gallery-img');
  galleryThumbs.forEach(function (thumb) {
    thumb.addEventListener('click', function () {
      galleryThumbs.forEach(function (t) { t.classList.remove('is-active'); });
      thumb.classList.add('is-active');
      if (galleryImg) {
        galleryImg.src = thumb.dataset.src;
        galleryImg.alt = thumb.dataset.alt || '';
      }
    });
  });

  /* ---- Product page: qty +/- ---- */
  var qtyInput = qs('#ms-qty');
  $$('[data-qty-minus], [data-qty-plus]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      if (!qtyInput) return;
      var cur = parseInt(qtyInput.value, 10) || 1;
      qtyInput.value = btn.hasAttribute('data-qty-plus') ? cur + 1 : Math.max(1, cur - 1);
    });
  });

  /* ---- Wishlist (localStorage) ---- */
  var WISHLIST_KEY = 'ms_wishlist';
  function getWishlist() { try { return JSON.parse(localStorage.getItem(WISHLIST_KEY) || '[]'); } catch (e) { return []; } }
  function saveWishlist(list) { localStorage.setItem(WISHLIST_KEY, JSON.stringify(list)); }

  function initWishlistBtns() {
    var list = getWishlist();
    $$('.ms-wishlist-btn').forEach(function (btn) {
      var id = btn.dataset.productId;
      if (id && list.includes(id)) { btn.classList.add('is-wishlisted'); }
      btn.addEventListener('click', function () {
        var w = getWishlist();
        var idx = w.indexOf(id);
        if (idx === -1) { w.push(id); btn.classList.add('is-wishlisted'); showToast('Dodano do ulubionych'); }
        else { w.splice(idx, 1); btn.classList.remove('is-wishlisted'); showToast('Usunięto z ulubionych'); }
        saveWishlist(w);
      });
    });
  }

  initWishlistBtns();

  /* ---- Filter accordion ---- */
  $$('.ms-filter-group__toggle').forEach(function (toggle) {
    toggle.addEventListener('click', function () {
      var body = toggle.nextElementSibling;
      var expanded = toggle.getAttribute('aria-expanded') !== 'false';
      toggle.setAttribute('aria-expanded', String(!expanded));
      if (body) { body.style.display = expanded ? 'none' : ''; }
    });
  });

  /* ---- Newsletter form ---- */
  var newsletterForm = qs('#ms-newsletter-form');
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', function (e) {
      var input = newsletterForm.querySelector('input[type="email"]');
      if (input && input.value) {
        showToast('Dziękujemy za zapis!', 4000);
      }
    });
  }

  /* ---- Escape key closes drawer / menu ---- */
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { closeCart(); closeMenu(); }
  });

  /* ---- Initial cart count ---- */
  fetch('/cart.js')
    .then(function (r) { return r.json(); })
    .then(function (cart) { updateCartCount(cart.item_count); })
    .catch(function () {});

})();
