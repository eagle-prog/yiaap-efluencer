<?php echo $breadcrumb; ?>
<section id="mainpage">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 col-sm-3 col-xs-12">
              <?php $this->load->view('dashboard-left'); ?>
            </div>
            <aside class="col-md-10 col-sm-9 col-xs-12">
              <?php
              $user = $this->session->userdata('user');
              $verify = getField('verify', 'user', 'user_id', $user[0]->user_id);
              $status = getField('status', 'user', 'user_id', $user[0]->user_id);
              if ($verify == 'N' && !$status === 'Y') {
                ?>
                  <div class="row-0 alert alert-danger">
                      ***<?php echo __('dashboard_you_can\'t_bid_on_job_until_your_account_has_not_verified_by_admin', 'You can\'t post job until your account has not verified by admin') ?>
                      .
                  </div>
                <?php
              }
              if ($status !== 'Y') {
                ?>
                  <div class="row-0 alert alert-danger">
                      *** You account is closed/private, please <a href="<?php echo VPATH; ?>dashboard/openacc/">
                          activate your account</a> to continue working with the service!
                  </div>
                <?php
              }
              ?>
                <div class="<?php echo $status !== 'Y' ? 'disabled-section' : '' ?>">
                    <div class="row-0">
                        <div class="col-sm-6 col-xs-12">
                            <article class="well">
                                <div id="chartContainer" style="height: 180px; width: 100%;"></div>
                            </article>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <article class="well text-center" style="min-height:212px">
                                <h3 class="text-uppercase"><?php echo __('dashboard_posted_job', 'Posted Jobs') ?></h3>
                                <h2><?php echo $total_posted_work; ?></h2>
                            </article>
                        </div>
                    </div>

                    <div class="well text-center">
                        <h3 class="text-uppercase"><?php echo __('dashboard_total_spended_on_project', 'Total spended on project') ?></h3>
                        <h2><?php echo CURRENCY . ' ' . number_format($spend_amount); ?></h2>
                    </div>

                    <div class="well">
                        <h3 class="text-uppercase text-center"><?php echo __('dashboard_escrow_view', 'ESCROW VIEW') ?></h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#<?php echo __('dashboard_project_id', 'Project ID') ?></th>
                                    <th><?php echo __('dashboard_project_title', 'Project Title') ?></th>
                                    <th><?php echo __('dashboard_escrowed_amount', 'Escrowed Amount') ?>
                                        (<?php echo CURRENCY; ?>)
                                    </th>
                                    <th><?php echo __('dashboard_released_amount', 'Released Amount') ?>
                                        (<?php echo CURRENCY; ?>)
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (count($escrow_statics) > 0) {
                                  foreach ($escrow_statics as $k => $v) { ?>
                                      <tr>
                                          <td>
                                              <a href="<?php echo base_url('myfinance/project_all_transaction/' . $v['project_id']) ?>"><?php echo !empty($v['project_id']) ? '#' . $v['project_id'] : ''; ?></a>
                                          </td>
                                          <td><?php echo !empty($v['title']) ? (strlen($v['title']) > 60 ? substr($v['title'], 0, 60) . '...' : $v['title']) : ''; ?></td>
                                          <td style="color:green;"><?php echo !empty($v['total_credit']) ? $v['total_credit'] : ''; ?></td>
                                          <td style="color:red;"><?php echo !empty($v['total_debit']) ? $v['total_debit'] : ''; ?></td>
                                      </tr>
                                  <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="10"
                                            style="text-align:center;"><?php echo __('dashboard_no_records_found', 'No records found') ?></td>
                                    </tr>
                                <?php } ?>

                                </tbody>

                            </table>
                        </div>
                    </div>

                    <h4 class="pull-left"><?php echo __('dashboard_recent_posted_work', 'Recent Posted Work') ?></h4>
                    <a href="<?php echo base_url('postjob'); ?>"
                       class="btn btn-site pull-right"><?php echo __('myprofile_emp_post_job', 'Post Job'); ?></a>
                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <th><?php echo __('dashboard_project_title', 'Project title') ?></th>
                            <th><?php echo __('dashboard_bids', 'Bids') ?></th>
                            <th><?php echo __('dashboard_hourly_fixed', 'Hourly/Fixed') ?></th>
                            <th><?php echo __('dashboard_posted_on', 'Posted on') ?></th>
                            <th><?php echo __('dashboard_myproject_client_status', 'Status') ?></th>
                            </thead>
                            <tbody>

                            <?php if (count($recent_project) > 0) {
                              foreach ($recent_project as $k => $v) {
                                $url = '';

                                if (($v['project_status'] == 'O') || ($v['project_status'] == 'E') || ($v['project_status'] == 'F')) {
                                  $url = base_url('jobdetails/details/' . $v['project_id'] . '/' . seo_string($v['title']) . '/');
                                } else {
                                  $url = base_url('projectdashboard_new/employer/overview/' . $v['project_id']);
                                }
                                ?>
                                  <tr>
                                      <td>
                                          <a href="<?php echo $url; ?>"><?php echo strlen($v['title']) > 90 ? substr($v['title'], 0, 90) . '...' : $v['title']; ?></a>
                                      </td>
                                      <td><?php echo $v['total_bids']; ?></td>
                                      <td><?php echo $v['project_type'] == 'F' ? __('myprofile_emp_fixed', 'Fixed') : __('myprofile_emp_hourly', 'Hourly'); ?></td>
                                      <td><?php echo date('d M , Y', strtotime($v['post_date'])); ?></td>
                                      <td>
                                          <a href="<?php echo base_url('jobdetails/details/' . $v['project_id'] . '/' . seo_string($v['title']) . '/') ?>"><?php echo __('dashboard_details', 'Details') ?></a>
                                      </td>
                                  </tr>
                              <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="10"
                                        style="text-align:center;"><?php echo __('dashboard_no_records_found', 'No records found') ?></td>
                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
<link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
<script>
  window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer", {
      animationEnabled: true,
      legend: {
        cursor: "pointer",
        horizontalAlign: "right",
        verticalAlign: "center",
        fontSize: 12,
        fontFamily: "IBM Plex Sans"
      },
      data: [{
        type: "pie",
        showInLegend: true,
        //indexLabel: "{name} - {y}%",
        dataPoints:<?php echo json_encode($project_statics);?>
      }]
    });
    chart.render();
  }
</script>
<script src="<?php echo ASSETS; ?>plugins/canvasjs/canvasjs.min.js" type="text/javascript"></script>

<?php
if ($this->session->flashdata('notApprove')) {
  ?>
    <div id="coming_soon_modal2" class="modal fade" style="overflow: hidden">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col m12 s12">
                            <h4 style="margin-top: 30px; text-align: center;"><?php echo $this->session->flashdata('notApprove'); ?></h4>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <!--<button class="modal-close waves-effect waves-green btn-flat" type="button" data-dismiss="modal">Okay</button>-->
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo __('dashboard_myproject_close', 'Close') ?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
      $(window).load(function () {
        $('#coming_soon_modal2').modal('show');
      });
    </script>
  <?php
}
?>


