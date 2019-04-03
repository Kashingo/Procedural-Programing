<?php
function my_header($title)
{ 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta  charset=UTF-8">
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <title><?php echo $title;?></title>
    </head>
    <body>
    <div id="top_menu">    
<?php
    if (isset($_SESSION['is_logged'])===true)
    {
        echo 'Здравей: <b>'.$_SESSION['user_info']['login'].'</b>';
        if($_SESSION['user_info']['type']==3)
        {echo '| <a href="admin/index.php">Администраторски панел</a> |';
             
        }
        echo '<a href="logout.php">Изход</a>';
    }
    else 
    {
        echo '<a href="register.php">Регистрирай се</a> | <a href="login.php">Влез</a>'; 
    }
?>
    </div>
    <div id="content">    
<?php        
}

function my_adminheader($title)
{   
    if ( $_SESSION['is_logged']!==true || $_SESSION['user_info']['type']!=3)
    {
      header ('Location: ../index.php');
      exit;
    }
   
?>
    <!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $title;?></title>
    </head>
    <body>
    <div id="top_menu">
        <a href="../index.php">Начало</a> | <a href="groups.php">Групи Форуми</a> | <a href="sub_groups.php">Под Групи</a> | <a href="../logout.php">Изход</a>  
    </div>
<?php        
}

function footer()
{
    echo '</body></html>';
}
function db_init()
{
    $con=mysqli_connect('localhost', 'root', 'Radilovo471', 'forum-project');
      if (!$con) 
        {
        echo "NO CONNECTION" .mysqli_connect_error();
        exit;
        }   
    return $con;
}
function run_q($sql)
{
    $con=db_init();
    mysqli_set_charset($con,"utf8");
    return mysqli_query($con,$sql);
}
?>