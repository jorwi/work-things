<!doctype html>
<html lang="en">
  <head>
    <title>External email warning</title>
	<style>body {width:50%;}.html {font:13px "courier new";padding-bottom:15px;}h3{font:15px 'open sans semibold',tahoma,arial,geneva,sans-serif;clear:both;}</style>
  </head>

  <body>
<?php
  # This is CSS that won't change - sets font type/colour/size, background colour etc.
  $defaultcss = "font:12px 'open sans',tahoma,arial,geneva,sans-serif;color:#be2625;background-color:#fdf2fa;padding:5px 0 5px 5px;border-color:#be2625;border-style:solid;text-align:left;";
  # create CSS here
  $css = array(
    $defaultcss."border-width:0 0 0 4px",
    $defaultcss."border-width:0 0 3px 3px;",
    $defaultcss."border-width:0 0 2px 2px;"
  );
  $phrase = "This email originates outside of Org. Please be careful opening attachments or clicking links.";

  foreach ($css AS $style) {
    echo "    <p style=\"".$style."\">".$phrase."</p>\n";
    echo "    <h3>HTML</h3>\n";
    echo "    <p class=\"html\">".htmlspecialchars("<p style=\"$style\">".$phrase."</p>")."</p>\n";
  }
?>
  </body>
</html>