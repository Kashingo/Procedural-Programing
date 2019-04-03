<?php
session_start();
include '../functions.php';
my_adminheader('Под групи');
$con= db_init();
if(isset($_POST['ng'])==1)
      {
       $name=addslashes(trim($_POST['group_name']));
       $desc=addslashes(trim($_POST['desc']));
       $catid=(int)$_POST['group'];
       if(strlen($name)>2 && $catid>0) 
            {
            $id=(int)$_POST['edit_id'];
       
            $sql='SELECT * FROM cat WHERE name="'.$name.'"AND cat_id!='.$id;
            $res=run_q($sql);
            if(!mysqli_num_rows($res)>0)
                 {
                  if ($id>0)
                       {
                        $sql='UPDATE cat SET name="'.$name.'",`desc`="'.$desc.'",group_cat_id='.$catid.' WHERE cat_id='.$id;
                        run_q($sql);
                        echo '<h1>Успешно обновяване</h1>';        
                       }
                  else 
                       {
                        $sql='INSERT INTO cat (name,date_added,`desc`,group_cat_id) VALUES ("'.$name.'",'.time().',"'.$desc.'","'.$catid.'")';
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
$sql='SELECT gc.name as gcname,c.name,c.desc,c.cat_id FROM group_cat as gc,cat as c WHERE gc.group_cat_id=c.group_cat_id';
$res=run_q($sql);

echo '<table border="1"><tr><td>Група</td><td>Подгрупа</td><td>Описание</td><td>Редактирай</td></tr>';

while($row=mysqli_fetch_assoc($res))
      {
       echo '<tr><td>'.$row['gcname'].'</td><td>'.$row['name'].'</td><td>'.$row['desc'].'</td><td><a href="sub_groups.php?mode=edit&id='.$row['cat_id'].'">Редактирай</a></td></tr>';
      }
echo '</table>'; 
$ed_info['name']='';
$ed_info['desc']='';
$ed_info['group_cat_id']='';
if (isset($_GET['mode'])=="edit" && $_GET['id']>0)
       {
        $id=(int)$_GET['id'];
        $sql='SELECT * FROM cat WHERE cat_id='.$id;
        $res=run_q($sql);
        $ed_info=mysqli_fetch_assoc($res);
       }  
$sql='SELECT * FROM group_cat';       
$res= run_q($sql);      
echo '<form action="sub_groups.php" method="POST">
Група:<select name="group">';
while ($row= mysqli_fetch_assoc($res))
       {
        if($row['group_cat_id']==$ed_info['group_cat_id'])
            {
            echo '<option value="'.$row['group_cat_id'].'"selected="selected">'.$row['name'].'</options>';
            }
        else
            {
            echo '<option value="'.$row['group_cat_id'].'">'.$row['name'].'</options>';
            }
       }
echo '</select><br>
Име на подгрупа:<input type="text" name="group_name" value="'.$ed_info['name'].'" ><br/>
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
