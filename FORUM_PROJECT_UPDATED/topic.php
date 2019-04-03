<?php
session_start();
include 'functions.php';
$con= db_init();
$cat_id=(int)$_GET['id'];

if($cat_id>0)
    {
     $sql='SELECT name,active FROM cat WHERE cat_id='.$cat_id.' AND active=1';
     $res= run_q($sql);
     if(mysqli_num_rows($res)==1)
         {
          $row= mysqli_fetch_assoc($res);
          my_header($row['name']);
          if(isset($_SESSION['is_logged'])===true)
              {
              echo'<div id="topic_menu"><a href="post.php?id='.$cat_id.'">Нова Тема</a></div>';
              }
          $sql='SELECT COUNT(*)as cnt FROM posts WHERE cat_id='.$cat_id;
          $res= run_q($sql);
          $row= mysqli_fetch_assoc($res);
          $max_count=$row['cnt'];
          $limit=3;
          if((int)$_GET['page']>0)
              {
               $page=(int)$_GET['page']-1;
              }
          else
              {
               $page=0;
              }
          $max_pages=ceil($max_count/$limit);    
        
          echo '<div id="posts">';    
          $sql='SELECT * FROM posts as p,users as u WHERE p.cat_id='.$cat_id.' AND p.added_by=u.user_id ORDER BY p.date_added DESC LIMIT '.($limit*$page).','.$limit;
          $res= run_q($sql);
          while($row= mysqli_fetch_assoc($res))
              {
                echo'<div class="post"><div class="author">';
                echo $row['login'];
                echo '<p>'.date( 'd-m-Y H:i:s D',$row['date_added']).'</p></div>';
                echo'<div class="cpost"><p class="title">'.$row['title'].'</p>'.$row['content'];
                echo '</div></div><hr>';
              }
          echo '</div>';  
          echo '<div id="pagination">';
          for($i=0;$i<$max_pages;$i++)
              {
               if($i==$page)
                   {
                    echo ($i+1).'|';
                   }
               else
                   {
                    echo '<a href="topic.php?id='.$cat_id.'&page='.($i+1).'">'.($i+1).'</a> |';
                   }
              }
          if($page<($max_pages-1))
              {
               echo '<a href="topic.php?id='.$cat_id.'&page='.($page+2).'">NEXT</a>';
              }
         echo '</div>';
         }
     else
         {
         header('Location: index.php');
         }
    }
else 
    {
     header('Location: index.php');
    }    
footer();