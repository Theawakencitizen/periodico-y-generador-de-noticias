<?php
if (isset($_POST['submit'])) {
  $titulo = $_POST['titulo'];
    $description = $_POST['description'];
  $fecha = $_POST['fecha'];
  $genero = $_POST['genero'];
  $autor = $_POST['autor'];
  $noticia = $_POST['noticia'];
  $imagen = $_FILES['imagen']['name'];

  // Validar la fecha
  if (!preg_match('/^\d{1,2}\s\w{3}\,\s\d{4}$/', $fecha)) {
    echo "La fecha debe tener el formato 'dd Mmm, yyyy'";
    exit;
  }

  // Crear una copia de plantilla.php en la carpeta noticias
  copy('plantilla/plantilla.php', 'noticias/' . $imagen . '.php');

  // Abrir la nueva página HTML
  $pagina = file_get_contents('noticias/' . $imagen . '.php');

  // Reemplazar los valores de la página con los valores enviados por el formulario
  $pagina = str_replace('Fecha de la noticiax', $fecha, $pagina);
  $pagina = str_replace('Título de la noticiax', $titulo, $pagina);
  $pagina = str_replace('Género de la noticiax', $genero, $pagina);
  $pagina = str_replace('Autor de la noticiax', $autor, $pagina);
  $pagina = str_replace('noticia aquíx', $noticia, $pagina);
  $pagina = str_replace('imagenaquíx', $imagen, $pagina);
    $pagina = str_replace('descriptionaquix', $description, $pagina);

  // Guardar los cambios en la nueva página HTML
  file_put_contents('noticias/' . $imagen . '.php', $pagina);

  // Descargar la nueva página HTML
  header('Content-disposition: attachment; filename=' . $imagen . '.php');
  header('Content-type: text/html');
  readfile('noticias/' . $imagen . '.php');
}
?>
