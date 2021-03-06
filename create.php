<?php

include 'Includes/Header.php';


?>

<div class="row">
    <div class="col-4">

        <form action="Forms/Submission.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="county">County</label>
                <input type="text" name="county" class="form-control" />
            </div>

            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" name="country" class="form-control" />
            </div>

            <div class="form-group">
                <label for="town">Town</label>
                <input type="text" name="town" class="form-control" />
            </div>

            <div class="form-group">
                <label for="postcode">Postcode</label>
                <input type="text" name="postcode" class="form-control" />
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="textarea" name="description" class="form-control" />
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control" />
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" class="form-control" />
            </div>

            <div class="form-group">
                <label for="image">Image</label><br>
                <input type="file" name="image" />
            </div>

            <div class="form-group">
                <label for="numberOfBedrooms">Number of bedrooms</label>
                <select name="numberOfBedrooms" id="" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                </select>
                </label>
            </div>

            <div class="form-group">
                <label for="numberOfBathrooms">Number of bedrooms</label>
                <select name="numberOfBathrooms" id="" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                </select>
            </div>

            <div class="form-group">
                <label for="propertyType">Property Type</label>
                <select name="propertyType" id="" class="form-control">
                    <option value="1">Flat</option>
                    <option value="2">Detatched</option>
                    <option value="3">Semi-detached</option>
                    <option value="4">Terraced</option>
                    <option value="5">End of Terrace</option>
                    <option value="6">Cottage</option>
                    <option value="7">Bungalow</option>
                </select>
            </div>

            <div class="form-group">
                <label>For Sale</label><br>
                <input type="radio" name="forsaleorrent" value="For Sale" /><br>
                <label>For Rent</label><br>
                <input type="radio" name="forsaleorrent" value="For Rent" />
            </div>

            <input type="hidden" name="form-name" value="create" />
            <input type="submit" />

        </form>

        <div id="response"></div>

    </div>
</div>





<?php

include 'Includes/Footer.php';

?>