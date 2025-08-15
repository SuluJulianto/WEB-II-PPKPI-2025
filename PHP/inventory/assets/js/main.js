// Highlight menu aktif sederhana
(function () {
  const path = window.location.pathname;
  document.querySelectorAll('.navbar .nav-link').forEach(a => {
    if (path.includes(a.getAttribute('href'))) a.classList.add('active');
  });
})();
