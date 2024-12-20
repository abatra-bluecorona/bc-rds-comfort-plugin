<?php
    $array = rds_template();
    $header = $array['globals'];
    $status = isset($_SESSION['header_config']) ? $_SESSION['header_config'] : '';
    if ($status === 'header_config') {
        echo "<h5 style='color: green;'>Header Configuration  Updated </h5>";
        // for a single variable
        unset($_SESSION['header_config']);
    }
    ?>
    <form method='post' action='<?php echo admin_url('admin-post.php'); ?>' enctype=''>
        <input type="hidden" name="action" value="rds_header_configuration">
        <input type="hidden" name="rdsheaderconfigNonce" value="<?= wp_create_nonce('rdsheaderconfigNonce') ?>"/>
        <div class="container mt-3 rds-container-header">
            <div class="row">
                <div class="col-3"><label>Select Variation</label></div>
                <div class="col-4">
                    <select  class="form-select rds-select-variation" id="" name="header_variation">
                        <option value="a" <?php if ($header['header']['variation'] == 'a') echo 'selected'; ?>>A</option>
                        <option value="b" <?php if ($header['header']['variation'] == 'b') echo 'selected'; ?>>B</option>
                        <option value="c" <?php if ($header['header']['variation'] == 'c') echo 'selected'; ?>>C</option>
                    </select>
                </div>
            </div>
            <br/>
            <div class="container-for-select-variation">
                <div class="row">
                    <div class="col-5" ><h5 id="main_header_text">Main Header</h5></div>
                </div>
                <br/>
                <div class="row" id="call_text">
                    <div class="col-3"><label>Call Text</label></div>
                    <div class="col-4">
                        <input type="text" name="header_call_text" value="<?php echo $header['header']['call_text']; ?>" class="form-control" placeholder="Call text">
                    </div>
                </div>
                <br/> 
                <div class="container-for-select-option">
                    <div class="row">
                        <div class="col-3"><label>Desktop Schedule Online Button Type Dropdown</label></div>
                        <div class="col-4">
                            <select  class="form-select rds-select-option" id="" name="header_d_schedule_online_btn_type">
                                <option value="service_titan" <?php if ($header['desktop_schedule_online_button']['type'] == 'service_titan') echo 'selected'; ?>>Service Titan</option>
                                <option value="schedule_online" <?php if ($header['desktop_schedule_online_button']['type'] == 'schedule_online') echo 'selected'; ?>>Schedule Online</option>
                                <option value="url" <?php if ($header['desktop_schedule_online_button']['type'] == 'url') echo 'selected'; ?>>URL</option>
                            </select>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-3"><label>Desktop Button Text</label></div>
                        <div class="col-4">
                            <input type="text" name="header_d_btn_label" value="<?php echo $header['desktop_schedule_online_button']['label']; ?>" class="form-control" placeholder="Enter Desktop Button Text" >
                        </div>
                    </div>
                    <br/>    
                    <div class="row">
                        <div class="col-3"><label>Desktop Button Icon Class</label></div>
                        <div class="col-4">
                            <input type="text" class="form-control" name="header_d_btn_class" placeholder="Enter Desktop Button Icon Class" value="<?php echo $header['desktop_schedule_online_button']['icon_class']; ?>">
                        </div>
                    </div>
                    <br/>    
                    <div class="row rds-select-url">
                        <div class="col-3"><label>Desktop Button URL</label></div>
                        <div class="col-4">
                            <input type="text" class="form-control" name="header_d_btn_url" placeholder="Enter Desktop Button url" value="<?php echo $header['desktop_schedule_online_button']['url']; ?>">
                        </div>
                    </div>
                </div>
                <br/>
                <div id=""> 
                <div class="row">
                    <div class="col-5"><h5>Mobile Header</h5></div>
                </div>
                <br/>
                <div class="container-for-select-option">
                    <div class="row">
                        <div class="col-3"><label> Mobile Schedule Online Button Type Dropdown</label></div>
                        <div class="col-4">
                            <select  class="form-select rds-select-option" id="" name="header_m_schedule_online_btn_type">
                                <option value="service_titan" <?php if ($header['ctas']['schedule_online']['type'] == 'service_titan') echo 'selected'; ?>>Service Titan</option>
                                <option value="schedule_online" <?php if ($header['ctas']['schedule_online']['type'] == 'schedule_online') echo 'selected'; ?>>Schedule Online</option>
                                <option value="url" <?php if ($header['ctas']['schedule_online']['type'] == 'url') echo 'selected'; ?>>URL</option>
                            </select>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-3"><label>Mobile Button Text</label></div>
                        <div class="col-4">
                            <input type="text" class="form-control" name="header_m_btn_text" placeholder="Enter Mobile Button Text" value="<?php echo $header['ctas']['schedule_online']['label']; ?>">
                        </div>
                    </div>
                    <br/>    
                    <div class="row">
                        <div class="col-3"><label>Mobile Button Icon Class</label></div>
                        <div class="col-4">
                            <input type="text" class="form-control" name="header_m_btn_class" placeholder="Enter Mobile Button Icon Class" value="<?php echo $header['ctas']['schedule_online']['icon_class']; ?>">
                        </div>
                    </div>
                    <br/>
                    <div class="row rds-select-url">
                        <div class="col-3"><label>Mobile Button URL</label></div>
                        <div class="col-4">
                            <input type="text" class="form-control" name="header_m_btn_url" placeholder="Enter Mobile Button url" value="<?php echo $header['ctas']['schedule_online']['url']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <br/>   
            <div class="row">
                <div class="col-5"><h5>Announcement Bar (Left Section)</h5></div>
            </div>
            <br/>
            <div class="row">
                <div class="col-3"><label>Icon Class </label></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="header_announcement_left_icon_class" placeholder="Enter Announcement Bar Left Icon Class" value="<?php echo $header['announcement']['left']['icon_class']; ?>" />
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-3"><label>Type </label></div>
                <div class="col-4">
                    <select  class="form-select pt-1 pb-1" id="header_announcement_left_type" name="header_announcement_left_type">
                        <option value="hover" <?php if ($header['announcement']['left']['type'] == 'hover') echo 'selected'; ?>>Hover</option>
                        <option value="link" <?php if ($header['announcement']['left']['type'] == 'link') echo 'selected'; ?>>Link</option>
                    </select>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-3"><label>Title </label></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="header_announcement_left_title" placeholder="Enter Announcement Bar Left Title" value="<?php echo $header['announcement']['left']['title']; ?>" />
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-3"><label>Text </label></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="header_announcement_left_text" placeholder="EnterAnnouncement Bar Left Text" value="<?php echo $header['announcement']['left']['text']; ?>" />
                </div>
            </div>
            <br/>
            <div class="row rds_select_value" id="header_announcement_left_url" >
                <div class="col-3"><label>URL </label></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="header_announcement_left_url" placeholder="Enter Announcement Bar Left URL" value="<?php echo $header['announcement']['left']['url']; ?>" />
                </div>
            </div>
            <div class="row" id="header_announcement_left_tooltip_text">
                <div class="col-3"><label>Tooltip Text </label></div>
                <div class="col-4">
                    <textarea  rows="6" cols="70"  name="header_announcement_left_tooltip_text" placeholder="Enter Announcement Bar Left Tooltip Text"><?php echo $header['announcement']['left']['tooltip_text']; ?></textarea>
                </div>
            </div>
            <br />
            <div id="announcment_bar_middle_content">                    <div class="row">
                <div class="col-5"><h5>Announcement Bar (Middle Section)</h5></div>
            </div>
            <br/>
            <div class="row">
                <div class="col-3"><label>Icon Class </label></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="header_announcement_middle_icon_class" placeholder="Enter Announcement Bar Middle Icon Class" value="<?php echo $header['announcement']['middle']['icon_class']; ?>" />
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-3"><label>Title </label></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="header_announcement_middle_title" placeholder="Enter Announcement Bar Middle Text" value="<?php echo $header['announcement']['middle']['title']; ?>" />
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-3"><label>Text </label></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="header_announcement_middle_text" placeholder="Enter Announcement Bar Middle Text" value="<?php echo $header['announcement']['middle']['text']; ?>" />
                </div>
            </div>
            <br/>
            <div class="row" id="header_announcement_left_url">
                <div class="col-3"><label>URL </label></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="header_announcement_middle_url" placeholder="Enter Announcement Bar Middle URL" value="<?php echo $header['announcement']['middle']['url']; ?>" />
                </div>
            </div>
            </div>

            <br />
            <div class="row">
                <div class="col-5"><h5>Announcement Bar (Right Section)</h5></div>
            </div>
            <br/>
            <div class="row">
                <div class="col-3"><label>Icon Class </label></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="header_announcement_right_icon_class" placeholder="Enter Announcement Bar Right Icon Class" value="<?php echo $header['announcement']['right']['icon_class']; ?>" />
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-3"><label>Title </label></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="header_announcement_right_title" placeholder="Enter Announcement Bar Right Text" value="<?php echo $header['announcement']['right']['title']; ?>" />
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-3"><label>Text </label></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="header_announcement_right_text" placeholder="Enter Announcement Bar Right Text" value="<?php echo $header['announcement']['right']['text']; ?>" />
                </div>
            </div>
            <br/>
            <div class="row" id="header_announcement_right_url">
                <div class="col-3"><label>URL </label></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="header_announcement_right_url" placeholder="Enter Announcement Bar Right URL" value="<?php echo $header['announcement']['right']['url']; ?>" />
                </div>
            </div>
            <button type="button" style="display:none;" class="save-first btn btn-primary mt-3" disabled>Save changes</button><button type="submit" class="save-change btn btn-primary mt-3" name="header_configuration">Save changes</button>
        </div>
    </form>
 