<?php
class RAAdmin extends RASingleton {
    
    public $table_info;
    public $table_application;
    const VERSION = '1.0.0';

    protected function __construct(){
        global $wpdb;
        $this->table_info = $wpdb->prefix.'bf_applicant_info';
        $this->table_application = $wpdb->prefix.'bf_application';

        add_action( 'admin_menu', array($this,'registerAdminPages') );
        add_action('init', array($this, 'handleCommands'));
        add_action( 'admin_notices', array( $this,'adminNotice') );
        
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueueStyles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueueScripts' ) );
    }

    function registerAdminPages() {
        add_menu_page( RA_PLUGIN_NAME, RA_PLUGIN_NAME, 'edit_dashboard', RA_PLUGIN_SLUG.'-dashboard', array($this,'dashboard') );
        add_submenu_page( RA_PLUGIN_SLUG.'-dashboard', __('Dashboard', RA_PLUGIN_TEXT_DOMAIN), __('Dashboard', RA_PLUGIN_TEXT_DOMAIN), 'edit_dashboard', RA_PLUGIN_SLUG.'-dashboard', array($this,'dashboard') );
		add_submenu_page( RA_PLUGIN_SLUG.'-dashboard', __('Settings', RA_PLUGIN_TEXT_DOMAIN), __('Settings', RA_PLUGIN_TEXT_DOMAIN), 'edit_dashboard', RA_PLUGIN_SLUG.'-settings', array($this,'settings') );
    }

    function handleCommands() {
        if(isset($_REQUEST['ra_cmd'])) {
            $cmd = $_REQUEST['ra_cmd'];
            $cmd = explode(':', $cmd);
            $cmd = array_filter($cmd);
            $callable = false;
            if(count($cmd) == 2) {
                $callable = array($cmd[0], $cmd[1]);
            }
            else {
                $callable = $cmd[0];
            }
            call_user_func($callable);
        }
    }

    function adminNotice() {
        $type = __('updated', RA_PLUGIN_TEXT_DOMAIN);

        if(isset ($_GET['msg']) ) {
            $msg = urldecode($_GET['msg']);
            if(!empty($msg))
            {
                if(isset ($_GET['ra_msg_type']) ) {
                    $type = $_GET['ra_msg_type'];
                }
                ?>
                <div class="<?php echo $type; ?>">
                    <p><?php echo $msg; ?></p>
                </div>
            <?php
            }
        }
    }

    public function enqueueStyles()
    {
        wp_enqueue_style( 'bootstrap' );
        wp_enqueue_style( RA_PLUGIN_SLUG . '-plugin-styles', RA_PLUGIN_URL.'/assets/css/admin.css', array(), RAAdmin::VERSION );

    }

    public function enqueueScripts()
    {
        wp_enqueue_media();
        wp_enqueue_script('jquery');

        wp_enqueue_script( RA_PLUGIN_SLUG . '-plugin-scripts', RA_PLUGIN_URL.'/assets/js/admin.js', array(), NULL, true );
    }

    function dashboard() {
        $view = 'dashboard';
        if(isset($_GET['view']))
            $view = $_GET['view'];

        require(RA_PLUGIN_DIR.'/admin/views/'.$view.'.php');
    }

    function settings() {
        require(RA_PLUGIN_DIR.'/admin/views/settings.php');
    }

    function saveSettings() {
        $RASettings = RASettings::getInstance();

        $RASettings->setSettings('thank_you_page', $_POST['thank_you_page']);
        $RASettings->setSettings('paypal_email', $_POST['paypal_email']);
        $RASettings->setSettings('app_price_1', $_POST['app_price_1']);
        $RASettings->setSettings('app_price_2', $_POST['app_price_2']);
		$RASettings->setSettings('attr_currency', $_POST['attr_currency']);
		$RASettings->setSettings('payment_mode', $_POST['payment_mode']);
		$RASettings->setSettings('send_to_email', $_POST['send_to_email']);
        
        $msg = __('Settings saved successfully', RA_PLUGIN_TEXT_DOMAIN);
        $msg = rawurlencode($msg);
        $redirect_url = admin_url("admin.php?page=".RA_PLUGIN_SLUG."-settings&ra_msg={$msg}");
        wp_redirect($redirect_url);
        exit();
    }

