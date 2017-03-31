 <?php
 error_reporting(E_ALL);
 include(dirname(__FILE__).'/config/config.inc.php');
 include(dirname(__FILE__).'/init.php');

 function subidaFichero(){
     $nombre_archivo=$_FILES['userfile']['name'];
     $tipo_archivo = $_FILES['userfile']['type'];
     $tamano_archivo = $_FILES['userfile']['size'];
     $dir= 'C:\\xampp\\htdocs\\prestashop\\xml';
     $dir2=$dir."\\".$nombre_archivo;


     if (file_exists($dir."\\".$nombre_archivo)){


     }else if (move_uploaded_file($_FILES['userfile']['tmp_name'],"$dir/$nombre_archivo")){
     }

     return $dir."\\".$nombre_archivo;
 }

 function leerXml($dir){
     return simplexml_load_file($dir);
 }

 $arrray=leerXml(subidaFichero());
 foreach ($arrray->Products AS $product_xml ){


         /* Update an existing product or Create a new one */

         $id_product = Db::getInstance()->getValue('SELECT id_product FROM ps_product WHERE reference = \'' . $product_xml->reference . '\'');
         $product = $id_product ? new Product((int)$id_product, true) : new Product();
         $product->reference = $product_xml->reference;
         $product->price = (float)$product_xml->price;
         $product->active = (int)$product_xml->active;
         $product->id_category_default = $product_xml->id_category_default;
         $product->name[1] = utf8_encode((string)$product_xml->name);
         $product->link_rewrite[1] = Tools::link_rewrite((string)$product_xml->name);

         $product->save();
     echo 'Product <b>' . $product->name[1] . '</b> ' . ($id_product ? 'updated' : 'created') . '<br />';



 }




