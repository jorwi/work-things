
<!DOCTYPE html>
<html lang="en-gb">

<head>
  <title>Email disclaimers</title>
  <style>
    body {background:#fcfcfc;font-size:13px;width:60%;margin:0 auto;margin-top:75px;margin-bottom:75px;font:13px 'open sans',tahoma,arial,geneva,sans-serif;}
    .html {font:13px "courier new"; }
    h3 {font:15px "open sans semibold",arial;clear:both;}
    a { color: #222; }
    a:hover { color: #be2625; }
    a, button, input, select { transition: 0.3s; }
    .disclaimer {padding:0 15px 10px 15px;margin-bottom:10px;border:1px solid #eeeee0;}
    .disclaimer:nth-child(odd) {background: #f9f9f9;}
    .disclaimer:nth-child(even) {background: #f3f3f3;}
    hr {border-top:1px solid #eeeee0;width:50%;float:left;}
    #home { font-size: 15px; font-family: "Open Sans"; }
  </style>
</head>

<body>

<?php
  # Order: nation, GS name, job title, organisation, address, website
  $nations = array(
    array('"English"', 'org', 'Job title', 'Org', 'Address', 'Website'),
    array('Scottish', 'Name', 'Job title', 'Org', 'Address', 'Website'),
    array('Welsh', 'Name', 'Job title', 'Org', 'Address', 'Website')
  );

  $notes = array("CSS has to be inline", "Edit names/addresses in the PHP file itself (this will change eventually)");
  echo "<p id=\"home\">< <a href=\"index.html\">Home</a></p>\n";
  echo "<h3>Notes</h3>\n";
  
  echo "<ul>\n"; foreach ($notes AS $note) { echo "  <li>".$note."</li>\n"; } echo "</ul>\n\n";

  foreach ($nations AS $nation) {
    echo "<!-- ".$nation[0]." disclaimer -->\n";
    echo "<div class=\"disclaimer\">\n";
    echo "  <h3>".$nation[0]." disclaimer</h3>\n";

    $style = "color:inherit;text-decoration:underline;";

    # CSS is inline due to Office 365 restrictions
    $print = "  <div style=\"font:12px 'open sans',tahoma,arial,geneva,sans-serif;\">\n";
    $print .= "    <p>Sent by email from the ".$nation[3]. ". Promoted by ".$nation[1].($nation[0] == "\"English\"" ? "" : ", ".$nation[2]." on behalf of the ".$nation[3].",")." both at <a href=\"https://maps.google.co.uk/maps?q=".urlencode($nation[4])."\" style=\"".$style."\" target=\"_blank\">".$nation[4]."</a>.</p>\n";
    $print .= "    <p>Website: <a href=\"".$nation[5]."\" style=\"".$style."\" target=\"_blank\">".$nation[5]."</a>.</p>\n";
    $print .= "    <p>To join or renew call <a href=\"tel:+440000000000\" style=\"".$style."\">000 000 0000</a>.</p>\n";
    $print .= "  </div>\n\n";

    # display the above as it looks as a disclaimer
    echo $print;
    echo "  <hr>\n\n";

    # display the HTML version of the disclaimer to copy and paste into Office 365
    echo "  <!-- Start ".$nation[0]." displayed HTML -->\n";
    echo "  <h3>HTML to copy and paste into Office 365 rule</h3>\n";
    echo "  <div class=\"html\">".htmlspecialchars(preg_replace("/\t|\n/", "", str_replace("  ", "", $print)))."</div>\n";
    echo "  <!-- End ".$nation[0]." displayed HTML -->\n";
    echo "</div>\n";
    echo "<!-- End ".$nation[0]." disclaimer -->\n\n";
  }
?>
</body>
</html>