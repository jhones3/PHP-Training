<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Training</title>
    <style>
      *{
        font-family:Arial, Helvetica, sans-serif;
      }
      h1{
        display: flex;
        justify-content: center;
      }
    </style>
</head>
<body>
    <h1>Welcome to PHP</h1>
    <?php
    // echo '<h2>Hi, I am John</h2>';
    // // echo '<h3>Hi, I am John</h3>';
    // print '<h4>This is heading 4</h4>';

    // $name ="John Albert";
    // $jobTitle ="Web Developer</br>";
    // $num1 = 15;
    // $num2 = 10;
    // $isPaid = true;
    // $fruits = array("Banana","Grapes","Orange");
    // $mobileNo = null;

    // echo $name.' '.$jobTitle; 
    // echo $sum = $num1 + $num2."</br> ";
    // var_dump($isPaid) ;
    // echo "</br>";
    // foreach ($fruits as $x) {
    //   echo "$x <br>";
    // }
    // echo $mobileNo;
    // var_dump($mobileNo);


    // $grade = 90.00;
    // var_dump(is_float($grade));
    // echo '</br>';
    // $grade1 = 10;
    // $grade2 = "20";
    // echo $sumGrade =$grade1 + $grade2;
    // echo '</br>';

    // //Casting = converting datatypes
    // $name = "40 Kilo";
    // var_dump((int)$name);
    // $name = "40 Kilo";
    // var_dump((String)$name);

      // $amount = [1,2,3,4,-5];
      // var_dump(min($amount));
      // echo "</br>";
      // var_dump(max($amount));
      // echo "</br>";
      // $randNo = rand(0,10);
      // echo $randNo;

      // //constant variable
      // echo "</br>";
      // define("BIRTHDATE", 2002-03-01);
      // const BIRTHPLACE ="San Ildefonso";
      // echo "</br>";

      // echo BIRTHDATE;
      // echo "</br>";
      // echo BIRTHPLACE;
  
      // // pre define constant
      // echo "</br>";
      // //directory
      // echo __DIR__;
      // echo "</br>";
      // //filename with directory
      // echo __FILE__;

      // $is_hungry = true;
      // if ($is_hungry){
      //   echo "You're Hungry";
      // }
      //   else{
      //     echo "You're not Hungry";
      //   }
      $grade = rand(60,100);
      echo "Your Grade is<b> $grade</b></br>";
      if ($grade < 75){
        echo "Failed!";
      }elseif($grade >= 75 && $grade <= 85){
        echo "Need Improvement!";
      }else{
        echo "Great! You  are Passed!";
      }
    ?>
</body>
</html>