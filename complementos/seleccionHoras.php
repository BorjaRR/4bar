<?php

$horas = 13;
$minutos = 00;

for($i=0;$i<3;$i++){
    if($minutos==0){
        $minutos=$minutos.$minutos;
    }
    for($j=0;$j<4;$j++){
        echo "<option value=\"$horas:$minutos\">$horas:$minutos</option>";
        $minutos+=15;
    }
    $horas+=1;
    $minutos=0;
}

echo "<option value=\"--\" disabled>--</option>";

$horas = 21;
$minutos = 00;

for($i=0;$i<3;$i++){
    if($minutos==0){
        $minutos=$minutos.$minutos;
    }
    for($j=0;$j<4;$j++){
        echo "<option value=\"$horas:$minutos\">$horas:$minutos</option>";
        $minutos+=15;
    }
    $horas+=1;
    $minutos=0;
}
?>
