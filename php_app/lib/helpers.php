<?php 

function size_to_str($size, $sep = ' ')
{ 
  $unit = null;
  $units = array('B', 'KB', 'MB', 'GB', 'TB');
  for($i = 0, $c = count($units); $i < $c; $i++)
  {
    if ($size > 1024)
    {
      $size = $size / 1024;
    }
    else
    {
      $unit = $units[$i];
      break;
    }
  }
  return round($size, 2).$sep.$unit;
}



?>