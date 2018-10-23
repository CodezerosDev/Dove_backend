<?php
    if($this->session->userdata('role_id') !=7){
?>
    <!-- BEGIN DASHBOARD STATS -->
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <span class="dashboard-stat dashboard-stat-light blue-soft" href="#">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <?=$total_app_users;?>
                    </div>
                    <div class="desc">
                        Total App Users
                    </div>
                </div>
            </span>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <span class="dashboard-stat dashboard-stat-light purple-soft" href="#">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <?=$pending_users;?>
                    </div>
                    <div class="desc">
                        Pending Users
                    </div>
                </div>
            </span>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <span class="dashboard-stat dashboard-stat-light green-soft" href="#">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <?=$verified_users;?>
                    </div>
                    <div class="desc">
                        Verified Users
                    </div>
                </div>
            </span>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <span class="dashboard-stat dashboard-stat-light red-soft" href="#">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <?=$rejected_users;?>
                    </div>
                    <div class="desc">
                        Rejected Users
                    </div>
                </div>
            </span>
        </div>
    </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <span class="dashboard-stat dashboard-stat-light blue-soft" href="#">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <?=$total_app_manager;?>
                    </div>
                    <div class="desc">
                        Total Manager
                    </div>
                </div>
            </span>
            </div>
        </div>
    <!-- END DASHBOARD STATS -->
    <!--Start--->
    <!--<div class="row">
        <div class="col-xs-6 col-md-3">
            <div class="panel panel-default">
                <div class="panel-body easypiechart-panel">
                    <h4>Total App User</h4>
                    <div class="easypiechart" id="easypiechart-blue" data-percent="82" ><span class="percent">82%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="panel panel-default">
                <div class="panel-body easypiechart-panel">
                    <h4>Total Manager</h4>
                    <div class="easypiechart" id="easypiechart-orange" data-percent="55" ><span class="percent">55%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="panel panel-default">
                <div class="panel-body easypiechart-panel">
                    <h4>Profits</h4>
                    <div class="easypiechart" id="easypiechart-teal" data-percent="84" ><span class="percent">84%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="panel panel-default">
                <div class="panel-body easypiechart-panel">
                    <h4>No. of Visits</h4>
                    <div class="easypiechart" id="easypiechart-red" data-percent="46" ><span class="percent">46%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
<?php }else{?>
        <div>
            <h1 style="margin-top:14%; margin-bottom: 14%; text-align: center">Welcome  <b><?=$referralcode->username?></b>, here is my reference number <b><?=$referralcode->referral_code?></b></h1>

            <?php

            ?>
        </div>

    <?php } ?>

<!--end--->










