<?php $get_rds_tracking_code = rds_tracking(); 
  $items = $get_rds_tracking_code['Google_Ads_Conversion_Codes']['items']; 
  foreach ($items as $value) {
      if(is_page($value['page_id'])){ ?><script type="">gtag('event', 'conversion', {'send_to': <?php echo $value['AW_CODE']; ?>/<?php echo $value['CONVERSION_CODE'];?> });</script><?php }
    
  } 
?>