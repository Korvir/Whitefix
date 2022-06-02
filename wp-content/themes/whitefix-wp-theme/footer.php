<?php

use App\Helpers\Posts;

?>
<footer class="my-5 text-center">
	<p class="mb-2">
		<small> <?= Posts::getAcfValue('copyright') ?> </small>
	</p>
</footer>

<!-- Modals -->
<?php get_template_part('template-parts/popups/popup', 'contact') ?>
<?php get_template_part('template-parts/popups/popup', 'success') ?>
<!-- END Modals -->

<?php wp_footer(); ?>

</body>

</html>
