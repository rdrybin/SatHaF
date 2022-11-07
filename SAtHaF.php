<?php
/*
Plugin Name: SatHaF (Simple add to Head & Footer)
Plugin URI: http://tiweb.ru/simple-add-to-head-&-footer/
Description: Simple plugin for placing code in Footer and Head 
Author: RDRybin
Version: 1.0
Author URI: tiweb.ru
*/

$simple_add_to_head_footer = new SAtHaF();
$simple_add_to_head_footer->add_menu();

class SAtHaF
{
	public static function add_menu()
	{
		add_action('admin_menu', array('SAtHaF', 'admin_add_menu'));
		add_action('wp_head', array('SAtHaF', 'front_add_data_head'));
		add_action('wp_footer', array('SAtHaF', 'front_add_data_footer'));
	}
	public static function admin_add_menu()
	{
		add_options_page('Head&Footer (SATH)', 'Head&Footer (SATH)', 'edit_pages', 'SAtHaF', array('SAtHaF', 'options'));
	}

	private static function save()
	{
		if (isset($_POST['submit-head'])) {
			$option_name = 'SAtHaF_head';
			$options['data'][0] = $_POST['my-head'];

			if (get_option($option_name))
				update_option($option_name, $options);
			else
				add_option($option_name, $options);
		}

		if (isset($_POST['submit-footer'])) {
			$option_name = 'SAtHaF_footer';
			$options['data'][0] = $_POST['my-footer'];

			if (get_option($option_name))
				update_option($option_name, $options);
			else
				add_option($option_name, $options);
		}
	}

	public static function front_add_data_head()
	{
		$options = get_option('SAtHaF_head');
		$output = $options['data'][0];
		echo stripslashes($output) . "\n";
	}

	public static function front_add_data_footer()
	{
		$options = get_option('SAtHaF_footer');
		$output = $options['data'][0];
		echo stripslashes($output) . "\n";
	}

	public static function options()
	{
		self::save();
		$head = '';
		$footer = '';

		if (get_option('SAtHaF_head')) {
			$head = get_option('SAtHaF_head')['data'][0];
		}

		if (get_option('SAtHaF_footer')) {
			$footer = get_option('SAtHaF_footer')['data'][0];
		}

?>
		<h2>Simple add to Head & Footer</h2>
		<div class="wrap">
			<form method="post" name="head_form">
				<h3>Add HTML to head</h3>
				<textarea name="my-head" class="large-text code" cols="50" rows="10"><?php echo stripslashes($head); ?></textarea>
				<p class="submit">
					<input type="submit" name="submit-head" value="<?php esc_attr_e('Save head') ?>" class="button-primary" />
				</p>
			</form>
		</div>

		<div class="wrap">
			<form method="post" name="footer_form">
				<h3>Add HTML to Footer</h3>
				<textarea name="my-footer" class="large-text code" cols="50" rows="10"><?php echo stripslashes($footer); ?></textarea>
				<p class="submit">
					<input type="submit" name="submit-footer" value="<?php esc_attr_e('Save footer') ?>" class="button-primary" />
				</p>
			</form>
		</div>
<?php
	}
}
