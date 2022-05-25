<?php
include("bd.php");
$groupToShow=$_POST['groupToShow'];
$teacherToShow=$_POST['teacherToShow'];
$auditoriumToShow=$_POST['auditoriumToShow'];
$week_dayAdd=$_POST['week_dayAdd'];
$lesson_numberAdd=$_POST['lesson_numberAdd'];
$auditoriumAdd=$_POST['auditoriumAdd'];
$discipleAdd=$_POST['discipleAdd'];
$teacherAdd=$_POST['teacherAdd'];
$groupAdd=$_POST['groupAdd'];






$res = $mysqli->query("SELECT * FROM `groups`");
$res->data_seek(0);
while ($myrow = $res->fetch_assoc())
{
	$group=$group."<option value='".$myrow['ID_Groups']."'>".$myrow['title']."</option>";
	
}
		
$res = $mysqli->query("SELECT * FROM `teacher`");
$res->data_seek(0);
while ($myrow = $res->fetch_assoc())
{
	$teacher=$teacher."<option value='".$myrow['ID_Teacher']."'>".$myrow['name']."</option>";
}

$res = $mysqli->query("SELECT DISTINCT auditorium FROM `lesson`");
$res->data_seek(0);
while ($myrow = $res->fetch_assoc())
{
	$auditorium=$auditorium."<option>".$myrow['auditorium']."</option>";
}

if (!empty($_POST['week_dayAdd'])){
	//echo "SELECT * FROM `lesson` WHERE week_day='".$week_dayAdd."',lesson_number='".$lesson_numberAdd."',auditorium='".$auditoriumAdd."',disciple='".$discipleAdd."',type='Practical'<br>";
	$res = $mysqli->query("INSERT INTO lesson (week_day,lesson_number,auditorium,disciple,type) VALUES ('".$week_dayAdd."','".$lesson_numberAdd."','".$auditoriumAdd."','".$discipleAdd."','Practical')");
	$res = $mysqli->query("SELECT * FROM `lesson` WHERE week_day='".$week_dayAdd."' AND lesson_number='".$lesson_numberAdd."' AND auditorium='".$auditoriumAdd."' AND disciple='".$discipleAdd."' AND type='Practical'");
	$res->data_seek(0);
	$myrow = $res->fetch_assoc();
	//echo "INSERT INTO lesson_groups (FID_Lesson2,FID_Groups) VALUES (".$myrow['ID_Lesson'].",".$groupAdd.")<br>";
	//echo "INSERT INTO lesson_teacher (FID_Lesson1,FID_Teacher) VALUES (".$myrow['ID_Lesson'].",".$teacherAdd.")";
	$res = $mysqli->query("INSERT INTO lesson_groups (FID_Lesson2,FID_Groups) VALUES (".$myrow['ID_Lesson'].",".$groupAdd.")");
	$res = $mysqli->query("INSERT INTO lesson_teacher (FID_Lesson1,FID_Teacher) VALUES (".$myrow['ID_Lesson'].",".$teacherAdd.")");
}

/*if (!empty($_POST['groupToShow'])){
	$res = $mysqli->query("SELECT * FROM `lesson_groups` 
LEFT JOIN lesson ON lesson.ID_Lesson=lesson_groups.FID_Lesson2 
LEFT JOIN `groups` AS a ON a.ID_Groups=lesson_groups.FID_Groups
LEFT JOIN lesson_teacher ON lesson_teacher.FID_Lesson1=lesson.ID_Lesson
LEFT JOIN teacher ON teacher.ID_Teacher=lesson_teacher.FID_Teacher WHERE ID_Groups='".$groupToShow."'");
	$res->data_seek(0);
	$allCost=0;
	while ($myrow = $res->fetch_assoc())
	{
		$table=$table."<tr><td>".$myrow['week_day']."</td><td>".$myrow['lesson_number']."</td><td>".$myrow['auditorium']."</td><td>".$myrow['disciple']."</td><td>".$myrow['name']."</td><td>".$myrow['type']."</td></tr>";
	}
}*/

