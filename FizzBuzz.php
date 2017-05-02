<?php

for($i = 1; $i <= 50; $i++){
  if($i % 3 == 0 && $i % 5 == 0){
    echo "FizzBuzz<br>\n";
  }
  elseif($i % 3 == 0){
    echo "Fizz<br>\n";
  }
  elseif($i % 5 == 0){
    echo "Buzz<br>\n";
  }
  else{
    echo "$i<br>\n";
  }
}
?>
