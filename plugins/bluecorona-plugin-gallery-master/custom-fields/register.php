<?php
function bc_gallery_create_metabox() {
    add_meta_box(
        'bc_gallery_metabox',
        'Album',
        'bc_gallery_metabox',
        'bc_galleries',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'bc_gallery_create_metabox' );

function bc_gallery_metabox() {
global $post; // Get the current post data
$name = get_post_meta( $post->ID, 'album_title', true );
//$spaceremodeled = get_post_meta( $post->ID, 'album_spaceremodeled', true );
//$style = get_post_meta( $post->ID, 'album_style', true );
//$price = get_post_meta( $post->ID, 'album_price', true );
$problem = get_post_meta( $post->ID, 'album_problem', true );
$solution = get_post_meta( $post->ID, 'album_solution', true );
$location = get_post_meta( $post->ID, 'album_location', true );
$image = get_post_meta( $post->ID, 'gallery_images', true );
$isprojectgallery = get_post_meta( $post->ID, 'album_isprojectgallery', true );
$defaultcheck = get_post($post->ID );
$about_project = get_post_meta( $post->ID, 'bc_about_project', true );
?>
<style type="text/css">
    #postdivrich{
        display: none;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
<script src="<?php echo plugin_dir_url(__FILE__)."../assests/js/sortable.min.js" ?>"></script>
<div class="container-fluid" ng-app="galleryApp" ng-cloak>
    <div class="container" ng-controller="GalleryController">
      <div class="form-group row">
        <h2 class="col-sm-2 col-form-label font-weight-bold">Album Title</h2>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="album_title" id="album_title" value="<?= $name?>" required>
          <input type="hidden" name="gallery_images" id="images" value="">
        </div>
      </div>
       
      <div class="form-group row multi-upload">
        <h2 class="col-12 col-form-label font-weight-bold">Image Upload</h2>
        <div class="col-12 images_list" ui-sortable ng-model="images" ui-sortable-stop="updateImages()">
            <div class="row p-2 border border-1" ng-repeat="imageObj in images track by $index">
                <div class="col-12 mb-3"><span class="dashicons dashicons-move"></span></div>
                <div class="col-1">Thumbnail</div>
                <div class="col-4">
                    <input type="text" ng-disabled="true" name="gallery_custom_image_{{$index}}" id="gallery_custom_image_{{$index}}" class="meta-image w-100" ng-model="imageObj['image']" required accept='image/*'>
                </div>
                <div class="col-2">
                    <input type="button" class="button btn w-100" ng-click="uploadImage($index, imageObj, 'image')" value="Upload" >
                </div>
                <div class="image-preview col-3 text-center">
                    <img ng-src="{{imagePreview(imageObj, 'image')}}" style="max-width:70px;max-height:70px;">
                </div>
                <div class="col-2 text-right">
                    <a class="remove_image btn btn-danger px-3 w-100" ng-click="removeImage($index)"><span class="py-1 text-white font-weight-bold">Remove</span></a>
                </div>
                <div class="col-12 my-2"></div>
                <div class="col-1">Lightbox</div>
                <div class="col-4">
                    <input type="text" ng-disabled="true" name="gallery_thumbnail_image_{{$index}}" id="gallery_thumbnail_image_{{$index}}" class="meta-image w-100" ng-model="imageObj['thumbnail']" required accept='image/*'>
                </div>
                <div class="col-2">
                    <input type="button" class="button btn w-100" ng-click="uploadImage($index, imageObj, 'thumbnail')" value="Upload" >
                </div>
                <div class="image-preview col-3 text-center">
                    <img ng-src="{{imagePreview(imageObj, 'thumbnail')}}" style="max-width:70px;max-height:70px;">
                </div>
            </div>
        </div>
        <div class="col-12 pt-2">
            <div class="row justify-content-end">
                <div class="col-2 text-right">
                    <a class="add_image btn btn-success px-2 w-100" ng-click="addImage()"><span class="py-1 text-white font-weight-bold">Add New</span></a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- <div class="form-group row">
        <h2 class="col-sm-2 col-form-label font-weight-bold">Space Remodeled</h2>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="album_spaceremodeled" id="album_spaceremodeled" value="<?= $spaceremodeled;?>" required>
        </div>
    </div> -->
    <!-- <div class="form-group row">
        <h2 class="col-sm-2 col-form-label font-weight-bold">Style</h2>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="album_style" id="album_style" value="<?= $style;?>" required>
        </div>
    </div> -->
   <!--  <div class="form-group row">
        <h2 class="col-sm-2 col-form-label font-weight-bold">Price</h2>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="album_price" id="album_price" value="<?= $price;?>" required>
        </div>
    </div> -->

        <div class="form-group row">
            <h2 class="col-sm-2 col-form-label font-weight-bold">Album Slider Show</h2>
            <div class="col-sm-10">
                <input type="checkbox" name="gallery_isprojectgallery_metabox" id="gallery_isprojectgallery_metabox" class="form-control" value="1" <?php echo ((($isprojectgallery) == 1)?"checked":"") ?>
                <?php echo ((($defaultcheck->post_status) == 'auto-draft')?"checked":"") ?> />
            </div>
        </div>
        <div class="form-group row">
            <h2 class="col-sm-2 col-form-label font-weight-bold">About This Project</h2>
            <div class="col-sm-10">
                <!-- <input type="text" class="form-control" name="album_price" id="album_price" value="<?= $price;?>" required> -->
                <textarea class="form-control" rows="6" cols="85" name="bc_about_project" id="bc_about_project"><?= $about_project;?></textarea>
            </div>
        </div>
</div>

<script type="text/javascript">
var galleryApp = angular.module('galleryApp', ['ui.sortable']);
var images = '<?= $image ?>';

  // Defining the `GalleryController` controller on the `galleryApp` module
  galleryApp.controller('GalleryController', function GalleryController($scope, $window) {
    var images = $window.images;
    try{
        images = JSON.parse(images);
        if(images.length > 0 && typeof images[0]=="string"){
            images = images.map(function(value){
                return {"image": value, thumbnail:""}
            });
        }
    }catch(e){
        images= [];
    }
    $scope.images = images;
    $scope.updateImages= function(){
        jQuery("#images").val(JSON.stringify($scope.images));
    }
    $scope.addImage = function(){
        $scope.images.push({"image":"", "thumbnail":""});
        $scope.updateImages();
    }
    $scope.removeImage = function(index){
        $scope.images.splice(index,1);
        $scope.updateImages();
    }
    $scope.imagePreview = function(imageObj, image_type){
        if(imageObj[image_type].length > 0){
            return imageObj[image_type];
        }
        return 'http://placehold.it/70x70';
    }


    $scope.uploadImage = function(index, image, image_type){
        if(typeof image_type =="undefined"){
           image_type = "image";
        }
        var meta_image_frame;
        
        if (meta_image_frame) {
          meta_image_frame.close();
          // return;
        }
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
          title: "Add Album Image",
          button: {
            text: "Add Image"
          }
        });
        // Runs when an image is selected.
        meta_image_frame.on('select', function () {
          // Grabs the attachment selection and creates a JSON representation of the model.
          var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
          // Sends the attachment URL to our custom image input field.
          $scope.images[index][image_type] = media_attachment.url;
          
          $scope.$digest();
          $scope.updateImages();
        });
        // Opens the media library frame.
        meta_image_frame.open();
    }
    if(!$scope.images.length){
        $scope.addImage();
    }
    $scope.updateImages();
  });
