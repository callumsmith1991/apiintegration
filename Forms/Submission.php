<?php



require 'FormSubmit.php';
include '../Includes/Header.php';
//require '../Config/Db.php';
include '../Config/CreateTables.php';
// require '../Config/Db.php';


$url = $_SERVER['REQUEST_URI'];

$url = explode('/', $url);

$homepage = $url['1'];

$submitHandler = new FormSubmit();

if ($_POST['form-name'] == 'create') {

    $update_request = $submitHandler->create($_POST);

    if (is_array($update_request)) {

        echo '<div class="alert alert-danger"><ul>';

        foreach ($update_request as $error_message) {

            echo '<li>'.$error_message.'</li>';
        }

        echo '</ul></div>';

    } else {

        echo '<div class="alert alert-success">Property created successfully</div>';

    }

} elseif($_POST['form-name'] == 'update') {

    $update_request = $submitHandler->update($_POST);

    if (is_array($update_request)) {

        echo '<div class="alert alert-danger"><ul>';

        foreach ($update_request as $error_message) {

            echo '<li>'.$error_message.'</li>';
        }

        echo '</ul></div>';

    } elseif($update_request == true) {

        echo '<div class="alert alert-success">Property updated successfully</div>';

    }

} elseif($_POST['form-name'] === 'delete')
{

    $delete_request = $submitHandler->destroy($_POST['property']);

    echo $delete_request;

} elseif($_POST['form-name'] === 'seed')
{
    $seed = new CreateTables();
    $create_tables = $seed->create();

    if($create_tables == true)
    {

        echo '<div class="alert alert-success">Tables created successfully</div>';

    } else {

        echo '<div class="alert alert-danger">ERROR something went wrong</div>';

    }
}

?>

<div class="row">
    <div class="col-12">
       <a class="btn btn-primary" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] . '/' . $homepage ?>">Back To Home</a>
    </div>
</div>

<?php

include '../Includes/Footer.php';


?>