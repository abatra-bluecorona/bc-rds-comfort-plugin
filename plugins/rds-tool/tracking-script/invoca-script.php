<?php $get_rds_tracking_code = rds_tracking(); ?>
<script>
  (function(i,n,v,o,c,a) { i.InvocaTagId = o; var s = n.createElement('script'); s.type = 'text/javascript';
    s.async = true; s.src = ('https:' === n.location.protocol ? 'https://' : 'http://' ) + v;
    var fs = n.getElementsByTagName('script')[0]; fs.parentNode.insertBefore(s, fs);
  })(window, document, 'solutions.invocacdn.com/js/invoca-latest.min.js', <?php echo $get_rds_tracking_code['invoca']['invoca_id'];  ?>);
</script>
