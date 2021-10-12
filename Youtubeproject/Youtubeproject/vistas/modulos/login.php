<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Sistema de informacion</b>WEB</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicio de sesión</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="ingUsuario" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="ingPassword" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>

        <?php
          $login = new ControladorUsuarios();
          $login ->ctrIngreso();
        ?>
      </form>

     
      <!-- /.social-auth-links -->

          </div>
    <!-- /.login-card-body -->
  </div>
</div>

