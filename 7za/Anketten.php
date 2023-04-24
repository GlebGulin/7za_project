<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Анкета студента</title>
</head>
<body>
<h2>Пожалуйста, заполните анкету</h2>
<form action = "AnkettenResult.php" method="POST">
Ваше имя: <input type="text" name="FirstName"></br>
Ваша фамилия: <input type="text" name = "SurName"></br><hr>
<h3>Форма обучения:</h3></br>
<input type = "radio" name="formeduc" value="Очно">Очно</br>
<input type = "radio" name="formeduc" value="Заочно">Заочно</br><hr>
<h3>Потребность в общежитии</h3></br>
<input type="checkbox" name="hostel"/>Да</br><hr>
<h3>Выберите курсы</h3></br>
<select name="courses[]" size="3" multiple>
<option value="eng">English</option>
<option value="deu">Deutsh</option>
<option value="fra">Francais</option>
<option value="esp">Espaniol</option>
<option value="ita">Italian</option>
<option value="lat">Latvias</option>
</select></br><hr>
<h3>Краткий коментарий</h3></br>
<textarea name="coment" maxlength ="8000"></textarea></br>
<hr>




<input type="submit" value="Отправить"></br>
</form>
</body>
</html>