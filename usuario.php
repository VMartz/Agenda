<?php 
if($_SERVER["REQUEST_METHOD"]=="GET"){ $db="agendad";
    $opcion=$_GET["opcion"];
    $server="localhost";
    $userdb="root";
    $pass="";
     switch($opcion){  
        case 'login':
            $usuario= $_GET["usuario"];
            $password= $_GET["password"];
            $conn= mysqli_connect ($SERVER,$userdb,$pass,$db);
            $sql = "SELECT id_usuario,nombre FROM usuario WHERE usuario='$usuario'
            AND password = MD5('$password')";
            if ($conn-> connect_error){
                $response["error"]=1;
                $response["mensaje"]=$conn->error;
            }
            else{
                $data = $conn-> query($sql);
                if($data->num_rows>0){
                    $response["error"]=0;
                    session_start();
                    $row =$data->fetch_assoc();
                    $_SESSION["nombre"]=$row["nombre"];
                    $_SESSION["id_usuario"]=$row["id_usuario"];
                    $response["nombre"]=$row["nombre"];
                }else{
                    $response["error"]=1;
                    $response["mensaje"]="usuario y/o password incorrecto(s)";
                }
                $conn->close();
            }//else
            echo json_encode($response);
            break;
            default:
            $response["error"]=1;
            $response ["mensaje"]="opcion invalida";
            echo json_encode($response);
            break;

        case 'nuevo':
            $nombre=$_GET["nombre"];
            $usuario=$_GET["usuario"];
            $password=$_GET["password"];
            $direccion=$_GET["direccion"];
            $email=$_GET["email"];
            $telefono=$_GET["telefono"];
            $conn= mysqli_connect($server, $userdb,$pass,$db);

            if($conn->connect_error){
                $response ["error"]=1;
                $response["mensaje"]=$conn->connect_error;
            }
            else{
                $sql = ("INSERT INTO usuario (nombre, usuario, password,direccion,email,telefono)
                 VALUES ('$nombre', '$usuario' , MD5('$password'), '$direccion', '$email', '$telefono')");

                 if($conn->query($sql)==TRUE){
                     $response["error"]=0;
                     $response["mensaje"]="Usuario guardado correctamente";
                 }
                 else {
                     $response["error"]=1;
                     $response["mensaje"]=$conn->error;                   
                 }
                 $conn-> close();
                 echo json_encode($response);
                 break;
                }
                 case 'eliminarusuario':

                    $id_usuario=$_GET["id_usuario"];
                    $conn= mysqli_connect($server, $userdb,$pass,$db);
                    
                    if ($conn-> connect_error){
                        $response["error"]=1;
                        $response["mensaje"]=$conn->error;
                        }
                        else{
                        $sql = "DELETE FROM usuario WHERE id_usuario=$id_usuario";
                        if($conn->query($sql)==TRUE){
                            $response["error"]=0;
                            $response["mensaje"]="Usuario eliminado correctamente";
                        }
                        else {
                            $response["error"]=1;
                            $response["mensaje"]=$conn->connect_error;
                        }
                    $conn->close();
                    }//else
                    echo json_encode($response);
                    break;
            }
                }
?>

http://127.0.0.1/agendad/usuario.php?opcion=eliminarusuario&id_usuario=
http://127.0.0.1/agendad/usuario.php?opcion=nuevo&nombre=mumu&usuario=mumu&password=13456&direccion=ixtapaluca&email=mumu@gmail.com&telefono=823482