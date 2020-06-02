<?php

include 'Includes/Header.php';
require 'Config/Db.php';
require 'Properties/Property.php';

$property_id = strip_tags(htmlspecialchars($_GET['id'], ENT_QUOTES));


if (isset($property_id)) {

    $property = new Property($property_id);

    $test = 'test';
?>

    <div class="row">
        <div class="col-4">

            <form action="Forms/Submission.php" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="county">County</label>
                    <input type="text" name="county" value="<?php echo $property->county; ?>" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" name="country" value="<?php echo $property->country; ?>" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="town">Town</label>
                    <input type="text" name="town" value="<?php echo $property->town; ?>" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="postcode">Postcode</label>
                    <input type="text" name="postcode" value="<?php echo $property->postcode; ?>" class="form-control" />
                </div>


                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="textarea" name="description" value="<?php echo $property->description; ?>" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" value="<?php echo $property->address; ?>" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" value="<?php echo $property->price; ?>" class="form-control" />
                </div>


                <div class="form-group">
                    <label for="image">Current Image</label><br>
                    <img src="<?php echo $property->image_thumbnail; ?>" alt=""><br><br>
                    <p>New Image</p>
                    <input type="file" name="image" />
                </div>

                <div class="form-group">
                    <label for="numberOfBedrooms">Number of bedrooms</label>
                    <select name="numberOfBedrooms" id="" class="form-control">
                        <option value="1" <?php if($property->num_bedrooms == "1") { echo "selected";} ?>>1</option>
                        <option value="2" <?php if($property->num_bedrooms == "2") { echo 'selected';} ?>>2</option>
                        <option value="3" <?php if($property->num_bedrooms == "3") { echo 'selected';} ?>>3</option>
                        <option value="4" <?php if($property->num_bedrooms == "4") { echo "selected";} ?>>4</option>
                        <option value="5" <?php if($property->num_bedrooms == "5") { echo "selected";} ?>>5</option>
                        <option value="6" <?php if($property->num_bedrooms == "6") { echo "selected";} ?>>6</option>
                        <option value="7" <?php if($property->num_bedrooms == "7") { echo "selected";} ?>>7</option>
                        <option value="8" <?php if($property->num_bedrooms == "8") { echo "selected";} ?>>8</option>
                        <option value="9" <?php if($property->num_bedrooms == "9") { echo "selected";} ?>>9</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="numberOfBathrooms">Number of bathrooms</label>
                    <select name="numberOfBathrooms" id="" class="form-control">
                        <option value="1" <?php if($property->num_bathrooms == "1") { echo "selected";} ?>>1</option>
                        <option value="2" <?php if($property->num_bathrooms == "2") { echo "selected";} ?>>2</option>
                        <option value="3" <?php if($property->num_bathrooms == "3") { echo "selected";} ?>>3</option>
                        <option value="4" <?php if($property->num_bathrooms == "4") { echo "selected";} ?>>4</option>
                        <option value="5" <?php if($property->num_bathrooms == "5") { echo "selected";} ?>>5</option>
                        <option value="6" <?php if($property->num_bathrooms == "6") { echo "selected";} ?>>6</option>
                        <option value="7" <?php if($property->num_bathrooms == "7") { echo "selected";} ?>>7</option>
                        <option value="8" <?php if($property->num_bathrooms == "8") { echo "selected";} ?>>8</option>
                        <option value="9" <?php if($property->num_bathrooms == "9") { echo "selected";} ?>>9</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="propertyType">Property Type</label>
                    <select name="propertyType" id="" class="form-control">
                        <option value="1" <?php if($property->property_type_id == "1") { echo "selected";} ?>>Flat</option>
                        <option value="2" <?php if($property->property_type_id == "2") { echo "selected";} ?>>Detatched</option>
                        <option value="3" <?php if($property->property_type_id == "3") { echo "selected";} ?>>Semi-detached</option>
                        <option value="4" <?php if($property->property_type_id == "4") { echo "selected";} ?>>Terraced</option>
                        <option value="5" <?php if($property->property_type_id == "5") { echo "selected";} ?>>End of Terrace</option>
                        <option value="6" <?php if($property->property_type_id == "6") { echo "selected";} ?>>Cottage</option>
                        <option value="7" <?php if($property->property_type_id == "7") { echo "selected";} ?>>Bungalow</option>
                    </select>
                </div>


                <div class="form-group">

                    <label>For Sale</label><br>
                    <input type="radio" name="forsaleorrent" value="For Sale" <?php if ($property->type == 'For Sale' || $property->type == 'sale') {
                                                                                echo "checked=checked";
                                                                            }  ?> /><br>
                    <label>For Rent</label><br>
                    <input type="radio" name="forsaleorrent" value="For Rent" <?php if ($property->type == 'For Rent' || $property->type == 'rent') {
                                                                                echo "checked=checked";
                                                                            }  ?> />
                </div>

                <input type="hidden" name="form-name" value="update" />
                <input type="hidden" name="property" value="<?php echo $property_id; ?>" />
                <input type="submit" />

            </form>
            
            <div id="response"></div>

        </div>
    </div>



<?php

} else {

    // header('Location: // '');

    exit();
}

?>



<?php

include 'Includes/Footer.php';


?>