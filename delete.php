
<?php

include 'Includes/Header.php';
require 'Config/Db.php';
require 'Properties/Property.php';


$property_id = strip_tags(htmlspecialchars($_GET['id'], ENT_QUOTES));

$url = $_SERVER['REQUEST_URI'];

$url = explode('/', $url);

$homepage = $url['1'];

if (isset($property_id)) {

    $property = new Property($property_id);

}


?>

<form action="Forms/Submission.php" method="POST">
    <p>Are you sure you want to delete <?php echo $property->address; ?> ? </p>
    <input type="hidden" name="form-name" value="delete" />
    <input type="hidden" name="property" value="<?php echo $property->id; ?>" />
    <input type="submit" class="btn btn-danger" value="Yes" />
    <a href="index.php" class="btn btn-primary">No</a>
</form>

<div id="response"></div>

<?php

include 'Includes/Footer.php';


?>