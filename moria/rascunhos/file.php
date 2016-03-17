<form id="f1" name="f1" method="post" action="file.php" enctype="multipart/form-data">
  <input type="file" name="arquivo[]"/>
  <input type="file" name="arquivo[]"/>
  <input type="file" name="arquivo[]"/>
  <input type="submit" name="Submit" value="Submit" />
</form>

<?
print_r($_FILES);
?>