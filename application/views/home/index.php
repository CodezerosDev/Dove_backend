<style>
	.rmt-faded {
		background: #f7f7f7;
		padding: 20px;
		margin: 20px 0;
		border-radius: 10px;
		border: 1px solid #eceeee;
		min-height: 110px;
	}
	.jumbotron{
		text-align: left;
		margin:0px;
		/*position: absolute;
		left: 50%;
		top: 50%;
		transform: translate(-50%,-50%);*/
	}

	.row{
		margin-left: 0px !important;
	}
</style>

<div class="jumbotron" text-align="center">

<?php
	// 4 : for front user design
	if($this->session->userdata('role_id') == 4){
?>
		<div class="container">
			<div class="row-fluid">
				<div class="span8">
					<div class="rmt-faded">
						<div class="row">
							<div class="col-md-12">
								<h4 class="orange" style="font-size: 1.5em;margin-bottom: 20px;">Welcome <?php echo isset($current_user_info->display_name)? $current_user_info->display_name:'--';?>,</h4>
								<span class="orange"><b>Wallet address:</b><?php echo isset($current_user_info->meta_value)? $current_user_info->meta_value:' -- ';?></span>
								<br><br>
								<span class="orange"><b>Status:</b>
										<?php echo isset($current_user_info->is_verified)?
											($current_user_info->is_verified == 0) ?
												'<b style="color:#ffc207">Pending</b>':
												(($current_user_info->is_verified == 1)?
													'<b style="color:green">Verified</b>':
													'<b style="color:red">Rejected</b>'
												)
											: ' -- ';?>
								</span>
							</div>
						</div>
					</div>

					<div class="rmt-faded">
						<div class="row">
							<div class="col-md-12">
								<?php echo $buy_token_instruction; ?>
							</div>
						</div>
					</div>

				</div>
				<div class="span4">
					<div class="rmt-faded">
						<p class="token-text">My Dove Tokens</p>
						<p class="text-right token-amount">0.00</p>
					</div>

					<div class="rmt-faded">
						<p class="token-text">Registered referral no</p>
						<div class="">
							<div class="referral">
								<p class="text-right token-amount"><?php echo isset($current_user_info->referral_code)? $current_user_info->referral_code:'--';?></p>
							</div>
						</div>
					</div>


				</div>
			</div>
		</div>
<?php }else{ ?>
		<h1 style="text-align: center;">Welcome to Dove Network</h1>
<?php } ?>
</div>



