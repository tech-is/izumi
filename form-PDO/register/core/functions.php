<?php
//$array = [["name","slug"],["name","slug"]["name","slug"]];
function insert_parts($array)
{
  foreach ($array as $val) {
    include("./parts/form-parts.php");
  }
}

function insert_CSS()
{
  require("./parts/CSS.php");
}

function Encode_POST_values()
{
  foreach ($_POST as $key => $value) {
    $_POST[$key] = htmlspecialchars($value, ENT_QUOTES, "UTF-8");
  }
}
?>