if ($stmt = $mysqli->prepare("SELECT week_day,lesson_number,auditorium,disciple,name,type FROM `lesson_groups` 
LEFT JOIN lesson ON lesson.ID_Lesson=lesson_groups.FID_Lesson2 
LEFT JOIN `groups` AS a ON a.ID_Groups=lesson_groups.FID_Groups
LEFT JOIN lesson_teacher ON lesson_teacher.FID_Lesson1=lesson.ID_Lesson
LEFT JOIN teacher ON teacher.ID_Teacher=lesson_teacher.FID_Teacher WHERE ID_Groups=?")) {
$stmt->bind_param("s", $groupToShow); 
$stmt->execute(); 
//var_dump($stmt);
$stmt->bind_result($week_dayTemp,$lesson_numberTemp,$auditoriumTemp,$discipleTemp,$nameTemp,$typeTemp); /* прикрепляем результаты*/
	while ($stmt->fetch()) {
	//printf($district1);
		$table=$table."<tr><td>".$week_dayTemp."</td><td>".$lesson_numberTemp."</td><td>".$auditoriumTemp."</td><td>".$discipleTemp."</td><td>".$nameTemp."</td><td>".$typeTemp."</td></tr>";
	}
$stmt->fetch(); //printf("%s находится в %s\n", $city, $district);
$stmt->close();
}

if (!empty($_POST['teacherToShow'])){
	$res = $mysqli->query("SELECT * FROM `lesson_groups` 
LEFT JOIN lesson ON lesson.ID_Lesson=lesson_groups.FID_Lesson2 
LEFT JOIN `groups` AS a ON a.ID_Groups=lesson_groups.FID_Groups
LEFT JOIN lesson_teacher ON lesson_teacher.FID_Lesson1=lesson.ID_Lesson
LEFT JOIN teacher ON teacher.ID_Teacher=lesson_teacher.FID_Teacher WHERE ID_Teacher='".$teacherToShow."'");
	$res->data_seek(0);
	$allCost=0;
	while ($myrow = $res->fetch_assoc())
	{
		$table=$table."<tr><td>".$myrow['week_day']."</td><td>".$myrow['lesson_number']."</td><td>".$myrow['auditorium']."</td><td>".$myrow['disciple']."</td><td>".$myrow['name']."</td><td>".$myrow['type']."</td></tr>";
	}
}

if (!empty($_POST['auditoriumToShow'])){
	$res = $mysqli->query("SELECT * FROM `lesson_groups` 
LEFT JOIN lesson ON lesson.ID_Lesson=lesson_groups.FID_Lesson2 
LEFT JOIN `groups` AS a ON a.ID_Groups=lesson_groups.FID_Groups
LEFT JOIN lesson_teacher ON lesson_teacher.FID_Lesson1=lesson.ID_Lesson
LEFT JOIN teacher ON teacher.ID_Teacher=lesson_teacher.FID_Teacher WHERE auditorium='".$auditoriumToShow."'");
	$res->data_seek(0);
	$allCost=0;
	while ($myrow = $res->fetch_assoc())
	{
		$table=$table."<tr><td>".$myrow['week_day']."</td><td>".$myrow['lesson_number']."</td><td>".$myrow['auditorium']."</td><td>".$myrow['disciple']."</td><td>".$myrow['name']."</td><td>".$myrow['type']."</td></tr>";
	}
}

?>
<!DOCTYPE HTML>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>ЛБ 1</title>
  <link href="external.css" rel="stylesheet">
 </head>
 <body>

<div class="navigation">
<form action="index.php" method="post">
<a style="margin-left: 50px;">Выберите группу:</a><br>
<span class="custom-dropdown big">
    <select name="groupToShow">    
        <option selected="selected"  disabled>Group</option>
		<?php echo $group; ?>
    </select>
</span>
<input class="btn third" type="submit" value="Загрузить" />
</form>

<form action="index.php" method="post">
<a style="margin-left: 50px;">Выберите teacher:</a><br>
<span class="custom-dropdown big">
    <select name="teacherToShow">    
        <option selected="selected"  disabled>Teacher</option>
		<?php echo $teacher; ?>
    </select>
</span>
<input class="btn third" type="submit" value="Загрузить" />
</form>

<form action="index.php" method="post">
<a style="margin-left: 50px;">Выберите auditorium:</a><br>
<span class="custom-dropdown big">
    <select name="auditoriumToShow">    
        <option selected="selected"  disabled>Auditorium</option>
		<?php echo $auditorium; ?>
    </select>
</span>
<input class="btn third" type="submit" value="Загрузить" />
</form>

<form action="index.php" method="post">
<a style="margin-left: 50px;">Добавить пз:</a><br>
<input name="week_dayAdd"  type="text" placeholder="День недели" />
<input name="lesson_numberAdd"  type="text" placeholder="Номер пары" />
<input name="auditoriumAdd"  type="text" placeholder="Номер аудитории" />
<input name="discipleAdd"  type="text" placeholder="Дисциплина" />
<span class="custom-dropdown big">
    <select name="teacherAdd">    
        <option selected="selected"  disabled>Teacher</option>
		<?php echo $teacher; ?>
    </select>
</span>
<span class="custom-dropdown big">
    <select name="groupAdd">    
        <option selected="selected"  disabled>Group</option>
		<?php echo $group; ?>
    </select>
</span>
<input class="btn third" type="submit" value="Add" />
</form>

<table id="myTable" class="table_dark">
	<tr>
		<th>Week day</th>
		<th>Lesson number</th>
		<th>Auditorium</th>
		<th>Disciple</th>
		<th>Name</th>
		<th>Type</th>
	</tr>
   <?php echo $table; ?>
</table><br>

</div>

 </body>
</html>
