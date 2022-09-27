<?php
$nombre = $_SESSION['nombre'];
?>


<?php include 'template/scripts.php' ?>
<div class="container">
  <section id="sidebar">
    <ul>
      <li><img id="User_logo" src="img/User_logo.png" alt="User Logo"></li>
      <h4><?php echo $nombre ?></h4>
      <li><a href="index.php">Home</a></li>

      <li id="li_Academia">COE - ACADEMIA
        <ul id="COE_Academia" style="font-size: 12pt;">
          <li><a href="coe-general.php">General</a></li>
          <li><a href="coe-cuenta.php">Cuenta</a></li>
          <li><a href="coe-curso.php">Curso</a></li>
          <li><a href="coe-orador.php">Orador</a></li>
        </ul>
      </li>
      <li>CAPITAL HUMANO</li>
      <li>COLABORADORES</li>
      <a id="logout" href="logout.php">Logout</a>
    </ul>
  </section>
  <div id="toggle-btn">
    <span>&#9776</span>
  </div>

</div>

<!-- TOGGLE OCULTAR NAVEGADOR -->
<script>
  $('#toggle-btn').click(function() {
    $('#sidebar').toggleClass("active");
  })
</script>
<script>
  $('#li_Academia').click(function() {
    $('#COE_Academia').toggleClass("active");
  })
</script>
<!-- --------------------------- -->