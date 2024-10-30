<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class image_to_postlist_class extends basic_plugin_class {
	var $currentPlugin = __FILE__;

	function getPluginBaseName() { return plugin_basename($this->currentPlugin); }
	function getChildClassName() { return get_class($this); }

	public function __construct() {
		parent::__construct();

		$post_types = get_post_types( array('public'   => true,'_builtin' => false), 'names', 'and');
		$this->posttypelist=array_merge($this->posttypelist,$post_types);

		foreach($this->posttypelist as $posttype) {
			add_filter('manage_'.$posttype.'_columns', array($this,'my_columns'));
			add_action('manage_'.$posttype.'_custom_column',  array($this,'my_show_columns'));
		}
	}

	function pluginInfoRight($info,$added = false) {
		$post_types = get_post_types( array('public'   => true,'_builtin' => false), 'names', 'and');
		if (empty($post_types)) {
			parent::pluginInfoRight($info);
		} else {
			print "<ul>";
			print '<li><b>'.__("Custom posttypes:",self::FS_TEXTDOMAIN)."</b> ";
			foreach($post_types as $t) {
				print $t.' ';
			}
			print "</li>";
			parent::pluginInfoRight($info,true);
			print "</ul>";
		}
	}

	const FS_TEXTDOMAIN = 'image-to-postlist';
	const FS_PLUGINNAME = 'image-to-postlist';

	public $posttypelist = array('posts','pages');

    function array_insert_after($key, &$array, $new_key, $new_value) {
		if (array_key_exists($key, $array)) {
			$new = array();
			foreach ($array as $k => $value) {
				$new[$k] = $value;
				if ($k === $key) {
					$new[$new_key] = $new_value;
				}
			}
			return $new;
		} else {
			return FALSE;
		}
	}

	function my_columns($columns) {
		$columns = $this->array_insert_after('title',$columns,'fs_image',__('Featured image',self::FS_TEXTDOMAIN));
		return $columns;
	}

	function my_show_columns($name) {
		global $post;
		switch ($name) {
			case 'fs_image':
					$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
					if ($post_thumbnail_id) {
						$thumb = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail');
						echo '<a href="'.admin_url().'post.php?post='.$post->ID.'&action=edit">';
						echo '<img src="'.$thumb[0].'" alt="" style="width:50px"></a>';
					} else {
						echo "--";
					}
		}
	}
}
?>