function checkboxValidation() {
    jQuery(".after-add-more-service-area").not(":last").each(function() {
        var allCheckboxes = jQuery(this).find('input[type=checkbox]');
        allCheckboxes.click(function() {
            var checkedCount = allCheckboxes.filter(':checked').length;
            if (checkedCount === 1 && jQuery(this).is(':checked')) {
            } else if (checkedCount === 0) {
                jQuery(this).prop('checked', true);
                alert('At least one checkbox must remain checked.');
            } else {
                allCheckboxes.prop('disabled', false);
            }
        });
    });
}

jQuery(document).ready(function() {

    checkboxValidation()

    jQuery('.save-change').click(function() {
        jQuery(this).hide();
        jQuery(this).siblings('button').show();
    });

    jQuery(document).on('click', '.add-new-button', function(e) {
        e.preventDefault();
        checkboxValidation()
    });

    jQuery('.after-add-more-service-area:first .remove').remove();

    jQuery('.sevice-equire').click(function(e) {
        e.preventDefault();
        var last_row_radio_checked = jQuery(".after-add-more-service-area:last input[type=radio]:checked").length;
        var last_row_checkbox_checked = jQuery(".after-add-more-service-area:last input[type=checkbox]:checked").length;
        var ab = jQuery('.container-add-more div.after-add-more-service-area:last').find('.page-title-class').text();
        var bb = jQuery('.container-add-more div.after-add-more-service-area:last').find('.service-title-class').text();
        var i = 0;
        if (last_row_radio_checked == 0) {
            alert('Please Select Page ');
            i++;
        }
        if (last_row_checkbox_checked == 0) {
            alert('please Select Services Area');
            i++;
        }
        if (i == 0) {
            jQuery(this).hide();
            jQuery(this).siblings('button').show();
            jQuery("#form-sevice").submit();
        }
    });

    // Hide Section if not enable
    jQuery(".after-add-more").find('.remove').first().hide();
    jQuery(".after-add-more-license").find('.remove').first().hide();

    if (jQuery('.enable-section').is(":checked")) {
        jQuery(".hide-section-div").addClass('d-lg-block');
    } else {
        jQuery(".hide-section-div").addClass('d-lg-none');
    }
    jQuery('.enable-section').click(function() {
        jQuery(this).closest(".hide-section-container").siblings(".hide-section-div").toggleClass('d-lg-block d-lg-none');
    });

    // Function to handle adding more items
    function addMoreItems(trigger, itemClass, errorMessage) {
        jQuery(trigger).click(function() {
            var lastItem = jQuery(itemClass + ':last');
            var isEmpty = false;
            lastItem.find('input[type="text"], textarea').each(function() {
                if (jQuery(this).val() === '') {
                    isEmpty = true;
                    return false;
                }
            });
            if (isEmpty) {
                alert(errorMessage);
            } else {
                var getClass = jQuery(this).hasClass('copy');
                if (getClass) {
                    var getPagename = jQuery(this).closest(".add-change-btn").siblings(itemClass).last().find(".page-title-class").text().trim();
                    var getservicename = jQuery(this).closest(".add-change-btn").siblings(itemClass).last().find(".service-title-class").html().trim();
                }
                var allLicenseInputs = jQuery(this).closest(".add-change-btn").siblings(itemClass + ', .after-add-more-license').find("input");
                var incompleteInputs = allLicenseInputs.filter(function() {
                    return jQuery(this).val().trim() === "";
                });

                if (incompleteInputs.length > 0) {
                    alert("Incomplete information: Please ensure all fields are filled");
                } else {
                    var html = jQuery(this).closest(".add-change-btn").siblings(itemClass).last().clone();
                    jQuery(html).find(".change").html("<button type='button' class='btn btn-danger remove' >- Remove</button>");
                    html.find("input, textarea").val("");
                    var index = jQuery(this).closest(".add-change-btn").siblings(itemClass).length;

                    html.find(".rdsPageName").each(function() {
                        if (!getClass) {
                            jQuery(this).find("input").prop('checked', false);
                        }
                        page_id = jQuery(this).find("input").data("page-id");
                        jQuery(this).find(".service_area_p_ids").attr("name", "service_area_ids[" + index + "][page_ids][]");
                        jQuery(this).find(".service_area_l_ids").attr("name", "service_area_ids[" + index + "][location_ids][]");
                        jQuery(this).find("input").val(page_id);
                    });

                    html.find(".page-title-class").text("PAGE TITLE");
                    html.find(".service-title-class").html("SERVICE AREA PAGE TITLE");

                    jQuery(this).closest(".add-change-btn").siblings(itemClass).last().after(html);
                    jQuery(this).closest(".add-change-btn").siblings(itemClass).last().find(".page-title-class").text(getPagename);
                    jQuery(this).closest(".add-change-btn").siblings(itemClass).last().find(".service-title-class").html(getservicename);
                }
            }
        });

        jQuery("body").on("click", ".remove", function() {
            jQuery(this).parents(itemClass).remove();
        });
    }

    addMoreItems('.add-more-google-ads', '.after-add-more-google-ads', 'Please fill all fields Google Ads Conversion Codes');
    addMoreItems('.add-more-address', '.after-add-more-address', 'Please fill in all fields in the address.');
    addMoreItems('.add-more-license', '.after-add-more', 'Incomplete information: Please provide the License Number to proceed.');
    // addMoreItems('.add-more', '.after-add-more', 'Incomplete information: Please provide the License Number to proceed.');
    addMoreItems('.add-more-social', '.after-add-more-social', 'Incomplete information: Please provide the Social media Icon class & URL');

    jQuery("body").on("click", ".add-more-service-area", function() {

        var getClass = jQuery(this).hasClass('copy');
        if (getClass == true) {
            var getPagename = jQuery(this).closest(".add-change-btn").siblings(".after-add-more-service-area").last().find(".page-title-class").text().trim();
            var getservicename = jQuery(this).closest(".add-change-btn").siblings(".after-add-more-service-area").last().find(".service-title-class").html().trim();
        }

        var last_row_radio_checked = jQuery(".after-add-more-service-area:last input[type=radio]:checked").length;
        var last_row_checkbox_checked = jQuery(".after-add-more-service-area:last input[type=checkbox]:checked").length;

        if (last_row_radio_checked > 0 && last_row_checkbox_checked > 0) {
            var html = jQuery(this).closest(".add-change-btn").siblings(".after-add-more-service-area").last().clone();
            jQuery(html).find(".change").html("<button type='button' class='btn btn-danger remove' >- Remove</button>");
            html.find("input").each(function(k, data) {
                jQuery(data).val("");
            });
            var index = jQuery(this).closest(".add-change-btn").siblings(".after-add-more-service-area").length;

            html.find(".rdsPageName").each(function(k, data) {
                if (getClass == false) {

                    jQuery(data).find("input").prop('checked', false);
                }
                page_id = jQuery(data).find("input").data("page-id");
                jQuery(data).find(".service_area_p_ids").attr("name", "service_area_ids[" + index + "][page_ids][]")
                jQuery(data).find(".service_area_l_ids").attr("name", "service_area_ids[" + index + "][location_ids][]")
                jQuery(data).find("input").val(page_id);
            });

            html.find(".page-title-class").each(function(k, data) {
                jQuery(data).text("PAGE TITLE");
            });
            html.find(".service-title-class").each(function(k, data) {
                jQuery(data).text("SERVICE AREA PAGE TITLE");
            });
            html.find("textarea").each(function(k, data) {
                jQuery(data).html("");
            });
            jQuery(this).closest(".add-change-btn").siblings(".after-add-more-service-area").last().after(html);
            jQuery(this).closest(".add-change-btn").siblings(".after-add-more-service-area").last().find(".page-title-class").text(getPagename);
            jQuery(this).closest(".add-change-btn").siblings(".after-add-more-service-area").last().find(".service-title-class").html(getservicename);
        } else {
            alert('Please Select Page and Services Area')
        }

    });
    jQuery("body").on("click", ".remove", function() {
        jQuery(this).parents(".after-add-more-service-area").remove();
    });

    jQuery('.zipcode').keypress(function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g))
            return false;
    });
    //Footer variation  Start
    var footer_var = jQuery("#rds-footer-variation").val();
    if (footer_var === "b") {
        jQuery(".rds_footer_menu_options").hide();
        jQuery(".br-d-none").hide();
    } else {
        jQuery(".rds_footer_menu_options").show();
        jQuery(".br-d-none").show();
    }
    jQuery("body").on("change", "#rds-footer-variation", function() {
        if (jQuery(this).val() === "b") {
            jQuery(".rds_footer_menu_options").hide();
            jQuery(".br-d-none").hide();
        } else {
            jQuery(".rds_footer_menu_options").show();
            jQuery(".br-d-none").show();
        }
    });
    //Footer variation end
    //Header variation start
    var slected_variation = jQuery(".rds-select-variation");

    jQuery(slected_variation).each(function(key, data) {
        if (jQuery(this).val() == "c") {
            jQuery("#header_announcement_right_url").hide();
            jQuery("#announcment_bar_middle_content").hide();
            jQuery("#call_text").hide();
            jQuery("#main_header_text").text("Announcement Bar (Middle Section)");
        } else {
            jQuery(this).closest(".rds-container-header").children(".container-for-select-variation").show();
            jQuery("#header_announcement_right_url").show();
            jQuery("#announcment_bar_middle_content").show();
            jQuery("#call_text").show();
            jQuery("#main_header_text").text("Main Header");
        }
    });
    jQuery("body").on("change", ".rds-select-variation", function() {
        if (jQuery(this).val() == "c") {
            jQuery("#header_announcement_right_url").hide();
            jQuery("#announcment_bar_middle_content").hide();
            jQuery("#call_text").hide();
            jQuery("#main_header_text").text("Announcement Bar (Middle Section)");

        } else {
            jQuery(this).closest(".rds-container-header").children(".container-for-select-variation").show();
            jQuery("#header_announcement_right_url").show();
            jQuery("#announcment_bar_middle_content").show();
            jQuery("#call_text").show();
            jQuery("#main_header_text").text("Main Header");
        }
    });
    //
    //slect option or hide option for main header desktop start
    var slected_option = jQuery(".rds-select-option");
    jQuery(slected_option).each(function(key, data) {
        if (jQuery(this).val() !== "url") {
            jQuery(this).closest(".container-for-select-option").children(".rds-select-url").hide();
        } else {
            jQuery(this).closest(".container-for-select-option").children(".rds-select-url").show();
        }
    });
    jQuery("body").on("change", ".rds-select-option", function() {
        if (jQuery(this).val() !== "url") {
            jQuery(this).closest(".container-for-select-option").children(".rds-select-url").hide();
        } else {
            jQuery(this).closest(".container-for-select-option").children(".rds-select-url").show();
        }
    });
    //slect option or hide option for main header desktop End

    //slect option or hide option for announcement start
    var slected = jQuery("#header_announcement_left_type").val();
    if (slected == "hover") {
        jQuery("#header_announcement_left_url").hide();
        jQuery("#header_announcement_left_tooltip_text").show();
    } else {
        jQuery("#header_announcement_left_url").show();
        jQuery("#header_announcement_left_tooltip_text").hide();
    }
    jQuery("body").on("change", "#header_announcement_left_type", function() {
        slected = jQuery(this).val();
        if (slected == "hover") {
            jQuery("#header_announcement_left_url").hide();
            jQuery("#header_announcement_left_tooltip_text").show();
        } else {
            jQuery("#header_announcement_left_url").show();
            jQuery("#header_announcement_left_tooltip_text").hide();
        }
    });
    //slect option or hide option for announcement End

    // Function to handle chat variation change
    function handleChatVariationChange(value) {
        if (value === "others") {
            jQuery("#chat_id").hide();
            jQuery("#chat_script").show();
            jQuery("#chat_scheduler_info").hide();
        } else if (value === "schedule_engine") {
            jQuery("#chat_id").show();
            jQuery("#chat_script").hide();
            jQuery("#chat_scheduler_info").show();
        } else {
            jQuery("#chat_id").show();
            jQuery("#chat_script").hide();
            jQuery("#chat_scheduler_info").hide();
        }
    }

    // Function to handle scheduler variation change
    function handleSchedulerVariationChange(value) {
        if (value === "others") {
            jQuery("#scheduler_id").hide();
            jQuery("#scheduler_script").show();
            jQuery("#nexhealth_id").hide();
            jQuery("#clearwave_id").hide();
            jQuery("#zocdoc_id").hide();
        } else if (value === "zocdoc") {
            jQuery("#scheduler_script").hide();
            jQuery("#scheduler_id").hide();
            jQuery("#nexhealth_id").hide();
            jQuery("#clearwave_id").hide();
            jQuery("#zocdoc_id").show();
        } else if (value === "nexhealth") {
            jQuery("#scheduler_script").hide();
            jQuery("#scheduler_id").hide();
            jQuery("#zocdoc_id").hide();
            jQuery("#clearwave_id").hide();
            jQuery("#nexhealth_id").show();
        } else if (value === "clearwave") {
            jQuery("#scheduler_script").hide();
            jQuery("#scheduler_id").hide();
            jQuery("#zocdoc_id").hide();
            jQuery("#nexhealth_id").hide();
            jQuery("#clearwave_id").show();
        } else {
            jQuery("#scheduler_id").show();
            jQuery("#scheduler_script").hide();
            jQuery("#zocdoc_id").hide();
            jQuery("#nexhealth_id").hide();
            jQuery("#clearwave_id").hide();
        }
    }

    handleChatVariationChange(jQuery("#rds-chat-variation").val());

    handleSchedulerVariationChange(jQuery("#rds-scheduler-variation").val());

    jQuery("body").on("change", "#rds-chat-variation", function() {
        handleChatVariationChange(jQuery(this).val());
    });

    jQuery("body").on("change", "#rds-scheduler-variation", function() {
        handleSchedulerVariationChange(jQuery(this).val());
    });

    // Function to handle toggling visibility based on checkbox state
    function toggleVisibility(checkboxId, targetId) {
        var $checkbox = jQuery('#' + checkboxId);
        var $target = jQuery('#' + targetId);
        if ($checkbox.is(":checked")) {
            $target.removeClass('d-lg-none').addClass('d-lg-block');
        } else {
            $target.removeClass('d-lg-block').addClass('d-lg-none');
        }
        $checkbox.click(function() {
            $target.toggleClass('d-lg-block d-lg-none');
        });
    }

    // Array of settings to iterate through
    var settings = [{
            checkbox: 'reviews-eanble-checkbox',
            target: 'reviews-enable-section'
        },
        {
            checkbox: 'chat-eanble-checkbox',
            target: 'chat-enable-section'
        },
        {
            checkbox: 'google-eanble-checkbox',
            target: 'google'
        },
        {
            checkbox: 'google-search-console-eanble-checkbox',
            target: 'google-search-console'
        },
        {
            checkbox: 'google-tag-manager-eanble-checkbox',
            target: 'google-tag-manager'
        },
        {
            checkbox: 'facebook-pixel-eanble-checkbox',
            target: 'facebook-pixel'
        },
        {
            checkbox: 'bing-ads-pixel-eanble-checkbox',
            target: 'bing-ads-pixel'
        },
        {
            checkbox: 'hotjar-eanble-checkbox',
            target: 'hotjar'
        },
        {
            checkbox: 'accessibility-eanble-checkbox',
            target: 'accessibility'
        },
        {
            checkbox: 'google-ads-conversion-codes-eanble-checkbox',
            target: 'google-ads-conversion-codes'
        },
        {
            checkbox: 'scheduler-eanble-checkbox',
            target: 'scheduler-enable-section'
        },
        {
            checkbox: 'invoca-eanble-checkbox',
            target: 'invoca-enable-section'
        }
    ];

    // Loop through settings and apply toggleVisibility function
    settings.forEach(function(setting) {
        toggleVisibility(setting.checkbox, setting.target);
    });

    jQuery(document).on('keyup', '.rdsSearchThePageId', function() {
        var value = jQuery(this).val().toLowerCase();
        var $menu = jQuery(this).closest(".dropdown-menu.rdsMatchPageName");

        $menu.find("li").each(function() {
            var $page = jQuery(this);
            var pageTitle = $page.text().toLowerCase();
            if (pageTitle.indexOf(value) > -1) {
                $page.show();
            } else {
                $page.hide();
            }
        });
    });

    jQuery("body").on("change", ".service_area_page_ids", function() {
        var title = jQuery(this).data("title");
        var titleId = jQuery(this).data("page-id");
        var titles = new Array();

        var i = 0;
        if (jQuery(this).is(":checked")) {
            titles[0] = title;
            i = 1;
        }

        var selected_inputs = jQuery(this).parents(".rdsPageName").siblings();
        selected_inputs.each(function() {
            if (jQuery(this).find("input").is(":checked")) {
                titles[i] = jQuery(this).find("input").data("title");
            }
            i++;
        });

        if (titles.length == 0) {
            titles[0] = 'SERVICE AREA PAGES TITLE'
        }
        var blkstr = $.map(titles, function(val, index) {
            return val;
        }).join(", ");
        jQuery(this).closest(".rdsMatchPageName").siblings(".rds_selected_service_area").text(blkstr);
    });

    // Function to check if fields are empty
    function checkFields(selector) {
        var lastSection = jQuery('.after-add-more-' + selector + ':last');
        var isEmpty = false;
        lastSection.find('input[type="text"], textarea').each(function() {
            if (jQuery(this).val() === '') {
                isEmpty = true;
                return false;
            }
        });
        return isEmpty;
    }

    // Function to toggle save button visibility
    function toggleSaveButton(selector, messageElement) {
        var saveButton = jQuery('.save-change.' + selector + '_save');
        var isEmpty = checkFields(selector);

        if (isEmpty) {
            jQuery(messageElement).show();
        } else {
            jQuery(messageElement).hide();
        }
    }

    // Function to bind event handlers and check/toggle save button
    function bindEventsAndToggleSaveButton(selector, addButtonClass) {
        toggleSaveButton(selector, '#' + selector + 'FormMessage');
        jQuery('.after-add-more-' + selector + ':last input, .after-add-more-' + selector + ':last textarea').on('input', function() {
            toggleSaveButton(selector, '#' + selector + 'FormMessage');
        });
        jQuery(document).on('click', '.' + addButtonClass, function() {
            toggleSaveButton(selector, '#' + selector + 'FormMessage');
        });
        jQuery(document).on('click', '.remove', function() {
            toggleSaveButton(selector, '#' + selector + 'FormMessage');
        });
    }

    bindEventsAndToggleSaveButton('address', 'add-more-address');
    bindEventsAndToggleSaveButton('google-ads', 'add-more-google-ads');

    // Function to validate Google Ads fields before submission
    jQuery('.google-save-changes').click(function(e) {
        e.preventDefault();
        var emptyFieldExists = checkFields('google-ads');
        if (emptyFieldExists) {
            alert('Please fill in all fields in the Google Ads Conversion Codes section.');
        } else {
            jQuery("#tracking_config_form").submit();
        }
    });

    // Function to validate address fields before submission
    jQuery('.site_info_submit').on('click', function(event) {
        var empty = checkFields('address');
        if (empty) {
            event.preventDefault();
            jQuery('.site_info_submit').prop('disabled', false);
            alert('Please fill in all fields in the address section.');
        } else {
            jQuery('.site_info_submit').prop('disabled', false);
            jQuery('#site-info-updation').submit();
        }
    });
});