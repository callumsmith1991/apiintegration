
<?php


// require 'Config/Db.php';

class Seeder
{

  private $db;
  public $database_name;
  private static $instance = null;

  public function __construct()
  {
    $this->db = Db::getInstance();
    $this->database_name = $this->db->db_name;
  }

  public static function getInstance()
  {
    if (!self::$instance) {
      self::$instance = new Seeder();
    }

    return self::$instance;
  }

  public function checkIfTablesExist()
  {

    $table_exists = $this->db->query('SHOW TABLES LIKE "properties"');

    if ($table_exists === false) {

      return false;

    } else {

      return true;
    }
  }

  public function createTables()
  {

    $create_property_type = $this->db->query('
    CREATE TABLE `' . $this->db->db_name . '`.`property_type` (
      `id` INT(11) NOT NULL, 
      `title` VARCHAR(255) NOT NULL, 
      `description` LONGTEXT NOT NULL, 
      `created_at` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6), 
      `updated_at` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6), 
      PRIMARY KEY (`id`)
    ) ENGINE = InnoDB;
    ');

    $create_property = $this->db->query('
    CREATE TABLE `' . $this->db->db_name . '`.`properties` (
      `id` INT(11) NOT NULL AUTO_INCREMENT, 
      `uuid` VARCHAR(255) NOT NULL, 
      `property_type_id` INT(11) NULL DEFAULT NULL, 
      `county` VARCHAR(255) NULL DEFAULT NULL, 
      `country` VARCHAR(255) NULL DEFAULT NULL, 
      `town` VARCHAR(255) NULL DEFAULT NULL, 
      `description` LONGTEXT NULL DEFAULT NULL, 
      `address` VARCHAR(255) NOT NULL, 
      `image_full` VARCHAR(255) NULL DEFAULT NULL, 
      `image_thumbnail` VARCHAR(255) NULL DEFAULT NULL, 
      `latitude` VARCHAR(255) NULL DEFAULT NULL, 
      `longitude` VARCHAR(255) NULL DEFAULT NULL, 
      `num_bedrooms` INT(11) NULL DEFAULT NULL, 
      `num_bathrooms` INT(11) NULL DEFAULT NULL, 
      `price` INT(11) NULL DEFAULT NULL, 
      `type` VARCHAR(255) NULL DEFAULT NULL, 
      `created_at` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6), 
      `updated_at` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6), 
      PRIMARY KEY (`id`)
    ) ENGINE = InnoDB;
    ');

    // FOREIGN KEY (`property_type_id`) REFERENCES property_type(`id`) ON DELETE CASCADE

    $create_property_postcode = $this->db->query('
    CREATE TABLE `' . $this->db->db_name . '`.`property_postcode` ( 
     `id` INT(11) NOT NULL auto_increment, 
     `property_id` INT(11) NOT NULL, 
     `postcode`  VARCHAR(255) NOT NULL, 
     PRIMARY KEY (`id`),
     FOREIGN KEY (`property_id`) REFERENCES properties(`id`) ON DELETE CASCADE
  ) engine = innodb; 
  ');

    if($create_property_type !== false && $create_property !== false && $create_property_postcode !== false)
    {

      return false;

    } else {
      
      return true;

    }



  }

  public function seedApiData($api_result)
  {

    if (count($api_result) > 0) {

      $property_types = array();

      foreach ($api_result as $property) {

        $params = array(
          ":uuid" => $property['uuid'],
          ":property_type_id" => $property['property_type_id'],
          ":county" => $property['county'],
          ":country" => $property['country'],
          ":town" => $property['town'],
          ":description" => $property['description'],
          ":address" => $property['address'],
          ":image_full" => $property['image_full'],
          ":image_thumbnail" => $property['image_thumbnail'],
          ":latitude" => $property['latitude'],
          ":longitude" => $property['longitude'],
          ":num_bedrooms" => $property['num_bedrooms'],
          ":num_bathrooms" => $property['num_bathrooms'],
          ":price" => $property['price'],
          ":type" => $property['type'],
          ":created_at" => $property['created_at'],
          ":updated_at" => $property['updated_at']
        );

        $this->db->query("
          INSERT INTO properties (
            uuid, property_type_id, county, country, 
            town, description, address, image_full, 
            image_thumbnail, latitude, longitude, 
            num_bedrooms, num_bathrooms, price, 
            type, created_at, updated_at
          ) 
          VALUES 
            (
              :uuid, :property_type_id, :county, 
              :country, :town, :description, :address, 
              :image_full, :image_thumbnail, :latitude, 
              :longitude, :num_bedrooms, :num_bathrooms, 
              :price, :type, :created_at, :updated_at
            )
          ", $params);

        if (!empty($property['property_type'] && is_array($property['property_type']))) {

          $property_types[] = $property['property_type'];
        }
      }

      if (count($property_types) > 0) {

        array_unique($property_types, SORT_REGULAR);

        foreach ($property_types as $property_type_details) {

          $params_property_type = array(
            ":id" => $property_type_details['id'],
            ":title" => $property_type_details['title'],
            ":description" => $property_type_details['description'],
            ":created_at" => $property_type_details['created_at'],
            ":updated_at" => $property_type_details['updated_at']
          );

          $this->db->query("INSERT INTO property_type (id, title, description, created_at, updated_at) VALUES (:id, :title, :description, :created_at, :updated_at)", $params_property_type);
        }
      }

      return true;
      
    } else {

      return false;

    }
  }

  public function updateData($api_data = array())
  {

    $update_count = 0;
    $insert_count = 0;

    if (is_array($api_data) && count($api_data) > 0) {

      foreach ($api_data as $api_property) {

        $params = array(":uuid" => $api_property['uuid']);

        $result = $this->db->query("SELECT uuid FROM properties WHERE uuid = :uuid", $params);

        $params_update = array(
          ":uuid" => $api_property['uuid'],
          ":property_type_id" => $api_property['property_type_id'],
          ":county" => $api_property['county'],
          ":country" => $api_property['country'],
          ":town" => $api_property['town'],
          ":description" => $api_property['description'],
          ":address" => $api_property['address'],
          ":image_full" => $api_property['image_full'],
          ":image_thumbnail" => $api_property['image_thumbnail'],
          ":latitude" => $api_property['latitude'],
          ":longitude" => $api_property['longitude'],
          ":num_bedrooms" => $api_property['num_bedrooms'],
          ":num_bathrooms" => $api_property['num_bathrooms'],
          ":price" => $api_property['price'],
          ":type" => $api_property['type'],
          ":created_at" => $api_property['created_at'],
          ":updated_at" => $api_property['updated_at']
        );


        if ($result !== false) {

         $query = $this->db->query("
             UPDATE 
               properties
             SET 
               uuid = :uuid,
               property_type_id = :property_type_id,
               county = :county,
               country = :country,
               town = :town,
               description = :description,
               address = :address,
               image_full = :image_full,
               image_thumbnail = :image_thumbnail,
               latitude = :latitude,
               longitude = :longitude,
               num_bedrooms = :num_bedrooms,
               num_bathrooms = :num_bathrooms,
               price = :price,
               type = :type,
               created_at = :created_at,
               updated_at = :updated_at
             WHERE uuid = :uuid  
          ", $params_update);

          if($query !== false) {


          } else {

            $update_count++;

          }

        } else {

          // unset($params_update[':uuidtwo']);

         $query = $this->db->query("
          INSERT INTO properties (
            uuid, property_type_id, county, country, 
            town, description, address, image_full, 
            image_thumbnail, latitude, longitude, 
            num_bedrooms, num_bathrooms, price, 
            type, created_at, updated_at
          ) 
          VALUES 
            (
              :uuid, :property_type_id, :county, 
              :country, :town, :description, :address, 
              :image_full, :image_thumbnail, :latitude, 
              :longitude, :num_bedrooms, :num_bathrooms, 
              :price, :type, :created_at, :updated_at
            )
          ", $params_update);

          if($query !== false) {

              $insert_count++;

          }

        }
      }
    }

    $result_string = $update_count.' rows updated<br>'.$insert_count.' rows created';

    return $result_string;

  }
}



?>