<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Database";
$error = FALSE;
$registerOK = FALSE;

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>

<?php
if(isset($_POST["submit"])){

  if($_POST["login"] == NULL OR $_POST["pass"] == NULL OR $_POST["pass2"] == NULL){

    $error = TRUE;
    
    $errorMSG = "Tout les champs doivent être remplis !";
    
  }
  
  elseif($_POST["pass"] == $_POST["pass2"]){

    if($_POST["login"] != $_POST["pass"]){

      $newUsername = mysqli_real_escape_string($conn, $_POST['login']); 
      $newPassword = mysqli_real_escape_string($conn, $_POST['pass']); 
      $newPassword2 = mysqli_real_escape_string($conn, $_POST['pass2']); 

      $result = $conn->query("SELECT * FROM users WHERE login ='$newUsername' AND pass='$newPassword'");

      
      if(mysqli_num_rows($result)){
         $error = TRUE;
  
  $errorMSG = "Le nom de compte <strong>".$_POST["login"]."</strong> est déjà utilisé !";
  
  $login = NULL;}
  
  
  else{
    $pass = $_POST["pass"];

        if(strlen($_POST["pass"] < 60)){

         if(strlen($_POST["login"] < 60)){

          if($_POST["login"] != $_POST["pass"]){

           $sql = mysqli_query($conn, "INSERT INTO users (login,pass) VALUES ('".$_POST["login"]."','".$_POST["pass"]."')");
           
           if($sql){

            $registerOK = TRUE;
            $registerMSG = "Inscription réussie ! Vous êtes maintenant membre du site.";
            
            $_SESSION["login"] = $_POST["login"];
            $_SESSION["pass"] = $_POST["pass"];
            
          }

          else{

            $error = TRUE;
            
            $errorMSG = "Erreur dans la requête SQL<br/>".$sql."<br/>";
            
          }
          
        }

        else{

         $error = TRUE;
         
         $errorMSG = "Votre nom compte ne doit pas dépasser <strong>60 caractères</strong> !";
         
         $login = NULL;
         
         $pass = $_POST["pass"];
         
       }
       
     }
     
   }

   else{

     $error = TRUE;
     
     $errorMSG = "Votre mot de passe ne doit pas dépasser <strong>60 caractères</strong> !";
     
     $login = $_POST["login"];
     
     $pass = NULL;
     
   }
   
 }

}

else{

  $error = TRUE;
  
  $errorMSG = "Le nom de compte et le mot de passe doivent êtres différents !";
  
}

}

elseif($_POST["pass"] != $_POST["pass2"]){

 $error = TRUE;
 
 $errorMSG = "Les deux mots de passes sont différents !";
 
 $login = $_POST["login"];
 
 $pass = NULL;
 
}

elseif($_POST["login"] == $_POST["pass"]){

 $error = TRUE;
 
 $errorMSG = "Le nom de compte et le mot de passe doivent être différents !";
 
}
}
?>

<?php

$BDD=null;

?>

<?php
if($error == TRUE){ echo "<p align='center' style='color:red;'>".$errorMSG."</p>"; }
  ?>
  <?php
  if($registerOK == TRUE){ echo "<p align='center' style='color:green;'><strong>".$registerMSG."</strong></p>"; }?>
