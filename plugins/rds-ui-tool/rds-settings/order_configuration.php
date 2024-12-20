<?php             
            $array = rds_template();
    
            
            $order = $array['globals'];
            $page_order = $array['page_templates']['homepage'];
            if (isset($_POST['order_configuration']) && isset($_POST['rdsorderconfignonce']) && wp_verify_nonce($_POST['rdsorderconfignonce'], 'rdsorderconfignonce')) {
                $array['globals']['services']['order'] = $_POST['services_order'];
                $array['globals']['promotion']['order'] = $_POST['promotion_order'];
                $array['globals']['discover_the_difference']['order'] = $_POST['discover_the_difference_order'];
                $array['globals']['request_service']['order'] = $_POST['request_service_order'];
                $array['globals']['company_services']['order'] = $_POST['company_services_order'];
                $array['globals']['service_area']['order'] = $_POST['service_area_order'];
                $array['globals']['financing']['order'] = $_POST['financing_order'];
                $array['globals']['affiliation']['order'] = $_POST['affiliation_order'];
                $array['globals']['testimonial']['order'] = $_POST['testimonial_order'];
                $array['page_templates']['homepage']['seo_section']['order'] = $_POST['seo_section_order'];
                $array['page_templates']['homepage']['we_are_hiring']['order'] = $_POST['we_are_hiring_order'];
                $update = rds_update_template_option_add_mongo_log($array);
                //Set session Name
                 $_SESSION["order_config"] = "order_config";

                // if ($update) {

                    wp_redirect(admin_url("admin.php?page=rds-ui-tool&tab=order"));
                    exit();
                // }


            }
           
             $status = isset($_SESSION["order_config"]) ? $_SESSION["order_config"] : '';
            if ($status == 'order_config') {

                echo "<h5 style='color: green;'>Order Configuration  Updated </h5>";
                unset($_SESSION["order_config"]);
            }
            ?>
            <form method='post' action='<?= $_SERVER['REQUEST_URI']; ?>'  enctype=''>
                <input type="hidden" name="rdsorderconfignonce" value="<?= wp_create_nonce('rdsorderconfignonce') ?>" >
                <div class="container mt-3 order-drag " id="mylist">
                   
                    
                    <div class="row class-row  p-2" data-sort="<?= $order['testimonial']['order'] ?>">
                        <div class="col-3 p-2 text-center" style="    border: 1px solid #a18686;" ><label >Testimonial Section </label></div>
                        <div class="col-4" >
                            <input type="text"  class="form-control d-none" value="<?= $order['testimonial']['order'] ?>" placeholder="Enter Testimonial Order " name="testimonial_order">
                        </div>
                       </div>
                     <div class="row class-row  p-2" data-sort="<?= $order['services']['order'] ?>" >
                        <div class="col-3 p-2 text-center" style="    border: 1px solid #a18686;"><label >Service Block Section </label></div>
                        <div class="col-4" >
                            <input type="text"  class="form-control d-none" value="<?= $order['services']['order'] ?>" placeholder="Enter Service Block Order " name="services_order">
                        </div>
                       </div>
                    <div class="row class-row  p-2" data-sort="<?= $order['promotion']['order'] ?>">
                        <div class="col-3 p-2 text-center" style="    border: 1px solid #a18686;" ><label >Promotion Section </label></div>
                        <div class="col-4" >
                            <input type="text"  class="form-control d-none" value="<?= $order['promotion']['order'] ?>" placeholder="Enter Promotion Order " name="promotion_order">
                        </div>
                       </div>
                    
                    <div class="row class-row  p-2" data-sort="<?= $order['discover_the_difference']['order'] ?>">
                        <div class="col-3 p-2 text-center" style="    border: 1px solid #a18686;" ><label >Discover The Difference Section </label></div>
                        <div class="col-4" >
                            <input type="text"  class="form-control d-none" value="<?= $order['discover_the_difference']['order'] ?>" placeholder="Enter Discover The Difference Order " name="discover_the_difference_order">
                        </div>
                       </div>
                    
                    <div class="row class-row  p-2" data-sort="<?= $order['request_service']['order'] ?>">
                        <div class="col-3 p-2 text-center" style="    border: 1px solid #a18686;" ><label >Request Service Section </label></div>
                        <div class="col-4" >
                            <input type="text"  class="form-control d-none" value="<?= $order['request_service']['order'] ?>" placeholder="Enter Request Service Order " name="request_service_order">
                        </div>
                       </div>
                    
                    <div class="row class-row  p-2" data-sort="<?= $order['company_services']['order'] ?>">
                        <div class="col-3 p-2 text-center" style="    border: 1px solid #a18686;" ><label >Company Services Section </label></div>
                        <div class="col-4" >
                            <input type="text"  class="form-control d-none" value="<?= $order['company_services']['order'] ?>" placeholder="Enter Company Services " name="company_services_order">
                        </div>
                       </div>
                    
                    <div class="row class-row  p-2" data-sort="<?= $order['service_area']['order'] ?>">
                        <div class="col-3 p-2 text-center" style="    border: 1px solid #a18686;" ><label >Proudly Serving Section </label></div>
                        <div class="col-4" >
                            <input type="text"  class="form-control d-none" value="<?= $order['service_area']['order'] ?>" placeholder="Enter Proudly Serving Order " name="service_area_order">
                        </div>
                       </div>
                    
                    <div class="row class-row  p-2" data-sort="<?= $order['financing']['order'] ?>">
                        <div class="col-3 p-2 text-center" style="    border: 1px solid #a18686;" ><label >Financing Section </label></div>
                        <div class="col-4" >
                            <input type="text"  class="form-control d-none" value="<?= $order['financing']['order'] ?>" placeholder="Enter Financing Order " name="financing_order">
                        </div>
                       </div>
                    
                    <div class="row class-row  p-2" data-sort="<?= $order['affiliation']['order'] ?>">
                        <div class="col-3 p-2 text-center" style="    border: 1px solid #a18686;" ><label >Affiliation Section </label></div>
                        <div class="col-4" >
                            <input type="text"  class="form-control d-none" value="<?= $order['affiliation']['order'] ?>" placeholder="Enter Affiliation Order " name="affiliation_order">
                        </div>
                       </div>

                       <div class="row class-row  p-2 " data-sort="<?= $page_order['seo_section']['order'] ?>">
                        <div class="col-3 p-2 text-center" style="    border: 1px solid #a18686;" ><label >SEO Section </label></div>
                        <div class="col-4" >
                            <input type="text"  class="form-control d-none" value="<?= $page_order['seo_section']['order'] ?>" placeholder="Enter SEO Order " name="seo_section_order">
                        </div>
                       </div>

                       <div class="row class-row  p-2 " data-sort="<?= $page_order['we_are_hiring']['order'] ?>">
                        <div class="col-3 p-2 text-center" style="    border: 1px solid #a18686;" ><label >WE ARE Hiring Section </label></div>
                        <div class="col-4" >
                            <input type="text"  class="form-control d-none" value="<?= $page_order['we_are_hiring']['order'] ?>" placeholder="Enter WE ARE Hiring Order " name="we_are_hiring_order">
                        </div>
                       </div>
                    
                <div class="row class-row" data-sort="13">
                     <div class="col-3" >
                    <button type="button" style="display:none;" class="save-first btn btn-primary mt-3">disabledSave changes</button><button type="submit" class="save-change btn btn-primary mt-3" name="order_configuration">Save changes</button> 
                </div>
                </div>
                    </div> 
            </form>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
            <script type="text/javascript">
                    $(document).ready(function(){   
                $(".order-drag").sortable({      
                    update: function( event, ui ) {
                        updateOrder();
                    }
                });  
                var result = $('.class-row').sort(function (a, b) {

                var contentA =parseInt( $(a).data('sort'));
                var contentB =parseInt( $(b).data('sort'));
                return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
            });

            $('#mylist').html(result);
            });
        function updateOrder() {    
            var item_order = {};
            $('.order-drag .row').each(function() {
                var val  = $(this).index();
                var name =  $(this).find("input:text").attr('name');
                item_order[name] = val + 2;
            });
            var order_string = item_order;

        $.each(order_string, function (key, val) {
            console.log(key );
            console.log(val );
            $('input[name="'+key+'"]').val(val);
        });
        }
        </script>
  