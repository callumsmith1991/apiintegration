<?php

require '../Config/Db.php';
require 'FormValidation.php';

class FormSubmit extends FormValidation
{

    private $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function create($post_data)
    {


        $isValidated = $this->ValidatePostData($post_data);

        if ($isValidated === true) {


            $directory = "../Images/";
            $name = $_FILES['image']['name'];
            // $file = $directory . basename($_FILES["image"]["name"]);
            // $imageFileType = strtolower(pathinfo($file,PATHINFO_EXTENSION));
            // $image_base64 = base64_encode(file_get_contents($_FILES['image']['tmp_name']) );
            // $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;

            // if (file_exists('../Images/' . $name . '')) {
            //     echo 'file already exists';
            // } else {

                if (move_uploaded_file($_FILES['image']['tmp_name'], '../Images/' . $name)) {

                    $url = $_SERVER['REQUEST_URI'];

                    $url = explode('/', $url);

                    $homepage = $url['1'];

                    $image_path = "http://" . $_SERVER['SERVER_NAME'] . '/' . $homepage . '/Images/' . $name . '';

                    $thumbnail = "http://" . $_SERVER['SERVER_NAME'] . '/' . $homepage . '';

                    $thumbnail .= $this->imageResize($_FILES['image']['name'], '150', '150');
                } else {

                    // echo 'Image not uploaded';
                }
            // }

            $params = array(
                ":property_type_id" => $post_data['propertyType'],
                ":county" => $post_data['county'],
                ":country" => $post_data['country'],
                ":town" => $post_data['town'],
                ":description" => $post_data['description'],
                ":address" => $post_data['address'],
                ":image_full" => $image_path,
                ":image_thumbnail" => $thumbnail,
                ":num_bedrooms" => $post_data['numberOfBedrooms'],
                ":num_bathrooms" => $post_data['numberOfBathrooms'],
                ":price" => $post_data['price'],
                ":type" => $post_data['forsaleorrent']
            );

            $this->db->query("
             
             INSERT INTO properties (
               property_type_id,
               county,
               country,
               town,
               description,
               address,
               image_full,
               image_thumbnail,
               num_bedrooms,
               num_bathrooms,
               price,
               type
             ) VALUES (
                :property_type_id,
                :county,
                :country,
                :town,
                :description,
                :address,
                :image_full,
                :image_thumbnail,
                :num_bedrooms,
                :num_bathrooms,
                :price,
                :type
             )", $params);

            //  $property_id = $this->db->connection->lastInsertId();

             $param_postcode = array(":postcode" => $post_data['postcode']);


             $this->db->query("INSERT INTO property_postcode (property_id, postcode) VALUES (LAST_INSERT_ID(), :postcode)", $param_postcode);

            return true;

        } else {

            return $isValidated;
        }
    }

    public function update($post_data = array())
    {

        $isValidated = $this->ValidatePostData($post_data);

        if ($isValidated === true) {


            $directory = "../Images/";
            $name = $_FILES['image']['name'];


            if (!empty($_FILES['image']['name'])) {

                if (move_uploaded_file($_FILES['image']['tmp_name'], '../Images/' . $name)) {

                    $url = $_SERVER['REQUEST_URI'];

                    $url = explode('/', $url);

                    $homepage = $url['1'];

                    $image_path = "http://" . $_SERVER['SERVER_NAME'] . '/' . $homepage . '/Images/' . $name . '';

                    $thumbnail = "http://" . $_SERVER['SERVER_NAME'] . '/' . $homepage . '';

                    $thumbnail .= $this->imageResize($_FILES['image']['name'], '150', '150');
                } else {

                    echo 'Image not uploaded';
                }

            } else {

               $check_image = array(':id' => $post_data['property']);

               $check_if_property_has_image = $this->db->query("SELECT image_full, image_thumbnail FROM properties WHERE id = :id", $check_image);

               if($check_if_property_has_image !== false)
               {

                 $image_path = $check_if_property_has_image[0]['image_full'];
                 $thumbnail = $check_if_property_has_image[0]['image_thumbnail'];
                
               } else {

                 $image_path = null;
                 $thumbnail = null;

               }

            }


            // }

            $params = array(
                ":id" => $post_data['property'],
                ":property_type_id" => $post_data['propertyType'],
                ":county" => $post_data['county'],
                ":country" => $post_data['country'],
                ":town" => $post_data['town'],
                ":description" => $post_data['description'],
                ":address" => $post_data['address'],
                ":image_full" => $image_path,
                ":image_thumbnail" => $thumbnail,
                ":num_bedrooms" => $post_data['numberOfBedrooms'],
                ":num_bathrooms" => $post_data['numberOfBathrooms'],
                ":price" => $post_data['price'],
                ":type" => $post_data['forsaleorrent']
            );

            $this->db->query("
          UPDATE 
            properties
          SET 
            property_type_id = :property_type_id,
            county = :county,
            country = :country,
            town = :town,
            description = :description,
            address = :address,
            image_full = :image_full,
            image_thumbnail = :image_thumbnail,
            num_bedrooms = :num_bedrooms,
            num_bathrooms = :num_bathrooms,
            price = :price,
            type = :type
          WHERE id = :id", $params);

          // check if property has a postcode 

          $check_param = array("id" => $post_data['property']);

          $check = $this->db->query("SELECT property_id FROM property_postcode WHERE property_id = :id", $check_param);

          if($check !== false)
          {

            $params_pc = array(":id" => $post_data['property'], ":postcode" => $post_data['postcode']);

            $this->db->query("UPDATE property_postcode SET postcode = :postcode WHERE property_id = :id", $params_pc);

          } else 
          {

            $params_pc = array(":property_id" => $post_data['property'], ":postcode" => $post_data['postcode']);

            $this->db->query("INSERT INTO property_postcode (property_id, postcode) VALUES (:property_id, :postcode)", $params_pc);


          }

            return true; 

        } else {

            return $isValidated;
        }
    }

    public function destroy($id)
    {

        $param = array(":id" => $id);

        $result = $this->db->query("DELETE FROM properties WHERE id = :id", $param);

        if ($result !== false) {
            return 'Property deleted';
        } else {

            return 'Property could not be deleted, error occured';
        }
    }

    private function imageResize($image, $newwidth = "150", $newheight = "150")
    {

        list($width, $height) = getimagesize('../Images/' . $image);


        if ($width > $height && $newheight < $height) {
            $newheight = $height / ($width / $newwidth);
        } else if ($width < $height && $newwidth < $width) {
            $newwidth = $width / ($height / $newheight);
        } else {
            $newwidth = $width;
            $newheight = $height;
        }

        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = imagecreatefromjpeg('../Images/' . $image);
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        // return imagejpeg($thumb, '../Images/thumbnails/'.$image.'');
        imagejpeg($thumb, '../Images/thumbnails/' . $image . '');

        $path_to_thumbnail = '/Images/thumbnails/' . $image . '';

        return $path_to_thumbnail;
    }
}
