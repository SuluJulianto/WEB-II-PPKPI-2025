    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/main.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const links = document.querySelectorAll('#sidebarMenu .nav-link');
  const currentPage = window.location.href;

  links.forEach(link => {
    // Make comparison more robust by checking if the currentPage URL ends with the href value
    if (currentPage.endsWith(link.getAttribute('href'))) {
      link.classList.add('active');
    }
  });
});
</script>
</body>
</html>
