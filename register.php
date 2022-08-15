<?php
include ('db.php');

if (isset($_POST['create'])) {
    $userName = (isset($_POST['usuario']))?$_POST['usuario']:"";
    $password = (isset($_POST['password']))?$_POST['password']:"";
    $email = (isset($_POST['email']))?$_POST['email']:"";
    $telefono = (isset($_POST['telefono']))?$_POST['telefono']:"";
    if(isset($_FILES['foto']['name'])) {
        $type = $_FILES['foto']['type'];
        $name = $_FILES['foto']['name'];
        $size = $_FILES['foto']['size'];
        $img = fopen($_FILES['foto']['tmp_name'],'r');
        $binImg = fread($img, $size);
        $binImg = mysqli_escape_string($conexion,$binImg);
    };
    
    $validar = "SELECT * FROM usuarios WHERE email = '$email' ";
    $validando = mysqli_query($conexion, $validar);
    
    if(mysqli_num_rows($validando) > 0) {
        $mensaje = "El Email ya se encuantra registrado";
    } else {
        $query = "INSERT INTO usuarios (usuario, contrasenia, foto, telefono, email, biografia, typeimg) VALUES ('$userName', '$password', '$binImg', '$telefono', '$email', 'Ingrese su biografia', '$type')";
    
        $result = mysqli_query($conexion, $query);
    
        if($result > 0) {
            header("Location: index.php");
        } else {
            header("Location: register.php");
        }
    }; 
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
            <form method="post" enctype="multipart/form-data">
               <div class="card">
                   <div class="card-body p-5">
                    <div>
                        <h2>Join thousands of learners from around the world</h2>
                        <p>Master web development by making real-life projects. Tjere are multiple paths for you to choose</p>
                    </div>
                    <br>
                    <div class="mb-3">
                      <input type="text"
                        class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Name" required>
                    </div>
                    <div class="mb-3">
                      <input type="email"
                        class="form-control" name="email" id="email" aria-describedby="helpId" placeholder="Email" required>
                        <?php 
                            if (isset($mensaje)) {
                                echo "<h6 class='text-danger'>$mensaje</h6>";
                            }
                        ?>
                    </div>
                    <div class="mb-3">
                        <input type="password"
                        class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                      <input type="number"
                        class="form-control" name="telefono" id="telefono" aria-describedby="helpId" placeholder="Telefono" required>
                    </div>
                    <div class="mb-3">
                      <input type="file"
                        class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Photo" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="create">Start coding now</button>
                    <div>
                        <p>Already a member?</p><a class="btn btn-outline-dark" href="index.php">Login</a>
                    </div>
                </div>
                </form>
               </div>
            </div>
        </div>
    </div>
</body>
</html>