<?php
session_start();
include 'functions.php';
my_header('Вход');
if(isset($_POST['form_login'])==1)
    {
     $login=trim($_POST['login_name']);
     $pass=trim($_POST['login_pass']);
     if (strlen($login)>3 && strlen($pass)>3)
       {
        $con= db_init();
        $sql='SELECT * FROM users WHERE login="'.addslashes($login).'" AND pass= "'.md5($pass).'"';
        $res=run_q($sql);
        if(mysqli_num_rows($res)==1)
            {
            $row= mysqli_fetch_assoc($res);
            if($row['activ']==1)
                {
                 $_SESSION['is_logged']=true;
                 $_SESSION['user_info']=$row;
                 header('Location: index.php');
                  exit;
                }
            else 
                {
                 echo '<h1>Достъпът ви е спрян</h1>';
                }
            
            }
        else if(mysqli_num_rows($res)==0)
            {
             echo '<h1>Грешно име или парола</h1>';
            }
        
       }
    }
?>
<form action="login.php" method="POST">
       Име:<input type="text" name="login_name"><br/>
    Парола:<input type="text" name="login_pass"><br/>
           <input type="hidden" name="form_login" value="1">
           <input type="submit" value="Влез">    
</form>
<?php
footer();

