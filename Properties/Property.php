<?php

// interface PropertyInterface 
// {

//    public 

// }

// require 'Config/Db.php';

// require 'PropertyType.php';

class Property
{
  protected $db;
  public $id;
  public $uuid;
  public $property_type_id;
  public $county;
  public $country;
  public $town;
  public $price;
  public $postcode = '';
  public $description;
  public $address;
  public $image_full;
  public $image_thumbnail;
  public $num_bedrooms;
  public $num_bathrooms;
  public $type;
  public $property_type;

  public function __construct($property_id)
  {
    $this->db = Db::getInstance();
    $property_info = $this->getPropertyInformation($property_id);

    //   var_dump($property_info);

    if ($property_info !== false) {

      $this->id = $property_info[0]['id'];
      $this->uuid = $property_info[0]['uuid'];
      $this->property_type_id = $property_info[0]['property_type_id'];
      $this->county = $property_info[0]['county'];
      $this->country = $property_info[0]['country'];
      $this->town = $property_info[0]['town'];
      $this->description =  $property_info[0]['description'];
      $this->address = $property_info[0]['address'];
      $this->price = $property_info[0]['price'];
      $this->image_full = $property_info[0]['image_full'];
      $this->image_thumbnail = $property_info[0]['image_thumbnail'];
      $this->num_bedrooms = $property_info[0]['num_bedrooms'];
      $this->num_bathrooms = $property_info[0]['num_bathrooms'];
      $this->type = $property_info[0]['type'];
      $this->property_type = $this->getPropertyTypeInformation($this->property_type_id);
      $postcode = $this->getPropertyPostcode($this->id);

      if($postcode !== null) {

        $this->postcode = $postcode[0]['postcode'];

      }

    }
  }

  public static function getAllProperties()
  {

    $properties = array();

    $database = Db::getInstance();

    $result = $database->query("SELECT id FROM properties");

    if ($result !== false) {

      foreach ($result as $property) {

        $pro_obj = new Property($property['id']);
        $properties[$property['id']] = $pro_obj;
      }

      return $properties;

    } else {

      return false;
    }

  }

  private function getPropertyInformation($property_id = 0)
  {

    if ($property_id > 0) {

      $param = array(":id" => $property_id);

      $property_info = $this->db->query("SELECT * FROM properties WHERE properties.id = :id", $param);

      if ($property_info !== false) {

        return $property_info;
      } else {

        return false;
      }
    }
  }

 private function getPropertyTypeInformation($property_type_id)
 {

    return new PropertyType($property_type_id);

 }

 public function getPropertyPostcode($id)
 {
     $param = array(":id" => $id);

     $result = $this->db->query("SELECT property_id, postcode FROM property_postcode WHERE property_id = :id", $param);

     if($result !== false) 
     {
      
         return $result;

     } else {

         return null;
         
     }

 }


}

class PropertyType
{

    private $db;
    public $property_type_id;
    public $property_type_title;
    public $property_type_description;

    public function __construct($id)
    {

        $this->db = Db::getInstance();
        $property_type_info = $this->getPropertyTypeInformation($id);
        $this->property_type_id = $property_type_info[0]['id'];
        $this->property_type_title = $property_type_info[0]['title'];
        $this->property_type_description = $property_type_info[0]['description'];
        
    }

    public function getPropertyTypeInformation($id)
    {
        $param = array(":id" => $id);

        $result = $this->db->query("SELECT id, title, description FROM property_type WHERE id = :id", $param);

        if($result !== false) 
        {
         
            return $result;

        } else {

            return false;
            
        }

    }


}
