<?php
include ('db.php');
session_start();
$userId = $_SESSION['id'];
$userName = $_SESSION['email'];
if ($userName == NULL || $userName == "") {
    header("location: index.php");
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
        <div class=" card">
            <div class="card-header p-0">
                <div class="d-flex align-items-center justify-content-between mx-5 my-3">
                    <div>
                        <h2>Profile</h2>
                        <p>Some info may be visible to other people</p>
                    </div>
                    <div>
                        <a class="btn btn-outline-primary fs-5 px-5 py-1" href="edit.php">Edit</a>
                        <a class="btn btn-outline-danger fs-5 px-5 py-1" href="cerrar.php">Log Out</a>
                    </div>
                </div>
            </div>
            <div class="card-header p-0">
                <div class="d-flex flex-column"><?php 
                    $q = "SELECT * FROM usuarios WHERE id = '$userId'";
                    $data = mysqli_query($conexion, $q);

                    while ($consulta = mysqli_fetch_array($data)) {
                        ?>
                    <div class="border-bottom">
                        <div class="d-flex align-items-center mx-5 my-3">
                            <span class="w-50 text-muted text-uppercase">Imagen</span>
                            <h4><img width="100" src="data:<?php echo $consulta['typeimg'];?>;base64,<?php echo base64_encode($consulta['foto']);?>"></h4>
                        </div>
                    </div>
                    <div class="border-bottom">
                        <div class="d-flex align-items-center mx-5 my-3">
                            <span class="w-50 text-muted text-uppercase">Usuario</span>
                            <h4><?php echo $consulta['usuario'];?></h4>
                        </div>
                    </div>
                    <div class="border-bottom">
                        <div class="d-flex align-items-center mx-5 my-3">
                            <span class="w-50 text-muted text-uppercase">Correo</span>
                            <h4><?php echo $consulta['email'];?></h4>
                        </div>
                    </div>
                    <div class="border-bottom">
                        <div class="d-flex align-items-center mx-5 my-3">
                            <span class="w-50 text-muted text-uppercase">Bio</span>
                            <h4><?php echo $consulta['biografia'];?></h4>
                        </div>
                    </div>
                    <div class="border-bottom">
                        <div class="d-flex align-items-center mx-5 my-3">
                            <span class="w-50 text-muted text-uppercase">Cel</span>
                            <h4><?php echo $consulta['telefono'];?></h4>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex align-items-center mx-5 my-3">
                            <span class="w-50 text-muted text-uppercase">Password</span>
                            <h4><input readonly onmousedown="return false;" class="border-0" type="password" value="<?php echo $consulta['contrasenia'];?>"></h4>
                        </div>
                    </div>
                <?php
                    }
                ?>
                </div>
            </div>
        </div>
    </header>
</body>

</html>