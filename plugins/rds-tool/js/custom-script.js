jQuery(document).ready(function($) {
  const $progress = $('#progress');
  const $percentage = $('#percentage');
  const $ajaxLoader = $('#ajax-loader');
  let uploadTimer;
  let paused = false;
  const handleUploadAction = 'handle_uploaded_file';

  function updatePercentage(p) {
    p = p || 0;
    $percentage.text(p + '%');
    if (p < 100) {
      $progress.css('width', p + '%');
      uploadTimer = setTimeout(function() {
        if (!paused) {
          updatePercentage(++p);
          if (p == 95) {
            paused = true;
            setTimeout(function() {
              paused = false;
            }, 4000);
          }
        }
      }, 150);
    }
  }

  function updateProgressBar() {
    $progress.width('100%');
    $percentage.text('100%');
  }

  function handleSuccess(response, uploadedType) {
    clearTimeout(uploadTimer);
    $ajaxLoader.hide();
    $('#success-popup').show();

    $('.upload-section[data-type="' + uploadedType + '"]').addClass('green-background');
    
    switch (uploadedType) {
      case 'template':
        $('.template-message').show().text(uploadedType + ' Uploaded');
        break;
      case 'design':
        $('.design-message').show().text(uploadedType + ' Uploaded');
        break;
      case 'nav':
        $('.nav-message').show().text(uploadedType + ' Uploaded');
        break;
      case 'tracking':
        $('.tracking-message').show().text(uploadedType + ' Uploaded');
        break;
    }

    setTimeout(function() {
      $("#progress-bar").fadeOut(1000);
      // $("#progress-bar").css({"background":"transparent");
      $('#success-popup').hide();
      jQuery('#wpbody-content').removeClass('rds-configuration');
      location.reload();
    }, 3000);
  }

  function handleError(xhr, textStatus, error) {
    console.error('Error:', error);
  }

  $('.file-upload-form').on('submit', function(e) {
    e.preventDefault();
    jQuery('#wpbody-content').addClass('rds-configuration');
    const dataType = $(this).closest('.upload-section').data('type');

    if (!ajax_object || !ajax_object.ajax_url) {
      console.error('Missing ajax_url in ajax_object.');
      return;
    }

    $ajaxLoader.show();
    updatePercentage();
    const formData = new FormData(this);
    formData.append('action', handleUploadAction);

    $.ajax({
      type: 'POST',
      url: ajax_object.ajax_url,
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      xhr: function() {
        const xhr = new window.XMLHttpRequest();
        let loadedBytes = 0;
        let totalBytes = 0;

        xhr.upload.addEventListener("progress", function(evt) {
          if (evt.lengthComputable) {
            loadedBytes = evt.loaded;
            totalBytes = evt.total;
          }
        }, false);

        xhr.addEventListener("load", function() {
          // console.log("uploadTimer", uploadTimer);
          updateProgressBar();
        });

        return xhr;
      },
      success: function(response) {
        // console.log('response', response);
        handleSuccess(response, dataType);
      },
      error: function(xhr, textStatus, error) {
        handleError(xhr, textStatus, error);
      }
    });
  });


  $('[data-toggle="tooltip"]').tooltip(); 
});


   