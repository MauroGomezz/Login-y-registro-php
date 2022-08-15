<?php
include ('db.php');
if (isset($_POST['login'])) {
    $userName = (isset($_POST['email']))?$_POST['email']:"";
    $password = (isset($_POST['password']))?$_POST['password']:"";

    session_start();
    $_SESSION['email'] = $userName;

    $query = "SELECT * FROM usuarios WHERE email='$userName' and contrasenia='$password' ";
    $result = mysqli_query($conexion, $query);
    $consulta = mysqli_fetch_array($result);

    
    $filas = mysqli_num_rows($result);
    
    if($filas) {
        header("location: home.php");
        $_SESSION['id'] = $consulta['id'];
    } else {
        $mensaje = "Email y/o Contraseña incorrectas";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css
">
    <title>Authentication</title>
</head>
<body>
<div class="container">
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
            <br>
            <form method="post">
               <div class="card">
                   <div class="card-body p-5">
                    <div>
                        <h2>Login</h2>
                    </div>
                    <br>
                    <div class="mb-3">
                      <input type="text"
                        class="form-control" name="email" id="usuario" aria-describedby="helpId" placeholder="Email">
                    </div>
                    <div class="mb-3">
                      <input type="password"
                        class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
                    <?php 
                        if (isset($mensaje)) {
                            echo "<h6 class='text-danger'>$mensaje</h6>";
                        }
                    ?>
                    <div>
                        <p>Don´t have an account yet?</p><a class="btn btn-outline-dark" href="register.php">Register</a>
                    </div>
                </div>
                </form>
               </div>
            </div>
        </div>
    </div>
</body>
</html>