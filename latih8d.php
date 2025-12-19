<<<<<<< HEAD
<!DOCTYPE html>
<html>
<head>
    <title>Pertambahan Bilangan</title>
</head>
<body>

<h2>Program Pertambahan Bilangan</h2>

<form method="POST" action="">
    Bilangan A: <input type="number" name="a" required><br><br>
    Bilangan B: <input type="number" name="b" required><br><br>
    <input type="submit" value="Hitung">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = $_POST['a'];
    $b = $_POST['b'];
    $hasil = $a + $b;

    echo "<h3>Hasil: $a + $b = $hasil</h3>";
}
?>

</body>
</html>
=======
<!DOCTYPE html>
<html>
<head>
    <title>Pertambahan Bilangan</title>
</head>
<body>

<h2>Program Pertambahan Bilangan</h2>

<form method="POST" action="">
    Bilangan A: <input type="number" name="a" required><br><br>
    Bilangan B: <input type="number" name="b" required><br><br>
    <input type="submit" value="Hitung">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = $_POST['a'];
    $b = $_POST['b'];
    $hasil = $a + $b;

    echo "<h3>Hasil: $a + $b = $hasil</h3>";
}
?>

</body>
</html>
>>>>>>> 57919dee0636b493801ef5d1e6b7fb58cd4d2537
