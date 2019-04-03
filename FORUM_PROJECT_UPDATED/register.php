<?php
session_start();
include 'functions.php';
if (isset($_SESSION['is_logged'])!==true)
    {
    my_header('Регистрация');
    if (isset($_POST['form_submit'])==1)
        {
        $login=trim($_POST['login']);
        $pas=trim($_POST['pass']);
        $pas2=trim($_POST['pass2']);
        $email=trim($_POST['mail']);
        $name=trim($_POST['name']);
        $error_array = [];
        
        if (strlen($login)<4)
            {
            $error_array['login']='Невалидено име';
            }
        if (strlen($pas)<4)   
            {
            $error_array['pass']='кратка парола';
            } 
        if ($pas!=$pas2)  
            {
            $error_array['pass2']='паролите не отговарят';
            } 
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
            $error_array['mail']='Невалиден адрес';
            } 
        if (preg_match("/^[a-zA-Z'-]*$/",$name))
            {
            $error_array['name']='невалидено име';
            }  
         if(!count($error_array)>0)
         {
             $con=db_init();

             $sql='SELECT COUNT(*)as cnt FROM users WHERE login ="'.addslashes($login).'" OR email="'.addslashes($email).'"';
             $res=run_q($sql);
             $row=mysqli_fetch_assoc($res);
             if ($row['cnt']==0)
                 {
                  $sql='INSERT INTO users(login,pass,real_name,email,date_registered)VALUES("'.addslashes($login).'","'
                  .md5($pas).'","'.addslashes($name).'","'.addslashes($email).'",'.time().')';
                  run_q($sql);
                  if (mysqli_error())
                     {
                      echo '<h1>Грешка моля опитайте отново!<h1/>';
                     }
                  else 
                     {
                      header('Location: index.php');
                      exit;
                     }   
                 }
             else
                 {
              
                   $error_array['login']='Името или адреса са заети';
                   $error_array['mail']='Името или адреса са заети';
                 }
         }     
        }
    
?>
    <form action="register.php" method="POST">
        Login:<input type="text" name="login" value=""/><?php if (isset($error_array['login'])){echo $error_array['login'];}?><br>
        Парола:<input type="text" name="pass" value=""/><?php if (isset($error_array['pass'])){echo $error_array['pass'];}?><br>
        Повтори Парола:<input type="text" name="pass2" value=""/><?php if (isset($error_array['pass2'])){echo $error_array['pass2'];}?><br>
        Email:<input type="text" name="mail" value=""/><?php if (isset($error_array['mail'])){echo $error_array['mail'];}?><br>
        Име:<input type="text" name="name" value=""/><?php if (isset($error_array['name'])){echo $error_array['name'];}?><br>
        <input type="hidden" name="form_submit" value="1">
        <input type="submit" name="Регистрирай се" value="Регистрирай се"/><br>
    </form>
<?php
footer();
    }
else
    {
    header ('location: index.php');
    exit;
    }    