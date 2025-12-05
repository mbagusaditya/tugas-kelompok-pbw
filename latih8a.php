<?php

$nama="Cahaya Jatmoko";
$tinggi=176;

echo "nama saya :" .$nama." tinggi badan :".$tinggi."cm";

 $x=5;  //global scope
 
 function myTest()
 {
    // using x inside thid function will gerate an error
    // global $x;
    echo"<p> varibel x inseide funcction is :".$x."</p>";

 }
myTest();

echo $_SERVER['PHP_SELF'];
echo "<br>"; 
echo $_SERVER['SERVER_NAME'];
?>