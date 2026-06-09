<?php
// 1. Obtener la hora actual en formato de 24 horas (de 00 a 23)
// Forzamos a que sea un número entero con (int)
$hora = (int)date("H"); 

// 2. Determinar el turno según el rango de horas
if ($hora >= 5 && $hora <= 11) {
    $turno = "manana";
} elseif ($hora >= 12 && $hora <= 18) {
    $turno = "tarde";
} elseif ($hora >= 19 && $hora <= 23) {
    $turno = "noche";
} else { // De 0 a 4
    $turno = "cerrado";
}

// 3. Evaluar el turno usando la estructura SWITCH para mostrar el saludo
switch ($turno) {
    case "manana":
        echo "Buenos días, bienvenido a Mass\n";
        break;
        
    case "tarde":
        echo "Buenas tardes, bienvenido a Mass\n";
        break;
        
    case "noche":
        echo "Buenas noches, bienvenido a Mass\n";
        break;
        
    case "cerrado":
        echo "Tienda cerrada en este horario\n";
        break;
}
?>