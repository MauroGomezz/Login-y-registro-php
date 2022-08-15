<?php
include ('db.php');
session_start();
$userId = $_SESSION['id'];
$userName = $_SESSION['email'];
if ($userName == NULL || $userName == "") {
    header("location: index.php");
}


include ('db.php');
if (isset($_POST['save'])) {
    $userId = (isset($_POST['id']))?$_POST['id']:"";
    $userName = (isset($_POST['usuario']))?$_POST['usuario']:"";
    $password = (isset($_POST['contrasenia']))?$_POST['contrasenia']:"";
    $bio = (isset($_POST['bio']))?$_POST['bio']:"";
    $email = (isset($_POST['email']))?$_POST['email']:"";
    $telefono = (isset($_POST['telefono']))?$_POST['telefono']:"";
    
    $q = "SELECT foto FROM usuarios WHERE id = '$userId'";
    $data = mysqli_query($conexion, $q);
    $consulta = mysqli_fetch_array($data);
    
    if ($_FILES['foto']['name'] == "") {
        $binImg = $binImg = mysqli_escape_string($conexion,$consulta['foto']);
    } else {
        if(isset($_FILES['foto']['name'])) {
            $type = $_FILES['foto']['type'];
            $name = $_FILES['foto']['name'];
            $size = $_FILES['foto']['size'];
            $img = fopen($_FILES['foto']['tmp_name'],'r');
            $binImg = fread($img, $size);
            $binImg = mysqli_escape_string($conexion,$binImg);
        };
    }
    
    $validar = "SELECT * FROM usuarios WHERE email = '$email' and id != '$userId' ";
    $validando = mysqli_query($conexion, $validar);
    
    if(mysqli_num_rows($validando) > 0) {
        $mensaje = "El Email ya se encuantra en uso";
    } else {
        $query = "UPDATE usuarios SET usuario = '$userName', contrasenia = '$password', biografia = '$bio', foto = '$binImg', telefono = '$telefono', email = '$email' WHERE id = $userId";
        
        $result = mysqli_query($conexion, $query);
        
        if($result != 0) {
            header("Location: home.php");
        } else {
            header("Location: edit.php");
        }
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
    <title>Personal Info</title>
</head>

<body>
    <header class="container">
        <div></div>
        <a href="home.php">Back</a>
        <div class=" card">
            <div class="card-header">
                <div>
                    <h2>Change Info</h2>
                    <p>Changes will be reflected to every services</p>
                </div>
                <form class="d-flex flex-column" method="post" enctype="multipart/form-data"><?php 
                    $q = "SELECT * FROM usuarios WHERE id = '$userId'";
                    $data = mysqli_query($conexion, $q);

                    while ($consulta = mysqli_fetch_array($data)) {
                ?>
                        <input hidden value="<?php echo $consulta['id'];?>" name="id"></input>
                    <div class="d-flex flex-column mb-3">
                        <label>Imagen</label>
                        <input name="foto" type="file"><img width="100" src="data:<?php echo $consulta['typeimg'];?>;base64,<?php echo base64_encode($consulta['foto']);?>"></input>
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <label>Usuario</label>
                        <input class="w-25 p-2 fs-5" name="usuario" value="<?php echo $consulta['usuario'];?>"></input>
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <label>Correo</label>
                        <input class="w-25 p-2 fs-5" name="email" value="<?php echo $consulta['email'];?>"></input>
                        <?php 
                            if (isset($mensaje)) {
                                echo "<h6 class='text-danger'>$mensaje</h6>";
                            }
                        ?>
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <label>Bio</label>
                        <textarea class="w-25 p-2 fs-5" name="bio"><?php echo $consulta['biografia'];?></textarea>
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <label for="telefono">Cel</label>
                        <input class="w-25 p-2 fs-5" id="telefono" name="telefono" value="<?php echo $consulta['telefono'];?>"></input>
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <label>Password</label>
                        <input class="w-25 p-2 fs-5" name="contrasenia" type="text" value="<?php echo $consulta['contrasenia'];?>"></input>
                    </div>
                <?php
                    }
                ?>
                <button class="btn btn-primary w-25" name="save">Save</button>
                </form>
            </div>
        </div>
    </header>
</body>

</html>