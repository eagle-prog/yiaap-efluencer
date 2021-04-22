<?php
$user = $this->session->userdata('user');
$current_user_id = $user[0]->user_id;
$drivers_license = count(glob('assets/documents/' . $current_user_id . '/drivers_license.*'));
$social_security = count(glob('assets/documents/' . $current_user_id . '/social_security.*'));
$form_1099 = count(glob('assets/documents/' . $current_user_id . '/1099_form.*'));

?>
<script>
  function uploadDocumentFile(ele, docType) {
    var file = $(ele)[0].files[0];
    if (file) {
      var $document = $(ele).closest('.document-container');
      var $errors = $document.find('.errors');
      $errors.empty();
      var fdata = new FormData();
      fdata.append('userfile', file);
      fdata.append('doc_type', docType);
      $('#loading').show();
      $.ajax({
        url: '<?php echo base_url('dashboard/updateDocumentFile')?>',
        data: fdata,
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (res) {
          $('#loading').hide();
          if (res.status == 1) {
            $document.addClass('uploaded');
          } else {
            for (var i in res.error) {
              $errors.append(res.error[i]);
            }
          }
        }

      });
    }
  }
</script>


<div class="row">
    <div class="col-xs-12">
        <div class="masg2 document-container <?php echo $drivers_license ? 'uploaded' : '' ?>">
            <label>Drivers License
                <i class="verified zmdi zmdi-hc-2x zmdi-check-circle" title="Verified"></i>
            </label>
            <small class="file-types text-muted">
                (<?php echo __('myprofile_allowed_documents', 'Allowed formats: jpg, jpeg, png, pdf, doc, docx'); ?>
                )
            </small>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-grey">
                      <?php echo __('myprofile_browse', 'Browse'); ?>&hellip;
                        <input type="file" class="form-control"
                               size="30"
                               name="driversLicense"
                               onchange="uploadDocumentFile(this, 'drivers_license')"
                               style="display: none;">
                    </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div>
            <div class="errors">
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="masg2 document-container <?php echo $social_security ? 'uploaded' : '' ?>">
            <label>Social Security
                <i class="verified zmdi zmdi-hc-2x zmdi-check-circle" title="Verified"></i>
            </label>
            <small class="file-types text-muted">
                (<?php echo __('myprofile_allowed_documents', 'Allowed formats: jpg, jpeg, png, pdf, doc, docx'); ?>
                )
            </small>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-grey">
                      <?php echo __('myprofile_browse', 'Browse'); ?>&hellip;
                        <input type="file" class="form-control"
                               size="30"
                               name="socialSecurity"
                               onchange="uploadDocumentFile(this, 'social_security')"
                               style="display: none;">
                    </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div>
            <div class="errors">
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="masg2 document-container <?php echo $form_1099 ? 'uploaded' : '' ?>">
            <label>Filled out 1099 form
                <i class="verified zmdi zmdi-hc-2x zmdi-check-circle" title="Verified"></i>
            </label>
            <small class="file-types text-muted">
                (<?php echo __('myprofile_allowed_documents', 'Allowed formats: jpg, jpeg, png, pdf, doc, docx'); ?>
                )
            </small>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-grey">
                      <?php echo __('myprofile_browse', 'Browse'); ?>&hellip;
                        <input type="file" class="form-control"
                               size="30"
                               name="1099Form"
                               onchange="uploadDocumentFile(this, '1099_form')"
                               style="display: none;">
                    </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div>
            <div class="errors">
            </div>
        </div>
    </div>
</div>
