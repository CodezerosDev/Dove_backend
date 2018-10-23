<footer class="container-fluid footer">
    <p class="pull-right">
        Executed in {elapsed_time} seconds, using {memory_usage}.<br />
        Powered by <a href="http://webcluesinfotech.com/" target="_blank"><i class="glyphicon glyphicon-globe "></i>&nbsp;WebClues</a>
    </p>
</footer>
	<div id="debug"><!-- Stores the Profiler Results --></div>

    <!--Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline-->
    <script src="<?php echo Template::theme_url('assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js'); ?>"></script>
    <script src="<?php echo Template::theme_url('assets/global/scripts/easypiechart.js'); ?>"></script>
    <script src="<?php echo Template::theme_url('assets/global/scripts/easypiechart-data.js'); ?>"></script>

    <script src="<?php echo Template::theme_url('assets/global/plugins/flot/jquery.flot.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo Template::theme_url('assets/global/plugins/flot/jquery.flot.categories.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo Template::theme_url('assets/global/plugins/bootstrap-daterangepicker/moment.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo Template::theme_url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js'); ?>" type="text/javascript"></script>

    <script src="<?php echo Template::theme_url('assets/global/scripts/metronic.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo Template::theme_url('assets/admin/layout/scripts/layout.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo Template::theme_url('assets/admin/layout/scripts/quick-sidebar.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo Template::theme_url('assets/admin/layout/scripts/demo.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo Template::theme_url('assets/admin/pages/scripts/index.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo Template::theme_url('assets/global/plugins/ckeditor/ckeditor.js'); ?>" type="text/javascript"></script>

    <script>
        jQuery(document).ready(function() {

            Metronic.init(); // init metronic core componets
            Layout.init(); // init layout
            QuickSidebar.init(); // init quick sidebar
            Demo.init(); // init demo features
            Index.init();
            Index.initDashboardDaterange();
            Index.initJQVMAP(); // init index page's custom scripts
            Index.initCalendar(); // init index page's custom scripts
            Index.initCharts(); // init index page's custom scripts
            Index.initChat();
            Index.initMiniCharts();
        });
    </script>

<?php Assets::add_js('jquery.validate.min.js');?>
<?php // echo Assets::js(); ?>

</body>
</html>