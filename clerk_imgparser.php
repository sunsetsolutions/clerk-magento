<?php
/*
   Clerk.io
   "Magento Product Image Parser"
   ---
   When generating the feed using the SOAP API is impossible to catch the image
   cache... so this parser, just do this in real time like Magento does when
   generating the page views...
   ---
   @cebasso
*/
require './app/Mage.php';
Mage::app();

/* Get the product ID from the URL params */
$product_id = (isset($_GET["id"])) ? $_GET["id"] : FALSE;

/* Something wrong... so we need the placeholder at least */
if ($product_id === FALSE)
$product_id = 99999;

$helper = Mage::getModel('catalog/product');
$product = $helper->load($product_id);

if (isset($product))
  {
  /* Image size for this store */
  $image_size = (isset($_GET["size"])) ? explode(",", $_GET["size"]) : array(0 => "256", "256");
  $image_url = ($product->hasSmallImage()) ? Mage::helper('catalog/image')->init($product, 'small_image')->resize($image_size[0], $image_size[1]) : Mage::helper('catalog/image')->init($product, 'image')->resize($image_size[0], $image_size[1]);
  $file_path = parse_url($image_url);
  $file_path = ".".$file_path["path"];
  $img_types = Array(
  "gif" => "image/gif",
  "jpg" => "image/jpeg",
  "jpeg" => "image/jpeg",
  "png" => "image/png",
  "bmp" => "image/bmp");
  header("Content-type: ".$img_types[pathinfo($file_path, PATHINFO_EXTENSION)]);
  header("Content-Length: ".filesize($file_path));
  die(readfile($file_path));
  }