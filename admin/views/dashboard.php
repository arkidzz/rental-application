<h1 class="wp-heading-inline">Dashboard Application</h1>
<?php
class RATable extends WP_List_Table
{
    function __construct()
    {
        parent::__construct();
    }
    /**
     * @Method name  column_default
     * @Params       $app,$column_name
     * @description  display static column name and corrosponding value
     */
    function column_default($app, $column_name)
    {
        /* display all dynamic data from database  */
        $app_created_on = date('M d, Y', strtotime($app['date_created']));
        $label = '';
        $label_app = '';
        if($app['pay_status'] == "confirmed"){
            $label = "label-success";
        }else{
            $label = "label-primary";
        }
        if($app['app_status'] == "confirmed"){
            $label_app = "label-success";
        }else{
            $label_app = "label-primary";
        }
        switch ($column_name)
        {
            case 'applicant':
                echo strtoupper($app['f_name']);
                break;
            case 'pay_type':
                echo ucfirst($app['pay_type']);
                break;
            case 'pay_status':
                echo '<span class="label '.$label.'">'.ucfirst($app['pay_status']).'</span>';
                break;
            case 'app_status':
                echo '<span class="label '.$label_app.'">'.ucfirst($app['app_status']).'</span>';
                break;
            case 'created_on':
                echo  $app_created_on;
                break;
            default:
                return $app->$column_name;
        }
    }
    /**
     * @Method name  column_name
     * @Params       $app
     * @description  display static column name and corrosponding value
     */
    function column_applicant($app)
    {
        $content = "";
        
        if($app["app_status"] == "Pending"){
            $actions = array(
                'view' => '<a href="' .admin_url('admin.php?page='.RA_PLUGIN_SLUG.'-dashboard&view=view-application&app_id='.$app['app_id']). '">'.__('View', RA_PLUGIN_TEXT_DOMAIN).'</a>',
                'remove' => '<a onclick="javascript: return confirm(\'Please confirm you wish to delete this Application. This cannot be undone.\')"href="' .admin_url('admin.php?page='.RA_PLUGIN_SLUG.'-dashboard&ra_cmd=RAAdmin:deleteApplication&app_id='.$app['app_id']). '">'.__('Remove', RA_PLUGIN_TEXT_DOMAIN).'</a>',
                'approve' => '<a href="' .admin_url('admin.php?page='.RA_PLUGIN_SLUG.'-dashboard&ra_cmd=RAAdmin:approveApp&app_id='.$app['app_id']). '">'.__('Approve', RA_PLUGIN_TEXT_DOMAIN).'</a>'
            );
        }elseif($app["app_status"] == "Denied"){
            $actions = array(
                'view' => '<a href="' .admin_url('admin.php?page='.RA_PLUGIN_SLUG.'-edit-application&app_id='.$app['app_id']). '">'.__('View', RA_PLUGIN_TEXT_DOMAIN).'</a>',
                'remove' => '<a onclick="javascript: return confirm(\'Please confirm you wish to delete this Application. This cannot be undone.\')"href="' .admin_url('admin.php?page='.RA_PLUGIN_SLUG.'-dashboard&ra_cmd=RAAdmin:deleteApplication&app_id='.$app['app_id']). '">'.__('Remove', RA_PLUGIN_TEXT_DOMAIN).'</a>',
                're-open' => '<a href="' .admin_url('admin.php?page='.RA_PLUGIN_SLUG.'-dashboard&ra_cmd=RAAdmin:reOpenApp&app_id='.$app['app_id']). '">'.__('Re-open', RA_PLUGIN_TEXT_DOMAIN).'</a>'
            );
        }else{
            $actions = array(
                'view' => '<a href="' .admin_url('admin.php?page='.RA_PLUGIN_SLUG.'-edit-application&app_id='.$app['app_id']). '">'.__('View', RA_PLUGIN_TEXT_DOMAIN).'</a>',
                'remove' => '<a onclick="javascript: return confirm(\'Please confirm you wish to delete this Application. This cannot be undone.\')"href="' .admin_url('admin.php?page='.RA_PLUGIN_SLUG.'-dashboard&ra_cmd=RAAdmin:deleteApplication&app_id='.$app['app_id']). '">'.__('Remove', RA_PLUGIN_TEXT_DOMAIN).'</a>'
            );
        }

        $content .= strtoupper($app['f_name']).$this->row_actions($actions);
			
        return $content;
    }

    /**
     * @Method name  column_cb
     * @Params       $app
     * @description  display check box for all Application data value
     */
    function column_cb($app)
    {
        return '<input type="checkbox" name="check[]" value="'.$app['app_id'].'" />';
    }

