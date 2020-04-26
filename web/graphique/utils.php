<?php
function loadConfig($file) {
  $data = file_get_contents($file);
  return json_decode($data, true);
}
?>
