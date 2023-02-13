<?php
  require_once 'header.php';

  # get current bookmarks
  $stmt1 = $sql->query("SELECT `name`, `url` FROM `bookmark` WHERE `visible` = 1");
  $entries = $stmt1->rowCount();
  $bookmark_url = (isset($_POST['bookmark-url'])) ? htmlspecialchars($_POST['bookmark-url']) : "";
  $bookmark_name = (isset($_POST['bookmark-name'])) ? htmlspecialchars($_POST['bookmark-name']) : "";
  $visible = (isset($_POST['visible'])) ? 1 : 0; 
?>
  <h4>Managed bookmarks</h4>
  <div id="extra-links"><a href="#">Edit bookmarks</a></div>

  <div class="row">
    <div class="eight columns">
      <p class="intro">This script will enable you to easily get JSON for managed bookmarks.</p>
      <p class="intro">In the future this will be developed to allow you to check and uncheck bookmarks you wish to include in the JSON as well as the ability to edit existing bookmarks.</p>

      <form action="bookmarks.php" name="commands" method="post">
        <input type="text" class="u-full-width" placeholder="Bookmark name" value="<?php echo $bookmark_name; ?>" name="bookmark-name" required="required">
        <input type="text" class="u-full-width" placeholder="Bookmark URL" value="<?php echo $bookmark_url; ?>" name="bookmark-url" required="required">
        <div id="visible"><span>Visible?</span> &nbsp; <input type="checkbox" name="visible" checked="checked"></div>
        <input class="button-primary" type="submit" value="Submit" name="submit-bookmark">
      </form>
    </div>
  </div>

<?php
  if (isset($_POST['submit-bookmark']) AND (!empty($bookmark_name) AND (!empty($bookmark_url)))) {
    # Is the submitted URL a URL?
    if (!filter_var($_POST['bookmark-url'], FILTER_VALIDATE_URL)) {
        echo "  <div class=\"error\">\n    <h6>ERROR:</h6>\n    <p>Sorry, the URL you entered does not look like a valid URL.</p>\n  </div>\n\n";
    }
    else {
      $stmt2 = $sql->prepare("INSERT INTO `bookmark` (`name`, `url`, `visible`) VALUES (:bookmark_name, :bookmark_url, :visible)");
      $stmt2->bindValue('bookmark_name', $bookmark_name);
      $stmt2->bindValue('bookmark_url', $bookmark_url);
      $stmt2->bindValue('visible', $visible);

      if ($stmt2->execute()) {
        echo "  <div class=\"success\">\n    <h6>SUCCESS:</h6>\n    <p>The bookmark was added.</p>\n  </div>\n\n";
      }
	    else {
        echo "  <div class=\"error\">\n    <h6>ERROR:</h6>\n    <p>Sorry, the URL you entered does not look like a valid URL.</p>\n  </div>\n\n";
      }
    }
  }
?>
  <p class="strong">Current JSON (<?php echo $entries; ?> items)</p>

  <pre>
<?php
  $bookmark = array();

  echo "  [\n";
  echo "    { \"toplevel_name\": \"Managed favourites\" },\n";

  while (list($name, $url) = $stmt1->fetch()) {
	  $bookmark[] = "    {\n      \"name\": \"".$name."\",\n      \"url\": \"".$url."\"\n    }";
  }
  echo implode(",\n", $bookmark);
  echo "\n  ]\n";
?>
  </pre>
</div>

</body>
</html>