</script>
<?php
    wp_nonce_field( 'bc_gallery_form_metabox_nonce', 'bc_gallery_form_metabox_process' );
}
function bc_gallery_save_metabox( $post_id, $post ) {
    if ( !isset( $_POST['bc_gallery_form_metabox_process'] ) ) return;
    if ( !wp_verify_nonce( $_POST['bc_gallery_form_metabox_process'], 'bc_gallery_form_metabox_nonce' ) ) {
        return $post->ID;
    }
    if ( !current_user_can( 'edit_post', $post->ID )) {
        return $post->ID;
    }
    if ( !isset( $_POST['album_title'] ) ) {
        return $post->ID;
    }
    if ( !isset( $_POST['gallery_images'] ) ) {
        return $post->ID;
    }
    // if ( !isset( $_POST['album_spaceremodeled'] ) ) {
    //     return $post->ID;
    // }
    // if ( !isset( $_POST['album_style'] ) ) {
    //     return $post->ID;
    // }
    // if ( !isset( $_POST['album_price'] ) ) {
    //     return $post->ID;
    // }
    if ( !isset( $_POST['bc_about_project'] ) ) {
        return $post->ID;
    }
    
    
    $sanitizedname = wp_filter_post_kses( $_POST['album_title'] );
    // $sanitizedspaceremodeled = wp_filter_post_kses( $_POST['album_spaceremodeled'] );
   //$sanitizedstyle = wp_filter_post_kses( $_POST['album_style'] );
   // $sanitizedprice = wp_filter_post_kses( $_POST['album_price'] );
    $sanitizedbaboutproject = $_POST['bc_about_project'];
    $sanitizedcustomimage = wp_filter_post_kses( $_POST['gallery_images'] );
    $sanitizedisprojectgallery = false;
    if(isset($_POST['gallery_isprojectgallery_metabox'])){
     $sanitizedisprojectgallery = wp_filter_post_kses( strip_tags($_POST['gallery_isprojectgallery_metabox']) );
    }
    if (empty($sanitizedisprojectgallery )) {
        $sanitizedisprojectgallery = 0;
    }else{
        $sanitizedisprojectgallery = 1;
    }

    update_post_meta( $post->ID, 'album_isprojectgallery', $sanitizedisprojectgallery );
    update_post_meta( $post->ID, 'album_title', $sanitizedname );
    // update_post_meta( $post->ID, 'album_spaceremodeled', $sanitizedspaceremodeled );
    //update_post_meta( $post->ID, 'album_style', $sanitizedstyle );
    update_post_meta( $post->ID, 'album_price', $sanitizedprice );
    update_post_meta( $post->ID, 'bc_about_project', $sanitizedbaboutproject );

    update_post_meta( $post->ID, 'gallery_images', $sanitizedcustomimage );
    remove_action( 'save_post', 'bc_gallery_save_metabox', 1, 2  );
    $data = bc_update_gallery_content($post->ID);
    wp_update_post($data ,true);
    add_action( 'save_post', 'bc_gallery_save_metabox', 1, 2  );

}

