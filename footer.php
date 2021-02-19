
<?php do_action('modula_footer');  ?>

<?php get_template_part( 'template-parts/misc/modals/login' ); ?>

<?php wp_footer(); ?>

<script>
   jQuery(document).ready(function(){
      jQuery('.edd_sl_show_key').on('click', function(){
        jQuery('.edd_sl_license_key').show();
      });
   });
</script>

</body>
</html>
