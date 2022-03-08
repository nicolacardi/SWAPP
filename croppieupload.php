<?
$cropped_image = $_POST['image'];
$filenametosave = $_POST['filenametosave'];
$folder= $_POST['foldertoupload'];

$image_name = preg_replace('/[^A-Za-z0-9]/', '', $filenametosave);  //elimina caratteri strani presenti nel nome del file

list($type, $cropped_image) = explode(';', $cropped_image);
list(, $cropped_image)      = explode(',', $cropped_image);
$cropped_image = base64_decode($cropped_image);
file_put_contents($folder.'/'.$image_name.'.png', $cropped_image);


?>