    public function approveApp(){
        global $wpdb;
        $RAAdmin   = RAAdmin::getInstance();
        $RAManagement   = RAManagement::getInstance();

        $app_id = $_GET["app_id"];
        $app_table = $this->table_application;
        
        $qry = $wpdb->query("UPDATE {$app_table} SET app_status = 'Confirmed' WHERE app_id = '{$app_id}'");
        $msg = __("Error",RA_PLUGIN_TEXT_DOMAIN);
        if($qry){
            $msg = __("Successfully Updated",RA_PLUGIN_TEXT_DOMAIN);
        }

        $to_user        = $RAAdmin->getApplicationById($app_id)->other->email;
        $subject_user   = __('Application Successfully Approved!', RA_PLUGIN_TEXT_DOMAIN);
        $header_user    = get_bloginfo('name');
        $from_admin     = $RAAdmin->getAdminEmail();
        $message_user   = __('Your application being Approved!' . "\n\n" . 'Application Approved! Thank you.', RA_PLUGIN_TEXT_DOMAIN);
        
        $RAManagement->sendEmail($to_user, $subject_user, $message_user, $header_user, $from_admin, NULL);

        wp_redirect(admin_url('admin.php?page='.RA_PLUGIN_SLUG.'-dashboard&msg='.$msg));
    }

    public function getApplicationById($app_id){
        global $wpdb;
        $app_table = $this->table_application;
        $app_info = $this->table_info;
        $qry = $wpdb->get_row("SELECT * FROM {$app_table} as app, {$app_info} as info WHERE app.app_id = {$app_id} AND app.info_id = info.info_id");
        if( !empty($qry) ){
            $qry->contact = json_decode($qry->contact);
            $qry->other = json_decode($qry->other);
            $qry->second_applicant = json_decode($qry->second_applicant);
            $qry->additional_occupants = json_decode($qry->additional_occupants);
            $qry->emp_history = json_decode($qry->emp_history);
            $qry->pets = json_decode($qry->pets);
            $qry->miscellaneous = json_decode($qry->miscellaneous);
            $qry->emergency_contact = json_decode($qry->emergency_contact);
            $qry->signature = json_decode($qry->signature);
        }

        return $qry;
    }

    public function getApplicationInfobyId($app_id){
        global $wpdb;
        $app_table = $this->table_application;
        $app_info = $this->table_info;
        $qry = $wpdb->get_row("SELECT * FROM {$app_table} as app, {$app_info} as info WHERE app.app_id = {$app_id} AND app.info_id = info.info_id");
        if( !empty($qry) ){
            $qry->contact = json_decode($qry->contact);
            $qry->other = json_decode($qry->other);
            $qry->second_applicant = json_decode($qry->second_applicant);
            $qry->additional_occupants = json_decode($qry->additional_occupants);
            $qry->emp_history = json_decode($qry->emp_history);
            $qry->pets = json_decode($qry->pets);
            $qry->miscellaneous = json_decode($qry->miscellaneous);
            $qry->emergency_contact = json_decode($qry->emergency_contact);
            $qry->signature = json_decode($qry->signature);
        }

        return $qry;
    }

    public function deleteApplication(){
        global $wpdb;
        $RAAdmin   = RAAdmin::getInstance();
        $RAManagement   = RAManagement::getInstance();
        $app_table = $this->table_application;
        $app_info = $this->table_info;
        $app_id = $_GET["app_id"];
        $app_query = "DELETE {$app_table}, {$app_info} FROM {$app_table} INNER JOIN {$app_info} WHERE {$app_table}.app_id='".$app_id."' AND {$app_table}.info_id = {$app_info}.info_id";

        $wpdb->query($app_query);

        $msg = __('Application Removed!', RA_PLUGIN_TEXT_DOMAIN);

        $to_user        = $RAAdmin->getApplicationById($app_id)->other->email;
        $subject_user   = __('Application Removed!', RA_PLUGIN_TEXT_DOMAIN);
        $header_user    = get_bloginfo('name');
        $from_admin     = $RAAdmin->getAdminEmail();
        $message_user   = __('Your application being Removed!' . "\n\n" . 'Application Deleted! Thank you.', RA_PLUGIN_TEXT_DOMAIN);
        
        $RAManagement->sendEmail($to_user, $subject_user, $message_user, $header_user, $from_admin, NULL);

        wp_redirect(admin_url('admin.php?page='.RA_PLUGIN_SLUG.'-dashboard&msg='.$msg));
    }

    public function getAdminEmail(){
        $admin_email = get_option( 'admin_email' );

        return $admin_email;
    }
}
?>