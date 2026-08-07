/* ============================================================
   MegaSklep — WordPress + WooCommerce Theme JS
   ============================================================ */

(function () {
  'use strict';

  var data = window.megaSklepData || {};
  var ajaxUrl = data.ajaxUrl || '/wp-admin/admin-ajax.php';
  var nonce   = data.nonce   || '';

  /* ---- Utils ---- */
  function qs(sel, ctx)  { return (ctx || document).querySelector(sel); }
  function qsa(sel, ctx) { return Array.from((ctx || document).querySelectorAll(sel)); }

  /* ---- Header scroll ---- */
  var header = qs('#ms-header');
  if (header) {
    window.addEventListener('scroll', function () {
      header.classList.toggle('is-scrolled', window.scrollY > 10);
    }, { passive: true });
  }

  /* ---- Mobile menu ---- */
  var mobileMenu = qs('#ms-mobile-menu');

  function openMenu() {
    if (!mobileMenu) return;
    mobileMenu.classList.add('is-open');
    mobileMenu.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }
  function closeMenu() {
    if (!mobileMenu) return;
    mobileMenu.classList.remove('is-open');
    mobileMenu.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  var hamburger  = qs('#ms-hamburger');
  var menuClose  = qs('#ms-menu-close');
  if (hamburger) hamburger.addEventListener('click', openMenu);
  if (menuClose) menuClose.addEventListener('click', closeMenu);

  /* ---- Slideshow ---- */
  var slideshow = qs('.ms-slideshow');
  if (slideshow) {
    var slides   = qsa('.ms-slide', slideshow);
    var dots     = qsa('.ms-slideshow__dot', slideshow);
    var current  = 0;
    var autoplay = slideshow.dataset.autoplay === 'true';
    var speed    = parseInt(slideshow.dataset.speed || '5', 10) * 1000;
    var timer    = null;

    function goTo(idx) {
      slides[current].classList.remove('is-active');
      if (dots[current]) dots[current].classList.remove('is-active');
      current = (idx + slides.length) % slides.length;
      slides[current].classList.add('is-active');
      if (dots[current]) dots[current].classList.add('is-active');
    }

    function startTimer() { if (autoplay && slides.length > 1) timer = setInterval(function () { goTo(current + 1); }, speed); }
    function stopTimer()  { clearInterval(timer); }

    var prevBtn = qs('.ms-slideshow__arrow--prev', slideshow);
    var nextBtn = qs('.ms-slideshow__arrow--next', slideshow);
    if (prevBtn) prevBtn.addEventListener('click', function () { stopTimer(); goTo(current - 1); startTimer(); });
    if (nextBtn) nextBtn.addEventListener('click', function () { stopTimer(); goTo(current + 1); startTimer(); });

    dots.forEach(function (dot, i) {
      dot.addEventListener('click', function () { stopTimer(); goTo(i); startTimer(); });
    });

    slideshow.addEventListener('touchstart', function (e) { slideshow._tx = e.touches[0].clientX; }, { passive: true });
    slideshow.addEventListener('touchend', function (e) {
      var diff = slideshow._tx - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 40) { stopTimer(); diff > 0 ? goTo(current + 1) : goTo(current - 1); startTimer(); }
    });

    startTimer();
  }

  /* ---- Countdown ---- */
  var cd = qs('#ms-countdown');
  if (cd) {
    var hEl = qs('#ms-cd-h'), mEl = qs('#ms-cd-m'), sEl = qs('#ms-cd-s');
    var h = parseInt(hEl && hEl.textContent, 10) || 5;
    var m = parseInt(mEl && mEl.textContent, 10) || 42;
    var s = parseInt(sEl && sEl.textContent, 10) || 17;

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

  function showToast(msg, duration) {
    if (!toast) return;
    clearTimeout(toastTimer);
    toast.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><span>' + msg + '</span><button class="ms-toast__close" onclick="this.parentElement.classList.remove(\'is-visible\')" aria-label="Zamknij"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>';
    toast.classList.add('is-visible');
    toastTimer = setTimeout(function () { toast.classList.remove('is-visible'); }, duration || 3500);
  }

  /* ---- Cart Drawer ---- */
  var cartDrawer  = qs('#ms-cart-drawer');
  var cartOverlay = qs('#ms-overlay');
  var cartCount   = qs('#ms-cart-count');
  var drawerInner = qs('#ms-cart-drawer-inner');

  function openCart() {
    if (!cartDrawer) return;
    cartDrawer.classList.add('is-open');
    cartDrawer.setAttribute('aria-hidden', 'false');
    if (cartOverlay) cartOverlay.classList.add('is-visible');
    document.body.style.overflow = 'hidden';
  }

  function closeCart() {
    if (!cartDrawer) return;
    cartDrawer.classList.remove('is-open');
    cartDrawer.setAttribute('aria-hidden', 'true');
    if (cartOverlay) cartOverlay.classList.remove('is-visible');
    document.body.style.overflow = '';
  }

  var cartTrigger = qs('#ms-cart-trigger');
  var cartClose   = qs('#ms-cart-close');
  if (cartTrigger) cartTrigger.addEventListener('click', openCart);
  if (cartClose)   cartClose.addEventListener('click', closeCart);
  if (cartOverlay) cartOverlay.addEventListener('click', closeCart);

  function updateCartCount(count) {
    if (!cartCount) return;
    cartCount.textContent = count;
    cartCount.classList.toggle('ms-hidden', count === 0);
  }

  /* ---- WooCommerce AJAX add to cart ---- */
  document.addEventListener('click', function (e) {
    var btn = e.target.closest('.ms-add-to-cart-btn[data-product-id]');
    if (!btn) return;

    e.preventDefault();
    var productId = btn.dataset.productId;
    var variantId = btn.dataset.variantId || productId;

    btn.classList.add('is-loading');

    var formData = new FormData();
    formData.append('action', 'woocommerce_ajax_add_to_cart');
    formData.append('product_id', productId);
    formData.append('variation_id', variantId);
    formData.append('quantity', '1');

    // WooCommerce built-in AJAX add to cart
    fetch('/?wc-ajax=add_to_cart', {
      method: 'POST',
      body: new URLSearchParams({ product_id: productId, variation_id: variantId, quantity: 1 })
    })
    .then(function (r) { return r.json(); })
    .then(function (res) {
      btn.classList.remove('is-loading');
      if (res.error) {
        showToast(res.product_url ? 'Wybierz wariant produktu' : 'Błąd dodawania do koszyka');
        return;
      }
      showToast((data.i18n && data.i18n.addedToCart) || 'Dodano do koszyka');
      if (res.fragments && drawerInner) {
        var frag = res.fragments['#ms-cart-drawer-inner'];
        if (frag) {
          var tmp = document.createElement('div');
          tmp.innerHTML = frag;
          drawerInner.parentNode.replaceChild(tmp.firstElementChild, drawerInner);
          drawerInner = qs('#ms-cart-drawer-inner');
          bindDrawerEvents();
        }
      }
      if (res.cart_hash !== undefined) {
        fetch('/?wc-ajax=get_refreshed_fragments')
          .then(function(r) { return r.json(); })
          .then(function(d) {
            if (d && d.fragments && d.fragments['#ms-cart-count']) {
              var tmp2 = document.createElement('div');
              tmp2.innerHTML = d.fragments['#ms-cart-count'];
              var newCount = tmp2.firstElementChild;
              if (cartCount && newCount) {
                cartCount.textContent = newCount.textContent;
                cartCount.className   = newCount.className;
              }
            }
          });
      }
      openCart();
    })
    .catch(function () {
      btn.classList.remove('is-loading');
      showToast('Błąd — spróbuj ponownie');
    });
  });

  /* ---- Cart drawer qty/remove ---- */
  function bindDrawerEvents() {
    var inner = qs('#ms-cart-drawer-inner');
    if (!inner) return;

    qsa('[data-cart-qty]', inner).forEach(function (btn) {
      btn.addEventListener('click', function () {
        var key   = btn.dataset.key;
        var delta = parseInt(btn.dataset.delta, 10);
        var qtyEl = btn.closest('.ms-qty-input').querySelector('.ms-qty-num');
        var cur   = parseInt(qtyEl ? qtyEl.textContent : 1, 10);
        var newQ  = Math.max(0, cur + delta);
        cartAjaxQty(key, newQ);
      });
    });

    qsa('[data-cart-remove]', inner).forEach(function (link) {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        var key = link.dataset.cartRemove;
        cartAjaxQty(key, 0);
      });
    });
  }

  function cartAjaxQty(key, qty) {
    var formData = new URLSearchParams();
    formData.append('action', 'megasklep_cart_qty');
    formData.append('nonce', nonce);
    formData.append('cart_item_key', key);
    formData.append('quantity', qty);

    fetch(ajaxUrl, { method: 'POST', body: formData })
    .then(function (r) { return r.json(); })
    .then(function (res) {
      // Refresh fragments
      fetch('/?wc-ajax=get_refreshed_fragments')
        .then(function (r2) { return r2.json(); })
        .then(function (d) {
          if (d && d.fragments) {
            var frag = d.fragments['#ms-cart-drawer-inner'];
            if (frag && drawerInner) {
              var tmp = document.createElement('div');
              tmp.innerHTML = frag;
              drawerInner.parentNode.replaceChild(tmp.firstElementChild, drawerInner);
              drawerInner = qs('#ms-cart-drawer-inner');
              bindDrawerEvents();
            }
            var countFrag = d.fragments['#ms-cart-count'];
            if (countFrag && cartCount) {
              var tmp2 = document.createElement('div');
              tmp2.innerHTML = countFrag;
              var newC = tmp2.firstElementChild;
              if (newC) { cartCount.textContent = newC.textContent; cartCount.className = newC.className; }
            }
          }
        });
    });
  }

  bindDrawerEvents();

  /* ---- Product page: gallery thumbs ---- */
  var galleryImg   = qs('#ms-gallery-img');
  var galleryThumbs = qsa('.ms-gallery-thumb');
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

  /* ---- Product tabs ---- */
  qsa('.ms-tab-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var target = btn.dataset.tab;
      qsa('.ms-tab-btn').forEach(function (b) { b.classList.remove('is-active'); });
      qsa('.ms-tab-panel').forEach(function (p) { p.classList.remove('is-active'); });
      btn.classList.add('is-active');
      var panel = qs('#' + target);
      if (panel) panel.classList.add('is-active');
    });
  });

  /* ---- Filter accordion ---- */
  qsa('.ms-filter-group__toggle').forEach(function (toggle) {
    toggle.addEventListener('click', function () {
      var body     = toggle.nextElementSibling;
      var expanded = toggle.getAttribute('aria-expanded') !== 'false';
      toggle.setAttribute('aria-expanded', String(!expanded));
      if (body) { body.style.display = expanded ? 'none' : ''; }
    });
  });

  /* ---- Filters toggle (mobile) ---- */
  var filtersToggle = qs('#ms-filters-toggle');
  var filtersPanel  = qs('#ms-filters');
  var filtersClose  = qs('#ms-filters-close');
  var filtersOverlay = null;

  function openFilters() {
    if (!filtersPanel) return;
    filtersPanel.classList.add('is-open');
    if (!filtersOverlay) {
      filtersOverlay = document.createElement('div');
      filtersOverlay.className = 'ms-overlay';
      filtersOverlay.style.zIndex = '150';
      document.body.appendChild(filtersOverlay);
      filtersOverlay.addEventListener('click', closeFilters);
    }
    setTimeout(function () { filtersOverlay.classList.add('is-visible'); }, 10);
    document.body.style.overflow = 'hidden';
  }

  function closeFilters() {
    if (!filtersPanel) return;
    filtersPanel.classList.remove('is-open');
    if (filtersOverlay) { filtersOverlay.classList.remove('is-visible'); }
    document.body.style.overflow = '';
  }

  if (filtersToggle) filtersToggle.addEventListener('click', openFilters);
  if (filtersClose)  filtersClose.addEventListener('click', closeFilters);

  /* ---- Attribute filter checkboxes ---- */
  qsa('.ms-attr-filter').forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
      var attr = checkbox.dataset.attr;
      var checked = qsa('.ms-attr-filter[data-attr="' + attr + '"]:checked').map(function (c) { return c.value; });
      var url = new URL(window.location.href);
      if (checked.length) { url.searchParams.set('filter_' + attr, checked.join(',')); }
      else { url.searchParams.delete('filter_' + attr); }
      url.searchParams.delete('paged');
      window.location.href = url.toString();
    });
  });

  /* ---- Sale filter ---- */
  var saleFilter = qs('.ms-sale-filter');
  if (saleFilter) {
    saleFilter.addEventListener('change', function () {
      var url = new URL(window.location.href);
      if (saleFilter.checked) { url.searchParams.set('on_sale', '1'); }
      else { url.searchParams.delete('on_sale'); }
      window.location.href = url.toString();
    });
  }

  /* ---- Wishlist (localStorage + AJAX for logged-in) ---- */
  var WISHLIST_KEY = 'ms_wishlist';
  function getWishlist()   { try { return JSON.parse(localStorage.getItem(WISHLIST_KEY) || '[]'); } catch (e) { return []; } }
  function saveWishlist(l) { localStorage.setItem(WISHLIST_KEY, JSON.stringify(l)); }

  function initWishlist() {
    var list = getWishlist();
    qsa('.ms-wishlist-btn').forEach(function (btn) {
      var id = btn.dataset.productId;
      if (list.includes(id)) btn.classList.add('is-wishlisted');

      btn.addEventListener('click', function () {
        var w   = getWishlist();
        var idx = w.indexOf(id);
        var adding = idx === -1;
        if (adding) { w.push(id); btn.classList.add('is-wishlisted'); }
        else        { w.splice(idx, 1); btn.classList.remove('is-wishlisted'); }
        saveWishlist(w);
        showToast(adding ? ((data.i18n && data.i18n.addedToWishlist) || 'Dodano do ulubionych') : 'Usunięto z ulubionych');

        // AJAX for logged-in users
        var formData = new URLSearchParams();
        formData.append('action', 'megasklep_toggle_wishlist');
        formData.append('nonce', nonce);
        formData.append('product_id', id);
        fetch(ajaxUrl, { method: 'POST', body: formData }).catch(function() {});
      });
    });
  }

  initWishlist();

  /* ---- Cart page qty buttons ---- */
  var cartItems = qs('.ms-cart-items');
  if (cartItems) {
    cartItems.addEventListener('click', function (e) {
      var upBtn   = e.target.closest('[onclick]');
      // handled inline
    });
  }

  /* ---- Newsletter ---- */
  var nlForm = qs('#ms-newsletter-form');
  if (nlForm) {
    nlForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var input = nlForm.querySelector('input[type="email"]');
      if (input && input.value) {
        nlForm.innerHTML = '<p style="color:#93c5fd;font-size:.9rem;">✓ Dziękujemy za zapis!</p>';
        showToast('Dziękujemy za zapis do newslettera!', 4000);
      }
    });
  }

  /* ---- Escape closes drawers ---- */
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { closeCart(); closeMenu(); closeFilters(); }
  });

  /* ---- Ship to different address toggle ---- */
  var shipToggle = qs('#ship-to-different-address-checkbox');
  var shipFields = qs('.ms-checkout-ship__fields');
  if (shipToggle && shipFields) {
    function updateShip() { shipFields.style.display = shipToggle.checked ? '' : 'none'; }
    shipToggle.addEventListener('change', updateShip);
    updateShip();
  }

  /* ---- WooCommerce catalog ordering ---- */
  document.addEventListener('change', function (e) {
    if (e.target.name === 'orderby') {
      e.target.closest('form') && e.target.closest('form').submit();
    }
  });

})();
