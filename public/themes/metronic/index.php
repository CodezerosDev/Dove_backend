<?php
    echo theme_view('header');
?>
<div class="body">
	<div class="container-fluid">
	    <?php
            echo Template::message();
            echo isset($content) ? $content : Template::content();
        ?>
	</div>
</div>
<?php echo theme_view('footer'); ?>

