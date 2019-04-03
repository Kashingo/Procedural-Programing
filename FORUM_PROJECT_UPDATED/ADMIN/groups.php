<?php
session_start();
include '../functions.php';
my_adminheader('Групи форуми');
$con= db_init();
if(isset($_POST['ng'])==1)
      {
       $name=addslashes(trim($_POST['group_name']));
       $desc=addslashes(trim($_POST['desc']));
       if(strlen($name)>2) 
            {
            $id=(int)$_POST['edit_id'];
       
            $sql='SELECT * FROM group_cat WHERE name="'.$name.'"AND group_cat_id!='.$id;
            $res=run_q($sql);
            if(!mysqli_num_rows($res)>0)
                 {
                  if ($id>0)
                       {
                        $sql='UPDATE group_cat SET name="'.$name.'",`desc`="'.$desc.'"WHERE group_cat_id='.$id;
                        run_q($sql);
                        echo '<h1>Успешно обновяване</h1>';        
                       }
                  else 
                       {
                        $sql='INSERT INTO group_cat (name,date_added,`desc`) VALUES ("'.$name.'",'.time().',"'.$desc.'")';
                        run_q($sql);
                        echo '<h1>Успешен запис</h1>';
                       }
                 }
            else 
                 {
                  echo '<h1>Името съществува</h1>';
                 }
            }
       else  
            {
             echo '<h1>Името е твърде късо</h1>';
            }
      }
$sql='SELECT * FROM group_cat';
$res=run_q($sql);

echo '<table border="1"><tr><td>Име</td><td>Описание</td><td>Редактирай</td></tr>';

while($row=mysqli_fetch_assoc($res))
      {
       echo '<tr><td>'.$row['name'].'</td><td>'.$row['desc'].'</td><td><a href="groups.php?mode=edit&id='.$row['group_cat_id'].'">Редактирай</a></td></tr>';
      }
echo '</table>'; 
$ed_info['name']='';
$ed_info['desc']='';
if (isset($_GET['mode'])=="edit" && $_GET['id']>0)
       {
        $id=(int)$_GET['id'];
        $sql='SELECT * FROM group_cat WHERE group_cat_id='.$id;
        $res=run_q($sql);
        $ed_info=mysqli_fetch_assoc($res);
       }             
       
echo '<form action="groups.php" method="POST">
Име на група:<input type="text" name="group_name" value="'.$ed_info['name'].'" ><br/>
Описание:<textarea name="desc" rows="5" cols="50">'.$ed_info['desc'].'</textarea><br/>
<input type="hidden" name="ng" value="1"><br/>
<input type="submit" value="Запиши">
<input type="hidden" name="edit_id" value=0>'; 
if (isset($_GET['mode'])=="edit")
       {
       echo '<input type="hidden" name="edit_id" value="'.$_GET['id'].'">';
       }            

echo '</form>';    

footer();
