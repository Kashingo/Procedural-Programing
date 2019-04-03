<?php
session_start();
include 'functions.php';
my_header("Начало");
$con= db_init();
$sql='SELECT name,group_cat_id FROM group_cat WHERE active=1';
$res=run_q($sql);
while($row= mysqli_fetch_assoc($res))
    {
     $groups[]=$row;
    }
foreach($groups as $v)
    {
    $sql='SELECT `name`,`cat_id`,`desc` FROM cat WHERE active=1 AND group_cat_id='.$v['group_cat_id'];
    $res=run_q($sql);
    echo '<div class="group_cat"><p>'.$v['name'].'</p>';
        while($row=mysqli_fetch_assoc($res))
         {
         echo '<div class="cat"><a href="topic.php?id='.$row['cat_id'].'">'.$row['name'].'</a><p>'.$row['desc'].'</p></div>';
         }
         
    echo'</div>';
    } 
 
footer();