function bc_update_gallery_content($id){
    
 $images = get_post_meta( $id, 'gallery_images', true );
    $images = (json_decode($images));
    $galleryContent = '';
    $count =0;
    foreach($images as $galleryImage){
      // $get_image_id = attachment_url_to_postid($galleryImage->image);
      // $alt = get_post_meta ( $get_image_id, '_wp_attachment_image_alt', true );
       $count++;
       $galleryContent .= '<div class="col-md-6 col-lg-4 lightbox">
         <a class="d-block" data-toggle="modal" data-target="#myModal_mobile" href="javascript:void(0);">
            <div class="gallery position-relative card border overflow-hidden">      
               <input type="hidden" class="thumbnail" value="'.$galleryImage->thumbnail.'">
               <img class="m-auto d-block img-size" src="'.$galleryImage->image.'" alt="alt">
               <div class="overlay card-img-overlay text-center d-flex text position-absolute">
                  <h5 class="text-white m-auto"><i class="fa fa-magnifying-glass2 bc_text_44 bc_line_height_36"></i></h5>
               </div>
            </div>
         </a>
      </div>';

    if($count%9 == 0){
         $galleryContent .= '<!--nextpage-->
         ';
    }
    }
    $galleryContent = [
        'ID' => $id,
        'post_content' => $galleryContent
    ];

    return $galleryContent;
    
    

}


add_action( 'save_post', 'bc_gallery_save_metabox', 1, 2 );

// Change Title on insert and update of location title
add_filter('wp_insert_post_data', 'bc_gallery_change_title');
function bc_gallery_change_title($data){
    if($data['post_type'] != 'bc_galleries'){
        return $data;
    }
    if ( !isset( $_POST['album_title'] ) ) {
        return $data;
    }
    //$data['post_title'] = $_POST['album_title'];
    return $data;
}