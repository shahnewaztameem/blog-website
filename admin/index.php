<?php include "includes/admin_header.php";?>

<div id="wrapper">
	<!-- Navigation -->
	<?php include "includes/admin_navigation.php";?>
	<div id="page-wrapper">
		<div class="container-fluid">

			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">
						Welcome To Admin Dashboard
						<small>
							<strong>
								<?php
									echo strtoupper(get_username());
								?>
                            </strong>
						</small>
					</h1>
				</div>
			</div>
			<!-- /.row -->

			<!-- /.row -->

			<div class="row">
				<div class="col-lg-4 col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-file-text fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class='huge'><?php echo $post_counts = count_records(get_all_user_posts()) ;?></div>
									<div>Posts</div>
								</div>
							</div>
						</div>
						<a href="posts.php">
							<div class="panel-footer">
								<span class="pull-left">View Details</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="panel panel-green">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-comments fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class='huge'><?php echo $comments_count = count_records(get_all_posts_user_comments())?></div>
									<div>Comments</div>
								</div>
							</div>
						</div>
						<a href="comments.php">
							<div class="panel-footer">
								<span class="pull-left">View Details</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>

				<div class="col-lg-4 col-md-6">
					<div class="panel panel-red">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-list fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class='huge'><?php echo $categories_count = count_records(get_all_user_categoreis())?></div>
									<div>Categories</div>
								</div>
							</div>
						</div>
						<a href="categories.php">
							<div class="panel-footer">
								<span class="pull-left">View Details</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
			</div>

			<?php
                $post_published_count    = count_records(get_all_user_published_posts());
                $post_draft_count        = count_records(get_all_user_draft_posts());
                $comment_unapprove_count = count_records(get_all_user_unapproved_posts_comments());
                $comment_approve_count   = count_records(get_all_user_approved_posts_comments());
            ?>
			<div class="row">
				<script type="text/javascript">
					google.charts.load('current', {
						'packages': ['bar']
					});
					google.charts.setOnLoadCallback(drawChart);

					function drawChart() {
						var data = google.visualization.arrayToDataTable([
							['Data', 'Count'],
							<?php
                $element_text = ['All Posts','Active Posts','Draft Posts','Comments','Approved Comments','Unapproved Comments','Categories'];
                $element_count = [$post_counts,$post_published_count,$post_draft_count,$comments_count,$comment_approve_count,$comment_unapprove_count,$categories_count];
                for($i = 0; $i < 7; $i++){
                    echo "['{$element_text[$i]}' ,". "{$element_count[$i]} ],";
                }
            
            ?>

							//['Posts', 1000],

						]);

						var options = {
							chart: {
								title: '',
								subtitle: '',

							}
						};

						var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

						chart.draw(data, google.charts.Bar.convertOptions(options));

					}
				</script>
				<div id="columnchart_material" style="width: auto; height: 500px;"></div>
				<!-- /.row -->

			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
<?php include "includes/admin_footer.php";?>


<script type="text/javascript">
	$(document).ready(function(){
		var pusher = new Pusher("0c7ee7af35424677b013", {
			cluster : "ap2",
			useTLS: true,
			encrypted: true
		});
		var notificationChannel = pusher.subscribe('notifications');
		notificationChannel.bind('new_user', function(notification){
			var message = notification.message;
			toastr.success(`${message} just registered`);
		});
	});
	
	
</script>