<?php
require_once 'includes/dbh.php';

$stmt = $pdo->query("
    SELECT ce.nombre AS ciclo, ROUND(AVG(c.prom_final), 2) AS promedio_general
    FROM calificaciones c
    JOIN grupo g ON g.id_grupo = c.id_grupo
    JOIN ciclos_escolares ce ON ce.id_ciclo = g.id_ciclo
    GROUP BY ce.id_ciclo
");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$width = 600;
$height = 400;
$margin = 40;
$bar_width = 40;

$image = imagecreate($width, $height);
$bg_color = imagecolorallocate($image, 255, 255, 255);
$bar_color = imagecolorallocate($image, 0, 123, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
$axis_color = imagecolorallocate($image, 50, 50, 50);

$max_value = 10;
$bar_spacing = 80;
$origin_x = $margin;
$origin_y = $height - $margin;

imageline($image, $origin_x, $margin, $origin_x, $origin_y, $axis_color);
imageline($image, $origin_x, $origin_y, $width - $margin, $origin_y, $axis_color);

$i = 0;
foreach ($data as $row) {
    $x1 = $origin_x + $i * $bar_spacing + 10;
    $y1 = $origin_y - ($row['promedio_general'] / $max_value) * ($height - 2 * $margin);
    $x2 = $x1 + $bar_width;
    $y2 = $origin_y;

    imagefilledrectangle($image, $x1, $y1, $x2, $y2, $bar_color);
    imagestring($image, 2, $x1, $y1 - 15, $row['promedio_general'], $text_color);
    imagestring($image, 2, $x1, $origin_y + 5, substr($row['ciclo'], 0, 6), $text_color);
    $i++;
}

header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
exit;