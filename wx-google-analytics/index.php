<?php
/**
 * Plugin Name
 *
 * @package           PluginPackage
 * @author            Webxanh.vn
 * @copyright         2019 GOCRM
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       WX Google Analytics
 * Plugin URI:        http://webxanh.vn
 * Description:       Plugins Insert Google Analytics Code
 * Version:           1.0.0
 * Author:            Webxanh.vn
 * Author URI:        http://webxanh.vn
 * Text Domain:       wx-ga-code
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if(!class_exists('WX_Google_Analytics')){
	class WX_Google_Analytics{
		public $version = '1.0';
		private $txtCode = '';
		public function __construct()
        {
            if(esc_attr( get_option('txtcode'))){
                $this->txtCode = esc_attr( get_option('txtcode'));
            }
            add_action('admin_menu', array($this, 'wx_ga_admin_menu'));
            add_action( 'admin_init', array($this,'wx_add_setting_field') );
            add_action('wp_head', array($this,'wx_ga_insert_head'));
        }
        public function wx_ga_admin_menu(){
            add_options_page('WX Google Analytics', 'WX Google Analytics', 'manage_options', 'wx-google-analytics', array($this, 'wx_ga_admin_option'));
        }
        public function wx_add_setting_field(){
            register_setting( 'wx-settings-group', 'txtcode' );
        }
        public function wx_ga_admin_option(){ ?>
		      <h1>Insert Google Analytics Code</h1>
              <form action="options.php" method="POST">
                  <?php settings_fields( 'wx-settings-group' ); ?>
                  <?php do_settings_sections( 'wx-settings-group' ); ?>
                  <p><?php _e('Code GA Insert:')?></p>
                  <p>
                      <span><input name="txtcode" value="<?php echo $this->txtCode; ?>" style="width: 10%; border: none;" placeholder="UA-00000000-0"></span>
                      <span><?php submit_button(); ?></span>
                  </p>


                  <p><?php _e('Plugins Deverloper Webxanh.vn');?></p>
              </form>
        <?php }
       public function wx_ga_insert_head(){
		    if($this->txtCode) { ?>
           <script type='text/javascript'>
               (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                   (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                   m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
               })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

               ga('create','<?php echo $this->txtCode;?>', 'auto');
               ga('send', 'pageview');

           </script>
       <?php } }
    }
    new WX_Google_Analytics();
}