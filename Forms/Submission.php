<?php



require 'FormSubmit.php';
include '../Includes/Header.php';
//require '../Config/Db.php';
require '../Config/Seeder.php';
require '../Api/ApiRequest.php';
// include '../Config/CreateTables.php';
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
    $seed = Seeder::getInstance();
    $create_tables = $seed->createTables();
    
    $url = 'http://trialapi.craig.mtcdevserver.com/api/properties';
    $api_request = new ApiRequest();
    $result = $api_request->get($url);

    if(is_array($result)) {

        $seed_api_data = $seed->seedApiData($result['data']);

    } else {

        $seed_api_data = false;

    }



    if($create_tables == true)
    {

        echo '<div class="alert alert-success">Tables created successfully</div>';

    } else {

        echo '<div class="alert alert-danger">ERROR something went wrong</div>';

    }

    if($seed_api_data == false)
    {

        echo '<div class="alert alert-danger">ERROR could not seed api data</div>';

    } else {

        echo '<div class="alert alert-success">Api data seeded successfully</div>';

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