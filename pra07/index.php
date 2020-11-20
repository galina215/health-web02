<?php
header("Content-Type:text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <form action="sayhi.php" method="get">
    姓名:<input type="text" name="name" value=""><br>
    年齡:<input type="text" name="age" value=""><br>

    <input type="submit" value="確定">
  </form>
  
</body>
</html>