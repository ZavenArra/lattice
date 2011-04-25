<?

Class Ratings_Controller extends Controller {

   protected $objectTable = null;

   private function getObjectTypeId(){
      $ratingsObjectType = ORM::Factory('ratingsobjecttype')->where('table', '=', $this->objectTable )->find();
      if(!$ratedObjectType->loaded()){
         $ratingsObjectType = ORM::Factory('ratingsobjecttype');
         $ratingsObjectType->table = $this->objectTable;
         $ratingsObjectType->save();
      }
      return $ratingsObjectType->id;
      
   }
   
   public function action_storeRating($object_id, $rating) {
      
      
      $rating = ORM::Factory('rating');
      $rating->object_id = $object_id;
      $rating->rating = $rating;
      $rating->object_type_id = $this->getObjectTypeId();
      $rating->save();
      
   }

   public function action_getAverageRating($id) {
      $ratings = ORM::Factory('rating')
              ->where('object_id', '=', $id)
              ->where('object_type_id', '=', $this->getObjectTypeId())
              ->find_all();
      $average = 0;
      foreach ($ratings as $rating) {
         $average += $rating->rating;
      }
      $average = $average / count($ratings);
      $this->response->data(array('averageRating'=>$average));
      
   }

}