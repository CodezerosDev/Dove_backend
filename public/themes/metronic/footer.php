	<footer class="container-fluid footer">
		<p class="pull-right">
			Executed in {elapsed_time} seconds, using {memory_usage}.<br />
            Powered by <a href="http://codezeros.com/" target="_blank"><i class="glyphicon glyphicon-globe "></i>&nbsp;Codezeros</a>
		</p>
	</footer>
	<div id="debug"><!-- Stores the Profiler Results --></div>
<?php
    Assets::add_js((array('jquery-ui.min.js','bootstrap.min.js',
                          'assets/global/plugins/ckeditor/ckeditor.js',

                          /* Charts and Circles on Dashboard */
                          'assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js',
                          'assets/global/scripts/easypiechart.js',
                          'assets/global/scripts/easypiechart-data.js',
                          'assets/global/plugins/flot/jquery.flot.min.js',
                          'assets/global/plugins/flot/jquery.flot.categories.min.js',
                          'assets/admin/pages/scripts/index.js',
                          /* Charts and Circles on Dashboard */

                          'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js',
                          'jquery.validate.min.js',
                  )));
    echo Assets::js();
?>
<script>
    jQuery(document).ready(function() {
        /*Metronic.init(); // init metronic core componets
        Layout.init(); // init layout
        QuickSidebar.init(); // init quick sidebar
        Demo.init(); // init demo features
        Index.init();
        Index.initDashboardDaterange();
        Index.initJQVMAP(); // init index page's custom scripts
        Index.initCalendar(); // init index page's custom scripts*/
        Index.initCharts(); // init index page's custom scripts
        /*Index.initChat();
        Index.initMiniCharts();
        Tasks.initDashboardWidget();*/


    });
</script>
</body>
</html>