    /**
     * @Method name  get_columns
     * @description  display head tr for table
     */
    function get_columns()
    {
        $columns = array(
            'cb'         => '<input type="checkbox"/>',
            'applicant'  => __('Applicant', RA_PLUGIN_TEXT_DOMAIN),
            'pay_type'   =>__('Payment Type', RA_PLUGIN_TEXT_DOMAIN),
            'pay_status' =>__('Payment Status', RA_PLUGIN_TEXT_DOMAIN),
            'app_status' =>__('Application Status', RA_PLUGIN_TEXT_DOMAIN),
            'created_on' => __('Date Created', RA_PLUGIN_TEXT_DOMAIN)
        );
        return $columns;
    }

    function process_bulk_action()
    {
        extract($_REQUEST);
        if(isset($check))
        {
            if( 'trash' === $this->current_action() )
            {
                $msg = 'delete';
                global $wpdb;
                $RAManagement   = RAManagement::getInstance();
                
                $app_table = $wpdb->prefix."bf_application";
                $app_info = $wpdb->prefix."bf_applicant_info";
                foreach($check as $app_id)
                {
                    $app_query = "DELETE {$app_table}, {$app_info} FROM {$app_table} INNER JOIN {$app_info} WHERE {$app_table}.app_id='".$app_id."' AND {$app_table}.info_id = {$app_info}.info_id";
                    $wpdb->query($app_query);
                }
                $msg = __('Application Removed!', RA_PLUGIN_TEXT_DOMAIN);

                $to_user        = $RAAdmin->getApplicationById($app_id)->other->email;
                $subject_user   = __('Application Removed!', RA_PLUGIN_TEXT_DOMAIN);
                $header_user    = get_bloginfo('name');
                $from_admin     = $RAAdmin->getAdminEmail();
                $message_user   = __('Your application being Removed!' . "\n\n" . 'Application Deleted! Thank you.', RA_PLUGIN_TEXT_DOMAIN);
                
                $RAManagement->sendEmail($to_user, $subject_user, $message_user, $header_user, $from_admin);

                $redirect_url = admin_url("admin.php?page=".RA_PLUGIN_SLUG."-dashboard&ra_msg={$msg}");
                wp_redirect($redirect_url);
            }
        }
    }

    /**
     * @Method name  get_sortable_columns
     * @description  implement sorting on elments included in $sortable_columns array
     */
    function get_sortable_columns()
    {
        $sortable_columns = array(
            'applicant' => array(
                'f_name',
                false
            ),
            'created_on' => array(
                'date_created',
                false
            )
        );
        return $sortable_columns;
    }
    /**
     * @Method name  get_bulk_actions
     * @description  implement bulk action included in $actions array
     */
    function get_bulk_actions()
    {
        $actions = array(
            'trash' => __('Trash', RA_PLUGIN_TEXT_DOMAIN)
        );
        return $actions;
    }

    /**
     * @Method name  prepare_items
     * @description  ready data to display
     */
    function prepare_items()
    {
        
        global $wpdb, $user_ID;
        $app_table = $wpdb->prefix."bf_application";
        $app_info_table = $wpdb->prefix."bf_applicant_info";
        $app_per_page   = 10;
		$getsort = $this->sort_data("pay_type", "desc");
		
        $app_query = "SELECT * FROM {$app_table} AS app_table, {$app_info_table} AS app_info WHERE app_table.info_id = app_info.info_id ORDER BY {$getsort}";

        $app_data = $wpdb->get_results($app_query, ARRAY_A);
        $columns   = $this->get_columns();
        $sortable  = $this->get_sortable_columns();
        $this->process_bulk_action();
        $this->_column_headers = array(
            $columns,
            array(),
            $sortable
        );

        //pagging code starts from here
        $current_page = $this->get_pagenum();
        $total_app = count($app_data);

        $app_data = array_slice(
            $app_data,(
                ($current_page - 1) * $app_per_page
            ),$app_per_page
        );

        $this->items = $app_data;

        $this->set_pagination_args(
            array(
                'total_items'=>$total_app,
                'per_page'=> $app_per_page,
                'total_pages'=>ceil($total_app/$app_per_page)
            )
        );
        //pagging code ends from here
    }

    /**
     * @Method name  sort_data
     * @params $a $b
     * @description  sort product member data
     */
    public function sort_data($column, $order)
    {
        // Set defaults
        /* $order   = 'asc'; */
        // If orderby is set, use this as the sort column
        if (!empty($_GET['orderby']))
        {
            $column = $_GET['orderby'];
        }
        // If order is set use this as the order
        if (!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }
		
		$array = array($column, $order);
		$list = implode(" ", $array);
		
		return $list;
    }
}
?>

<form id="my-application" name="my-application" method="post" action="">
    <?php
		$RATable = new RATable();
		$RATable->prepare_items();
		$RATable->display();
		$RATable->process_bulk_action();
    ?>
</form>