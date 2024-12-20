<?php 
            $array = rds_template();
            $footer = $array['globals']['footer'];
            
            $status = isset($_SESSION['footer_config']) ? $_SESSION['footer_config'] : '';
            if ($status === 'footer_config') {
                echo "<h5 style='color: green;'>Footer Configuration  Updated </h5>";
                // destroy session
                unset($_SESSION['footer_config']);
            }
            ?>
            <form method='post' action='<?php echo admin_url('admin-post.php'); ?>' enctype=''>
                <input type="hidden" name="action" value="rds_footer_configuration">
                <input type="hidden" name="rdsfooterconfigNonce"   value="<?= wp_create_nonce('rdsfooterconfigNonce') ?>"/>
                <div class="container mt-3">
                    <div class="row">
                        <div class="col-3"><label>Select Variation</label></div>
                        <div class="col-4">
                            <select  class="form-select " id="rds-footer-variation" value="<?= $footer['variation']; ?>" name="footer_variation">
                                <option value="a" <?php if ($footer['variation'] == 'a') echo 'selected'; ?>>A</option>
                                                           </select>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-3"><label>Heading </label></div>
                        <div class="col-4">
                            <input type="text" class="form-control" placeholder="Enter Heading text" value="<?= $footer['heading']; ?>" name="footer_heading">
                        </div>
                    </div>
                    <div class="container-add-more">
                        <?php foreach ($footer['data']['social_media']['items'] as $item) {
                            ?>
                            <div class="after-add-more mt-4">  
                                <div class="row">
                                    <div class="col-3"><label>Social Media Icon Class</label></div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" placeholder="Enter Icon Class" value="<?= $item['icon_class']; ?>"  name="footer_social_icon_class[]">
                                    </div>
                                </div>
                                <br/> 
                                <div class="row">
                                    <div class="col-3"><label>Social Media Order</label></div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" placeholder="Enter Icon Order" value="<?= $item['order']; ?>" name="footer_social_icon_order[]">
                                    </div>
                                </div>
                                <br/>    
                                <div class="row">
                                    <div class="col-3"><label>Social Media URL</label></div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" placeholder="Enter URL" value="<?= $item['url']; ?>" name="footer_social_url[]">
                                    </div>
                                    <div class="col-3 change">
                                        <button type="button" class="btn btn-danger remove" >- Remove</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row add-change-btn">
                            <div class="col-3 change float-right">
                                <button type="button" class="btn btn-info add-more" >+ Add More Social Media</button>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row rds_footer_menu_options">
                        <div class="col-3"><label>Menu 1 Name </label></div>
                        <div class="col-4">
                            <input type="text" class="form-control" value="<?= $footer['data']['footer_menu_1_name']; ?>" placeholder="" name="footer_menu_1_name">
                        </div>
                    </div>
                    <br class="br-d-none" />
                    <div class="row rds_footer_menu_options">
                        <div class="col-3"><label>Menu 1 Heading </label></div>
                        <div class="col-4">
                            <input type="text" class="form-control" placeholder="" value="<?= $footer['data']['footer_menu_1_heading']; ?>" name="footer_menu_1_heading">
                        </div>
                    </div>
                    <br class="br-d-none" />
                    <div class="row rds_footer_menu_options">
                        <div class="col-3"><label>Menu 2 Name </label></div>
                        <div class="col-4">
                            <input type="text" class="form-control" placeholder="" value="<?= $footer['data']['footer_menu_2_name']; ?>" name="footer_menu_2_name">
                        </div>
                    </div>
                    <br class="br-d-none"/>
                    <div class="row rds_footer_menu_options">
                        <div class="col-3"><label>Menu 2 Heading </label></div>
                        <div class="col-4">
                            <input type="text" class="form-control" placeholder="" value="<?= $footer['data']['footer_menu_2_heading']; ?>" name="footer_menu_2_heading">
                        </div>
                    </div>
                    <br class="br-d-none" />
                    <div class="row">
                        <div class="col-3"><label>Disclaimer Text </label></div>
                        <div class="col-3"> 
                            <textarea rows="6" cols="70" value="<?= $footer['data']['disclaimer_text']; ?>" name="footer_disclaimer_text"><?= $footer['data']['disclaimer_text']; ?></textarea>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-3"><label>Copyright Title </label></div>
                        <div class="col-4">
                            <input type="text" class="form-control" placeholder="Enter Copyright Title" value="<?= $footer['data']['copyright_title']; ?>" name="footer_copyright_title">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-3"><label>Bluecorona brand </label></div>
                        <div class="col-4">
                            <input type="checkbox" class="form-control" placeholder="Enter Copyright Title" value="true" name="footer_bluecorona_brand" <?= $footer['data']['bluecorona_branding'] ? "checked" : "uncheked"; ?>>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-3"><label>Privacy Policy link </label></div>
                        <div class="col-4">
                            <input type="text" class="form-control" placeholder="Enter Privacy Policy link" value="<?= $footer['data']['privacy_policy_link']; ?>" name="footer_privacy_policy">
                        </div>
                    </div>
                    <button type="button" style="display:none;" class="save-first btn btn-primary mt-3" disabled>Save changes</button><button type="submit" class="save-change btn btn-primary mt-3" name="footer_configuration">Save changes</button>
                </div>  
            </form>
      