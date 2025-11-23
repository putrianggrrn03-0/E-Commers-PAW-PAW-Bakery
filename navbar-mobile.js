document.addEventListener('DOMContentLoaded', function() {
  console.log('DOM loaded, initializing navbar'); // Debug log
  
  const navbarToggler = document.querySelector('.navbar-toggler');
  const navbarCollapse = document.querySelector('#mainNavbar') || document.querySelector('.navbar-collapse');
  const body = document.body;
  
  console.log('Navbar elements found:', {
    toggler: !!navbarToggler,
    collapse: !!navbarCollapse
  });
  
  let closeBtn = document.querySelector('.navbar-close-btn');

  if (!closeBtn && navbarCollapse) {
    console.log('Creating close button');
    closeBtn = document.createElement('button');
    closeBtn.type = 'button';
    closeBtn.className = 'navbar-close-btn';
    closeBtn.setAttribute('aria-label', 'Close navigation menu');
    closeBtn.innerHTML = `
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    `;
    
    navbarCollapse.insertBefore(closeBtn, navbarCollapse.firstChild);
    console.log('Close button added to navbar');
    
    closeBtn.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      console.log('Direct close button clicked');
      closeNavbar();
    });
  }

  document.addEventListener('click', function(e) {
    if (e.target.closest('.navbar-close-btn')) {
      e.preventDefault();
      e.stopPropagation();
      console.log('Close button clicked'); // Debug log
      closeNavbar();
    }
  });

  if (navbarToggler && navbarCollapse) {
    navbarToggler.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      
      const isCurrentlyOpen = navbarCollapse.classList.contains('show');
      console.log('Toggler clicked, screen width:', window.innerWidth, 'current state:', isCurrentlyOpen);
      console.log('Navbar collapse element:', navbarCollapse);
      
      if (isCurrentlyOpen) {
        closeNavbar();
      } else {
        openNavbar();
      }
    });
  }

  document.addEventListener('click', function(e) {
    const navLink = e.target.closest('.nav-link');
    if (navLink && navbarCollapse && navbarCollapse.classList.contains('show')) {
      console.log('Nav link clicked:', navLink.href || navLink.textContent);

      if (!navLink.classList.contains('dropdown-toggle')) {
        // Untuk modal triggers, tutup navbar segera
        if (navLink.hasAttribute('data-bs-toggle')) {
          closeNavbar();
        } else {
          setTimeout(() => {
            closeNavbar();
          }, 150);
        }
      }
    }
  });

  document.addEventListener('click', function(event) {
    if (window.innerWidth <= 991 && navbarCollapse && navbarCollapse.classList.contains('show')) {
      const navbar = document.querySelector('.navbar');
      const isClickInsideNavbar = navbar && navbar.contains(event.target);
      const isClickInsideSidebar = navbarCollapse && navbarCollapse.contains(event.target);
      
      if (!isClickInsideNavbar && !isClickInsideSidebar) {
        closeNavbar();
      }
    }
  });

  window.addEventListener('resize', function() {
    if (window.innerWidth > 991) {
      // Desktop view - reset navbar state
      if (navbarCollapse) {
        navbarCollapse.classList.remove('show');
        body.classList.remove('navbar-open');
      }
    }
  });

  setTimeout(() => {
    highlightActiveLink();
  }, 100);

  function openNavbar() {
    console.log('Opening navbar, element:', navbarCollapse); // Debug log
    if (navbarCollapse) {
      navbarCollapse.classList.add('show');
      body.classList.add('navbar-open');
      document.documentElement.style.overflow = 'hidden';
      
      if (navbarToggler) {
        navbarToggler.setAttribute('aria-expanded', 'true');
      }
      
      navbarCollapse.offsetHeight;
      
      console.log('Navbar opened, classes:', navbarCollapse.className);
    } else {
      console.error('navbarCollapse not found!');
    }
  }

  function closeNavbar() {
    console.log('Closing navbar'); // Debug log
    if (navbarCollapse) {
      navbarCollapse.classList.remove('show');
      body.classList.remove('navbar-open');
      document.documentElement.style.overflow = '';
      
      if (navbarToggler) {
        navbarToggler.setAttribute('aria-expanded', 'false');
      }
    }
  }

  function highlightActiveLink() {
    const currentLocation = location.pathname;
    const currentQuery = location.search;
    const allNavLinks = document.querySelectorAll('.nav-link');
    
    allNavLinks.forEach(link => {
      link.classList.remove('active');
      const href = link.getAttribute('href');
      
      if (href) {

        const normalizedHref = href.replace(/\.\.\//g, '').replace(/^\.\//g, '');
        const normalizedLocation = currentLocation.replace(/^\/E-Commers-PAW-PAW-Bakery\//g, '').replace(/^\//g, '');

        const isMatch = 
          (href === '#') ||
          (href === currentLocation) ||
          (normalizedLocation.includes(normalizedHref) && normalizedHref !== '') ||
          (normalizedHref !== '' && currentLocation.includes(normalizedHref)) ||
          (href.includes('index.php') && (currentLocation.endsWith('/') || currentLocation.endsWith('index.php')));
        
        if (isMatch && href !== '#') {
          link.classList.add('active');
        }
      }
    });
  }

  window.navbarMobile = {
    openNavbar: openNavbar,
    closeNavbar: closeNavbar,
    highlightActiveLink: highlightActiveLink
  };
});
