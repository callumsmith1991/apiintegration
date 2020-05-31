<?php


// require 'Seeder.php';


class CreateTables {

    private $db;


    public function __construct()
    {
        $this->db = Db::getInstance();
    }


    public function create()
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

}




?>