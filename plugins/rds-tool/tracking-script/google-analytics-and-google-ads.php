<?php $get_rds_tracking_code = rds_tracking(); 
  	$gtag = "";
	if($get_rds_tracking_code['tracking']['Google']['GA4_CODE']){
		 $gtag = $get_rds_tracking_code['tracking']['Google']['GA4_CODE'];
	}elseif ($get_rds_tracking_code['tracking']['Google']['UA_CODE']){
		 $gtag = $get_rds_tracking_code['tracking']['Google']['UA_CODE'];
	}elseif ($get_rds_tracking_code['tracking']['Google']['UA_CODE']){
		 $gtag = $get_rds_tracking_code['tracking']['Google']['AW_CODE'];
	}
  $GA4_CODE = "";
  $UA_CODE = "";
  $AW_CODE = "";
	if($get_rds_tracking_code['tracking']['Google']['GA4_CODE']){
		 $GA4_CODE = "gtag('config','".$get_rds_tracking_code['tracking']['Google']['GA4_CODE']."');";
	}
	if (!empty($get_rds_tracking_code['tracking']['Google']['UA_CODE'])){
		 $UA_CODE =  "gtag('config','".$get_rds_tracking_code['tracking']['Google']['UA_CODE']."');";
	}
	if ($get_rds_tracking_code['tracking']['Google']['AW_CODE']){
		 $AW_CODE =  "gtag('config','".$get_rds_tracking_code['tracking']['Google']['AW_CODE']."');";
	}
?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $gtag;  ?>"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	<?php echo $GA4_CODE;  ?>
	<?php echo $UA_CODE; ?>
	<?php echo $AW_CODE; ?>
</script>