<?php

  // obtener los datos del formulario
  $titulo = $_GET['titulo'];
  $autor = $_GET['autor'];
  $dia = $_GET['dia'];
  $mes = $_GET['mes'];
  $anio = $_GET['anio'];
  $genero = $_GET['genero'];

  // definir la ruta de la carpeta con las noticias
  $carpeta = 'noticias/';

// obtener una lista de los archivos PHP en la carpeta y subdirectorios
$archivos = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($carpeta));
$archivos = iterator_to_array($archivos);

// Filtrar los archivos que no son PHP
$archivos = array_filter($archivos, function($archivo) {
  return pathinfo($archivo, PATHINFO_EXTENSION) === 'php';
});

// Filtrar los archivos que no se deben incluir en la búsqueda
$archivos = array_filter($archivos, function($archivo) {
    return basename($archivo) !== 'plantillanoticiasparte1.php' && basename($archivo) !== 'plantillanoticiasparte2.php';
});



  // ordenar el arreglo de archivos por fecha
  usort($archivos, function($a, $b) {
    $metatags_a = get_meta_tags($a);
    $metatags_b = get_meta_tags($b);
    $fecha_a = strtotime(str_replace(['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'], ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], $metatags_a['date']));
    $fecha_b = strtotime(str_replace(['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'], ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], $metatags_b['date']));
    return $fecha_b - $fecha_a;
  });

  // definir la URL base de tu sitio web
  $enlace_carpeta = './noticias';

  // crear una tabla para mostrar los resultados
  $resultados_encontrados = false;
  foreach ($archivos as $archivo) {

    // leer los metatags del archivo PHP
    $metatags = get_meta_tags($archivo);
      

    // verificar si el archivo coincide con los criterios de búsqueda
    if (
      (empty($titulo) || stripos($metatags['title'], $titulo) !== false) &&
      (empty($autor) || stripos($metatags['author'], $autor) !== false) &&
      (empty($dia) || stripos($metatags['date'], $dia) !== false) &&
      (empty($mes) || stripos($metatags['date'], $mes) !== false) &&
      (empty($anio) || stripos($metatags['date'], $anio) !== false) &&
      (empty($genero) || $metatags['genre'] == $genero)
    ) {
      // mostrar los datos en la tabla
      if (!$resultados_encontrados) {
        echo '<table>';
        echo '<tr><th>Título</th><th>Autor</th><th>Fecha</th><th>Género</th></tr>';
        $resultados_encontrados = true;
      }
echo '<td><a href="' . $enlace_carpeta . '' . str_replace('\\', '/', str_replace(realpath($carpeta), '', realpath($archivo))) . '">' . $metatags['title'] . '</a></td>';

      echo '<td>' . $metatags['author'] . '</td>';
      echo '<td>' . $metatags['date'] . '</td>';
      echo '<td>' . $metatags['genre'] . '</td>';
      echo '</tr>';
    }
  }

if (!$resultados_encontrados) {
    echo '<div class=matrix id="matrix" style="text-align:center; color:red;">:(<br><br>"Parece que no se encontraron noticias con esas características en la madriguera del conejo, intenta con otros datos"</div> <br>
<div style="text-align:center;">
  <img class= errorgif id="errorgif" src="./images/noresultados.gif"</div>';

} else {
    echo '<div class=matrix id="matrix" style="text-align:center; font-family: Georgia; color: white;"><i>"Bienvenido al mundo real"</i><br> -Morpheus-</div> <br> <br> </table>';
}
?>
<!DOCTYPE html>
<html>
<head>
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700" rel="stylesheet">
  <meta charset="utf-8">
  <title>Mi página web</title>
   <style>
/* Estilos generales */
body {
background-color: #171717;
color: #FFF;
font-family: 'Noto Sans', sans-serif;
}
#errorgif {
    width: 150px;
}
a {
color: #FFF;
}

/* Estilos de la tabla */
table {
border-collapse: collapse;
margin: 0 auto;
background-color: #222;
box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
}

th, td {
padding: 12px;
text-align: left;
border-bottom: 1px solid #444;
}

th {
background-color: #444;
color: #FFF;
}

tr:hover {
background-color: #333;
cursor: pointer;
}

tr:hover a {
color: #FF0101;
}

/* Estilos del botón */
.boton {
background-color: #FF0101;
color: white;
border-radius: 20px;
padding: 10px 20px;
text-decoration: none;
display: inline-block;
}

.boton:hover {
background-color: darkred;
}
/*anchura de la fila title en mobiles*/
@media only screen and (max-width: 767px) {
  table {
  }
  th:first-child {
    width: 100%;
  }
}

/*letras de tabla blancas
/* Estilos de la tabla */
table {
  border-collapse: collapse;
  width: auto;
  margin: 0 auto;
  background-color: #222;
  box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
}

th, td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #444;
  color: #FFF;
}

th {
  background-color: #444;
  color: #FFF;
}

tr:hover {
  background-color: #333;
  cursor: pointer;
}

tr:hover a {
  color: #FF0101;
}

/* Estilos de las filas de autor, fecha y género */
tr td:last-child {
  color: #FFF;
}


/* Estilos para pantallas pequeñas */
@media only screen and (max-width: 600px) {
body {
font-size: 5px;
}

th, td {
padding: 3px;
    padding-bottom: 3px;
  }

}
@media only screen and (max-width: 600px) {
  table {
    margin-left: 35px;
  }
@media only screen and (max-width: 600px) {
  table th, table td {
    font-size: 10px;
  line-height: 1;
  }
#matrix {
margin-left: 35px;
}
#errorgif {
    width: 100px;
    margin-left: 35px;
}

}

    /* ajusta el valor según lo que necesites */
  }
}

}

/* Estilos para pantallas medianas */
@media only screen and (min-width: 601px) and (max-width: 1024px) {
body {
font-size: 14px;
}

th, td {
padding: 14px;
}

.boton {
padding: 12px 24px;
}
}

/* Estilos para pantallas grandes */
@media only screen and (min-width: 1025px) {
body {
font-size: 16px;
}

th, td {
padding: 16px;
}

.boton {
padding: 14px 28px;
}}

}
  </style>
</head>

<body>
</div>
<div class=matrix id="matrix" style="font-family: Georgia; color: white;">
    <br>
    <i>Fin de la madriguera del conejo</i>
     <br><br>
</div>
