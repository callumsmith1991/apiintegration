
<?php

class FormValidation
{

    protected function ValidatePostData($post_data = array())
    {

        $error_messages = array();

        if (empty($post_data['county'])) {
            $error_messages[] = 'County has no value';
        }

        if (empty($post_data['country'])) {
            $error_messages[] = 'Country has no value';
        }

        if (empty($post_data['town'])) {
            $error_messages[] = 'Town has no value';
        }

        if (empty($post_data['postcode'])) {
            $error_messages[] = 'Postcode has no value';
        }

        if (empty($post_data['description'])) {
            $error_messages[] = 'Description has no value';
        }

        if (empty($post_data['numberOfBedrooms'])) {
            $error_messages[] = 'Please enter a number of bedrooms';
        }

        if (empty($post_data['numberOfBathrooms'])) {
            $error_messages[] = 'Please enter a number of bathrooms';
        }

        if (empty($post_data['propertyType'])) {
            $error_messages[] = 'Please select a property type';
        }

        if (empty($post_data['price'])) {
            $error_messages[] = 'Price is empty';
        }

        if (empty($post_data['forsaleorrent'])) {

            $error_messages[] = 'Please select a option';
        }

        // Image Validation


        if (empty($_FILES['image']['name'])) {

            if($post_data['form-name'] !== 'update') { 

               $error_messages[] = 'Please upload a image';

            }

        } else {

            $allowed_image_extensions = array(".jpg", ".jpeg", ".png", ".gif");

            $image_name = $_FILES['image']['name'];

            $image_extension = substr($image_name, strlen($image_name) - 4, strlen($image_name));

            if (!in_array($image_extension, $allowed_image_extensions)) {

                $error_messages[] = 'Image has invalid format. only jpg / jpeg / png / gif format allowed';
            } else {

                $image_dimensions = getimagesize($_FILES['image']['tmp_name']);

                if ($image_dimensions == false) {

                    $error_messages[] = "File is not a image";
                } else {

                    $image_size = $_FILES['image']['size'];

                    if ($image_size > 500000) {

                        $error_messages[] = 'Image is too large, please reduce size';
                    }
                }
            }
        }

        if (count($error_messages) > 0) {

            return $error_messages;
        } else {

            return true;
        }

    }
}



?>