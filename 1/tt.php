<?php
$i='A';
switch ($i) {
   case 'A': $grade = 90;
   echo $grade;
             break;
   case 'b':
   case 'B': $grade = 80;
             break;
   default: $grade = 60;
            break;
}
?>