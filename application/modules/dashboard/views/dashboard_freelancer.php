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
                      ***<?php echo __('dashboard_you_can\'t_bid_on_job_until_your_account_has_not_verified_by_admin', 'You can\'t bid on job until your account has not verified by admin') ?>
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
                    <div class="well text-center">
                        <h4 class="text-uppercase">Looking for projects, eDesk is here to help You!'</h4>
                        <a href="<?php echo base_url('findjob'); ?>"
                           class="btn btn-site"><?php echo __('dashboard_browse_project', 'Browse Project') ?></a>
                    </div>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-4 text-center">
                              <?php
                              $available_bids = get_available_bids($user_id);
                              $free_bid = get_available_bids($user_id, TRUE);
                              $purchase_bid = getField('available_bids', 'user', 'user_id', $user_id);
                              ?>
                                <h4 class="text-uppercase"><?php echo __('dashboard_available_bids', 'Available Bids') ?>
                                    : <?php echo $available_bids; ?></h4>
                                <h5 class="text-uppercase"><i><?php echo __('dashboard_free_bid', 'Free Bid') ?>
                                        : <?php echo $free_bid; ?></i></h5>
                                <h5 class="text-uppercase"><i><?php echo __('dashboard_purchase_bid', 'Purchase Bid') ?>
                                        : <?php echo $purchase_bid; ?></i></h5>
                            </div>

                            <div class="col-sm-8 text-center">
                                <h4 class="text-uppercase"><?php echo __('dashboard_add_more_bid', 'Add more bid to your account') ?></h4>
                                <a href="<?php echo base_url('dashboard/bid_plan'); ?>"
                                   class="btn btn-site"><?php echo __('dashboard_buy_bid', 'Buy Bid') ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="row-0">
                        <div class="col-sm-6 col-xs-12">
                            <article class="well text-center">
                                <h3 class="text-uppercase"><?php echo __('dashboard_earned_amount', 'Earned Amount') ?></h3>
                                <h2><?php echo CURRENCY . ' ' . number_format($earned_amount); ?></h2>
                            </article>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <article class="well text-center">
                                <h3 class="text-uppercase"><?php echo __('dashboard_total_bidded_project', 'Total bidded project') ?></h3>
                                <h2><?php echo $total_bids; ?></h2>
                            </article>
                        </div>
                    </div>

                    <h4><?php echo __('dashboard_recent_bidded_project', 'Recent Bidded Project') ?></h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <th><?php echo __('dashboard_project_title', 'Project title') ?></th>
                            <th><?php echo __('dashboard_posted_on', 'Posted on') ?></th>
                            <th><?php echo __('dashboard_hourly_fixed', 'Hourly/Fixed') ?></th>
                            <th><?php echo __('dashboard_bid_amount', 'Bid amount') ?></th>
                            <th><?php echo __('dashboard_myproject_client_status', 'Status') ?></th>
                            </thead>
                            <tbody>
                            <?php if (count($recent_bids) > 0) {
                              foreach ($recent_bids as $k => $v) {
                                $p_status = '';
                                $all_bidders = explode(',', $v['all_bidders']);
                                $href = base_url('jobdetails/details/' . $v['project_id'] . '/' . seo_string($v['title']));
                                if ($v['project_status'] == 'O') {

                                  $p_status = '<span class="orange-text">' . __('dashboard_myproject_pending', 'Pending') . '</span>';

                                } else {

                                  if ($v['project_type'] == 'F') {


                                    if (in_array($user_id, $all_bidders)) {
                                      if ($v['project_status'] == 'C') {
                                        $p_status = '<span class="orange-text">' . __('dashboard_myproject_completed', 'Completed') . '</span>';
                                        $href = base_url('projectdashboard_new/freelancer/overview/' . $v['project_id']);
                                      } else if ($v['project_status'] == 'CNL') {
                                        $p_status = '<span class="red-text">' . __('dashboard_myproject_client_cancelled', 'Canceled') . '</span>';
                                      } else {
                                        $p_status = '<span class="green-text">' . __('dashboard_myproject_active', 'Active') . '</span>';
                                        $href = base_url('projectdashboard_new/freelancer/overview/' . $v['project_id']);
                                      }

                                    } else if ($v['project_status'] == '0') {
                                      $p_status = '<span class="orange-text">' . __('dashboard_myproject_pending', 'Pending') . '</span>';
                                    } else {
                                      $p_status = '<span class="orange-text">' . __('dashboard_bid_lost', 'Bid Lost') . '</span>';
                                    }


                                  } elseif ($v['project_type'] == 'H') {
                                    $schedulw_row = $this->db->where(array('project_id' => $v['project_id'], 'freelancer_id' => $user_id))->get('project_schedule')->row_array();

                                    if (!empty($schedulw_row)) {
                                      if ($schedulw_row['is_contract_end'] == 1) {
                                        $p_status = '<span class="red-text">' . __('dashboard_ended', 'Ended') . '</span>';
                                        $href = base_url('projectdashboard_new/freelancer/overview/' . $v['project_id']);
                                      } else {
                                        $p_status = '<span class="green-text">' . __('dashboard_myproject_active', 'Active') . '</span>';
                                        $href = base_url('projectdashboard_new/freelancer/overview/' . $v['project_id']);
                                      }

                                    } else {
                                      $p_status = '<span class="orange-text">' . __('dashboard_myproject_pending', 'Pending') . '</span>';
                                    }

                                  }

                                }


                                ?>

                                  <tr>
                                      <td>
                                          <a href="<?php echo $href; ?>"><?php echo strlen($v['title']) > 90 ? substr($v['title'], 0, 90) . '...' : $v['title']; ?></a>
                                      </td>
                                      <td><?php echo date('d M , Y', strtotime($v['post_date'])); ?></td>
                                      <td><?php echo $v['project_type'] == 'F' ? __('myprofile_emp_fixed', 'Fixed') : __('myprofile_emp_hourly', 'Hourly'); ?></td>
                                      <td><?php echo CURRENCY . $v['bidder_amt'];
                                        if ($v['project_type'] == 'H') {
                                          echo ' /' . __('hr', 'hr');
                                        } ?></td>
                                      <td><?php echo $p_status; ?> </td>
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
