<?php
session_start();
include 'functions.php';
$con= db_init();
$cat_id=(int)$_GET['id'];
$sql='SELECT name FROM cat WHERE cat_id='.$cat_id.' AND active=1';
$res=run_q($sql);
if($_SESSION['is_logged']===true && mysqli_num_rows($res)==1) 
    {
    if(isset($_POST['new_post'])==1)
         {
         $err_array=[];
         $new_name=addslashes(trim($_POST['post_title']));
         $new_content=addslashes(trim($_POST['post_content']));
         if(strlen($new_name)<4)
             {
              $err_array['name']='Името е твърде кратко';
             }
         if(strlen($new_content)<4)
             {
              $err_array['content']='Съдържанието е твърде кратко';
             } 
         if(strlen($new_content)>5000)
             {
              $err_array['content']='Съдържанието е твърде дълго';
             }  
         if(count($err_array)==0)
             {
              $sql='INSERT INTO posts (cat_id,added_by,date_added,title,content)'
                   . 'VALUES('.$cat_id.','.$_SESSION['user_info']['user_id'].','.time().',"'. htmlspecialchars($new_name).'","'.htmlspecialchars($new_content).'") ';
              $res=run_q($sql);
              header('Location: topic.php?id='.$cat_id);
             }
         }
     $row= mysqli_fetch_assoc($res);
     my_header('Нова Тема-'.$row['name']);
    
     echo '<form method="post" action="post.php?id='.$cat_id.'" >
     Заглавие:<input type="text" name="post_title">';if( isset($err_array['name'])){echo $err_array['name'] ;}
     echo '<br><textarea name="post_content" rows="10" cols="50"></textarea>';if( isset($err_array['content'])){echo $err_array['content'] ;}
     echo'<br><input type="submit" value="Добави">
     <input type="hidden" name="new_post" value="1">
     </form>';
     footer();
    }
else 
    {
     header('Location: index.php');
    
    }
 
   