<html>





<form class="form-signin" action="admin/admin_login_handler.php" method="POST">
      
      <h2 class="h3 mb-3 font-weight-normal">Please log in</h2>
      <!-- <h6 class="h6 mb-6 font-weight-normal text-danger"><?php echo "error"; ?></h6> -->
      
      <label for="inputEmail" class="sr-only">Username</label>
      <input name="username" type="text" id="inputEmail" class="form-control" placeholder="Username" required autofocus>
      
      <label for="inputPassword" class="sr-only">Password</label>
      <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
      
      <div class="checkbox mb-3"></div>
      
      <input value="Enter" name="login-submit" class="btn btn-lg btn-primary btn-block" type="submit">     

      <p class="mt-5 mb-3 text-muted">Olam &copy; Copyright <?php echo date("Y"); ?></p>

      
    </form>
    
    
    
    
    
</html>


