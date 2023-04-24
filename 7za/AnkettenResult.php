<?php
$name = htmlentities($_POST['FirstName']);
echo "<h1>Ваши анкетные данные, $name</h1></br>";
if (isset($_POST['FirstName']) && isset($_POST['SurName']) && isset($_POST['formeduc']) && isset($_POST['courses']) && isset($_POST['coment']))
{
	$name = htmlentities($_POST['FirstName']);
	$surname = htmlentities($_POST['SurName']);
	$formeduc = $_POST['formeduc'];
	$hostel = "нет";
	if (isset($_POST['hostel'])) $hostel = "да";
	$course = $_POST['courses'];
	$com = $_POST['coment'];
	echo "<h3>Ваше имя: $name</h3></br><hr>";
	echo "<h3>Ваша фамилия: $surname</h3></br><hr>";
	echo "<h3>Форма обучения: $formeduc</h3></br><hr>";
	echo "<h3>Необходимость в общежитии: $hostel</h3></br><hr>";
	echo "<h3>Выбранные Вами курсы: </h3>";
	foreach ($course as $item) echo "<h3>$item</h3>";
	echo "<hr>";
	echo "<h3>Ваш коментарий: $com</h3></br><hr>";

	
}
else echo "<h2>Не все данные введены</h2>";
?>