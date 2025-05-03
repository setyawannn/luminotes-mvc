</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const button = document.querySelector('button[aria-expanded]');
    if (button) {
      button.addEventListener('click', function() {
        const expanded = this.getAttribute('aria-expanded') === 'true' || false;
        this.setAttribute('aria-expanded', !expanded);
        const menu = document.querySelector('.sm\\:hidden');
        menu.classList.toggle('hidden');
      });
    }
  });
</script>
<script src="<?= BASEURL; ?>/js/script.js"></script>
</body>
</html>