<?php
  require("./utils/helpers.php");
  $alert = decodeAlert();
?>

<?php if ($alert): ?>

  <script>
    alert(`<?= $alert['message']; ?>`)
  </script>

<?php unset($_SESSION["APP_ALERT"]); endif; ?>