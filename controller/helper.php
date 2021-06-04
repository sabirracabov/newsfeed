<?php
    include_once('API.php');


class helper {


    private $category_list = array(
        1 => "general",
        2 => "business",
        3 => "science",
        4 => "technology",
        5 => "entertainment",
        6 => "health",
        7 => "sports"
      );
    
      private $categories = array( 
        "general", 
        "business", 
        "science", 
        "technology",
        "entertainment",
        "health",
        "sports"
      );

    public function shuffle($quantity){
        $category_id = array_rand($this->category_list, $quantity);
        $category = $this->category_list[$category_id];
        return $category;
    }

    public function checkCategory($category){
        $category = strtolower($category);
        if (in_array($category, $this->categories, true)) {
            return true;
        } else {
            return false;
        }
    }

    
    public function checkCountOfNews($json,$id){
        if(count($json) <= $id){
            return false;
        } else {
            return true;
        }
    }

    //get all json files at once about 1 hours
    public function getAll(){
        $api = new API();

        
        foreach($this->category_list as $category){
            $json_list[$category] = $api->getAllCategories($category);
        }

        return  $json_list;


    }


    //filter json data with categories
    public function getAllFiltered($json_list,$category){
        return $json_list[$category];
    }

    public function getElements($json,$id,$element){
	
        return $json["articles"][$id][$element];
    }
    
    public function getElementsArticle($json,$article,$id,$element){
        return $json[$article][$id][$element];
    }

    public function getCategories(){
        return $this->categories;
    }






}