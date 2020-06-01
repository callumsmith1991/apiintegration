<?php

include 'Includes/Header.php';

// require 'Config/Db.php';
require 'Config/Db.php';
require 'Config/Seeder.php';
require 'Api/ApiRequest.php';
require 'Properties/Property.php';

$url = $_SERVER['REQUEST_URI'];

$url = explode('/', $url);

$homepage = $url['1'];


// $url = 'http://trialapi.craig.mtcdevserver.com/api/properties';
// $api_request = new ApiRequest();
// $result = $api_request->get($url);

$seed = Seeder::getInstance();
$app_instantized = $seed->checkIfTablesExist();

if ($app_instantized === false) :

?>

    <div id="response">

        <p>Do you want to integrate Api information in Database: <strong><?php echo $seed->database_name; ?></strong></p>

        <form action="<?php echo "http://" . $_SERVER['SERVER_NAME'] . '/' . $homepage ?>/Forms/Submission.php" method="POST" id="seed-form">
            <input type="submit" class="btn btn-primary" name="yes" value="Yes" />
            <input type="hidden" name="form-name" value="seed" />
        </form>


    </div>



<?php


else :


?>



    <?php

    if (!isset($_SESSION['firstVisit'])) {

        $url = 'http://trialapi.craig.mtcdevserver.com/api/properties';
        $api_request = new ApiRequest();
        $result = $api_request->get($url);

        $update_data_result = $seed->updateData($result['data']);
        echo $update_data_result;
        $_SESSION['firstVisit'] = 1;
    }

    $properties_in_db = Property::getAllProperties();

    // echo '<pre>';
    // print_r($properties_in_db);
    // echo '</pre>';



    if ($properties_in_db !== false) :

    ?>


        <table class="table">
            <thead>
                <th>Address</th>
                <th></th>
            </thead>

            <tbody>
                <?php foreach ($properties_in_db as $property) : ?>

                    <tr>
                        <!-- <td><?php echo $property->uuid; ?></td> -->
                        <td><?php echo $property->address; ?></td>
                        <td><a href="edit.php?id=<?php echo $property->id; ?>" class="btn btn-info">Edit</a></td>
                        <td><a href="delete.php?id=<?php echo $property->id; ?>" class="btn btn-danger">Delete</a></td>
                    </tr>

                <?php endforeach; ?>

            </tbody>
        </table>

        <div class="row">
            <div class="col-12">
                <a href="create.php" class="btn btn-primary">Create New</a>
            </div>
        </div>


    <?php

    else :

    ?>

        <p>No properties to display here yet</p>

        <div class="row">
            <div class="col-12">
                <a href="create.php" class="btn btn-primary">Create New</a>
            </div>
        </div>

<?php

    endif;
endif;

// $seed->createTables();
// $test = $seed->seedApiData($result['data']);

// echo '<pre>';
// print_r($result);
// echo '</pre>';

include 'Includes/Footer.php';

?>