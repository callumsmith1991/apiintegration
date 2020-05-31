

<?php

// require 'Property.php';

// class PropertyType extends Property
// {

//     public $property_type_id;
//     public $property_type_title;
//     public $property_type_description;

//     public function __construct($id)
//     {

//         $property_type_info = $this->getPropertyTypeInformation($id);
//         $this->property_type_id = $property_type_info['id'];
//         $this->property_type_title = $property_type_info['title'];
//         $this->property_type_description = $property_type_info['description'];
        
//     }

//     public function getPropertyTypeInformation($id)
//     {
//         $param = array(":id" => $id);

//         $result = $this->db->query("SELECT id, title, description FROM property_type WHERE id = :id", $param);

//         if($result !== false) 
//         {
         
//             return $result;

//         } else {

//             return false;
            
//         }

//     }


// }



?>