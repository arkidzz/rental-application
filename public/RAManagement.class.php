<?php
class RAManagement extends RASingleton {
    
    public $table_info;
    public $table_application;
    const VERSION = '1.0.0';

    protected function __construct(){
        global $wpdb;
        $this->table_info = $wpdb->prefix.'bf_applicant_info';
        $this->table_application = $wpdb->prefix.'bf_application';

        add_action( 'init', array( $this, 'initShortcodes' ) );
        add_action('init', array($this, 'handleCommands'));
        
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueueStyles' ), 9999 );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ), 9999 );

        add_action( 'wp_ajax_save_form', array($this, 'saveForm') );
        add_action( 'wp_ajax_nopriv_save_form', array($this, 'saveForm') );

        add_action( 'wp_ajax_ra_paypal_cancel', array($this, 'paypalCancel') );
        add_action( 'wp_ajax_nopriv_ra_paypal_cancel', array($this, 'paypalCancel') );
        
        add_action( 'wp_ajax_ra_paypal_return', array($this, 'paypalReturn') );
        add_action( 'wp_ajax_nopriv_ra_paypal_return', array($this, 'paypalReturn') );
    }

    public function enqueueStyles()
    {
        //wp_enqueue_style( 'bootstrap' );
        wp_enqueue_style( RA_PLUGIN_SLUG . '-bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), RAAdmin::VERSION );
        wp_enqueue_style( RA_PLUGIN_SLUG . '-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css', array(), NULL );
        wp_enqueue_style( RA_PLUGIN_SLUG . '-plugin-styles', RA_PLUGIN_URL.'/assets/css/public.css', array(), RAAdmin::VERSION );

    }

    public function enqueueScripts()
    {
        $RASettings = RASettings::getInstance();
        wp_enqueue_media();
        wp_enqueue_script('jquery');
        
        wp_enqueue_script( RA_PLUGIN_SLUG . '-bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js', array(), NULL, true );
        wp_enqueue_script( RA_PLUGIN_SLUG . '-validate-js', 'https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js', array(), NULL, true );
        wp_enqueue_script( RA_PLUGIN_SLUG . '-validate-additional-methods-js', 'https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js', array(), NULL, true );
        wp_enqueue_script( RA_PLUGIN_SLUG . '-signature_pad-js', RA_PLUGIN_URL.'assets/js/signature_pad-master/js/signature_pad.js', array(), NULL, false );

        wp_enqueue_script( RA_PLUGIN_SLUG . '-plugin-scripts', RA_PLUGIN_URL.'assets/js/public.js', array(), NULL, true );

        $ra_data = array(
			'ajax_url'=>admin_url('admin-ajax.php'),
			'thankyou_url' => add_query_arg(array('fid'=>'{fid}'), get_permalink($RASettings->getSettings('thank_you_page')) )
		);
		wp_localize_script( RA_PLUGIN_SLUG . '-plugin-scripts', 'ra_data', $ra_data );
    }

    function handleCommands() {
		
        if(isset($_REQUEST['ra_pcmd'])) {
            switch($_REQUEST['ra_pcmd']) {
                case 'saveForm':
                    $this->saveForm();
                    break;
                case 'paypalPayment':
                    $this->paypalPayment();
                    break;
            }
        }
    }

    static function activate() {
        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $TableActivate = TableActivate::getInstance();
        $TableActivate->createTable();
    }

    static function deactivate() {
        // code goes here
    }

    function saveForm(){
        global $wpdb;
        $result = array();
        $data = $_POST;
        $no_of_applicant        = 1;
        $f_name                 = $data["f_name"];
        $address                = $data["address"];
        $city                   = $data["city"];
        $state                  = $data["state"];
        $zipcode                = $data["zipcode"];
        $contact                = json_encode($data["contact"], JSON_UNESCAPED_UNICODE);
        $other                  = json_encode($data["other"], JSON_UNESCAPED_UNICODE);
        $second_applicant       = json_encode($data["second_applicant"], JSON_UNESCAPED_UNICODE);
        $additional_occupants   = json_encode($data["additional_occupants"], JSON_UNESCAPED_UNICODE);
        $emp_history            = json_encode($data["emp_history"], JSON_UNESCAPED_UNICODE);
        $pets                   = json_encode($data["pets"], JSON_UNESCAPED_UNICODE);
        $miscellaneous          = json_encode($data["miscellaneous"], JSON_UNESCAPED_UNICODE);
        $emergency_contact      = json_encode($data["emergency_contact"], JSON_UNESCAPED_UNICODE);
        $signature              = json_encode($data["signature"], JSON_UNESCAPED_UNICODE);
        $date_created           = date("Y-m-d H:m");
        $interested_in          = $data["interested_in"];
        $how_many_people        = $data["how_many_people"];

        if( ! empty( $_FILES ) ) {
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            require_once(ABSPATH . "wp-admin" . '/includes/file.php');
            require_once(ABSPATH . "wp-admin" . '/includes/media.php');
            
            $supported_types = array(
                'application/pdf',
                'image/jpeg',
                'image/jpg',
                'image/png'
             );
            
            $file_arr_income = $this->reArrayFiles($_FILES['proof_of_income']);
            $file_urls_income = [];
            $file_urls_income_name = [];

            foreach ($file_arr_income as $file) {
                $arr_file_type = wp_check_filetype(basename($file['name']));
                $uploaded_type = $arr_file_type['type'];
                
                if (in_array($uploaded_type, $supported_types)) {
                    $upload = wp_upload_bits($file['name'], null, file_get_contents($file['tmp_name']));
                    if (isset($upload['error']) && $upload['error'] != 0) {
                        wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
                    } else {
                        array_push($file_urls_income, $upload['url']);
                        array_push($file_urls_income_name, $upload["file"]);
                    }
                } else {
                    wp_die("This filetype is not available!");
                }
            }

            $proof_of_income_url        = $file_urls_income;
            $proof_of_income_url_name   = $file_urls_income_name;

            $file_arr_drivers = $this->reArrayFiles($_FILES['drivers_id']);
            $file_urls_drivers = [];
            $file_urls_drivers_name = [];

            foreach ($file_arr_drivers as $file) {
                $arr_file_type = wp_check_filetype(basename($file['name']));
                $uploaded_type = $arr_file_type['type'];
                
                if (in_array($uploaded_type, $supported_types)) {
                    $upload = wp_upload_bits($file['name'], null, file_get_contents($file['tmp_name']));
                    if (isset($upload['error']) && $upload['error'] != 0) {
                        wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
                    } else {
                        array_push($file_urls_drivers, $upload['url']);
                        array_push($file_urls_drivers_name, $upload["file"]);
                    }
                } else {
                    wp_die("This filetype is not available!");
                }
            }
            
            $proof_of_drivers_url        = $file_urls_drivers;
            $proof_of_drivers_url_name   = $file_urls_drivers_name;

            $pet_image_url          = wp_upload_bits($_FILES["pet_image"]["name"], null, file_get_contents($_FILES["pet_image"]["tmp_name"]));

            $pet_image               = $pet_image_url["url"];
            $pet_image_name          = $pet_image_url["file"];
            $drivers_id              = json_encode($proof_of_drivers_url, JSON_UNESCAPED_UNICODE);
            $drivers_id_name         = json_encode($proof_of_drivers_url_name, JSON_UNESCAPED_UNICODE);
            $proof_of_income         = json_encode($proof_of_income_url, JSON_UNESCAPED_UNICODE);
            $proof_of_income_name    = json_encode($proof_of_income_url_name, JSON_UNESCAPED_UNICODE);
        }

        if($additional_occupants["f_name"] != ""){
            $no_of_applicant = 2;
        }

        $info = $wpdb->query("INSERT INTO {$this->table_info} SET f_name = '$f_name', address = '$address', city = '$city', state = '$state', zipcode = '$zipcode', contact = '$contact', other = '$other', second_applicant = '$second_applicant', additional_occupants = '$additional_occupants', emp_history = '$emp_history', pets = '$pets', miscellaneous = '$miscellaneous', emergency_contact = '$emergency_contact', signature = '$signature', pet_image = '$pet_image', proof_of_income = '$proof_of_income', drivers_id = '$drivers_id', pet_image_name = '$pet_image_name', proof_of_income_name = '$proof_of_income_name', drivers_id_name = '$drivers_id_name', interested_in = '$interested_in', how_many_people = '$how_many_people'");
        $info_id = $wpdb->insert_id;

        /* Old Function with Paypal */
        // if(count($info) > 0){
        //     $wpdb->query("INSERT INTO {$this->table_application} SET info_id = '$info_id',pay_type = 'paypal', pay_status = 'pending', date_created = '$date_created'");
        //     $app_id = $wpdb->insert_id;
        //     $paypal_url = $this->paypalPayment($app_id, $no_of_applicant);
        // }
        /* End Old Function with Paypal */

        if(count($info) > 0){
            $wpdb->query("INSERT INTO {$this->table_application} SET info_id = '$info_id',pay_type = 'paypal', pay_status = 'confirmed', date_created = '$date_created', app_status = 'Pending' ");
            $app_id = $wpdb->insert_id;
            $paypal_url = site_url(). '\/thank-you/';

            $RASettings = RASettings::getInstance();
            $RAAdmin    = RAAdmin::getInstance();

            //$data           = $_REQUEST;
            //$date_payment   = date("Y-m-d H:m", strtotime($data["payment_date"]));
            //$app_id         = $data['app_id'];
            //$status         = __('confirmed', RA_PLUGIN_TEXT_DOMAIN);
            //$amount         = $data["payment_gross"];

            /* Send Email to User & Admin Template */
            if(!empty($RASettings->getSettings("send_to_email"))){
                $email_admin = $RASettings->getSettings("send_to_email");
            }else{
                $email_admin = $RAAdmin->getAdminEmail();
            }
            $to_user        = $RAAdmin->getApplicationById($app_id)->other->email;
            $subject_user   = __('Application Submitted!', RA_PLUGIN_TEXT_DOMAIN);
            $header_user    = get_bloginfo('name');
            $from_admin     = $email_admin;
            $message_user   = __('Your application was successfully submitted!' . "\n\n" . 'We will review your application and email you for further information. Thank you!', RA_PLUGIN_TEXT_DOMAIN);

            $to_admin        = $email_admin;
            $subject_admin   = __('New Application Received!', RA_PLUGIN_TEXT_DOMAIN);
            $header_admin    = strtoupper($RAAdmin->getApplicationById($app_id)->f_name);
            $from_user       = $RAAdmin->getApplicationById($app_id)->other->email;
            $message_admin = "";
            $message_admin   .= "<p>".__('NEW application was Added!' . "\n\n" . 'Application Received and ready to view to your application list!', RA_PLUGIN_TEXT_DOMAIN)."</p>";

            $getData = $RAAdmin->getApplicationById($app_id);
            $dob = date("M d, Y", strtotime($getData->other->dob));

            $emp_history = "";
            if(!empty($getData->emp_history)){
                $count = 1;
                $emp_history .= "<h4>Employment History</h4>";
                foreach($getData->emp_history as $key => $history):

                    $his_emp = ( $history->cur_emp != '' ) ? $history->cur_emp : 'None';
                    $his_address = ( $history->address != '' ) ? $history->address : 'None';
                    $his_city = ( $history->city != '' ) ? $history->city : 'None';
                    $his_state = ( $history->state != '' ) ? $history->state : 'None';
                    $his_zip = ( $history->zipcode != '' ) ? $history->zipcode : 'None';
                    $his_phone = ( $history->phone != '' ) ? $history->phone : 'None';
                    $his_long = ( $history->how_long != '' ) ? $history->how_long : 'None';
                    $his_paid = ( $history->paid != '' ) ? $history->paid : 'None';

                    $emp_history .= "
                        <table>
                            <tr>
                                <td><strong>Applicant {$count}</strong></td>
                            </tr>
                            <tr>
                                <td><span class='info-label'>Current Employer:</span></td>
                                <td>{$his_emp}</td>
                            </tr>
                            <tr>
                                <td><span class='info-label'>Address:</span></td>
                                <td>{$his_address}</td>
                            </tr>
                            <tr>
                                <td><span class='info-label'>City:</span></td>
                                <td>{$his_city}</td>
                            </tr>
                            <tr>
                                <td><span class='info-label'>State:</span></td>
                                <td>{$his_state}</td>
                            </tr>
                            <tr>
                                <td><span class='info-label'>Zipcode:</span></td>
                                <td>{$his_zip}</td>
                            </tr>
                            <tr>
                                <td><span class='info-label'>Phone:</span></td>
                                <td>{$his_phone}</td>
                            </tr>
                            <tr>
                                <td><span class='info-label'>How Long:</span></td>
                                <td>{$his_long}</td>
                            </tr>
                            <tr>
                                <td><span class='info-label'>How are you getting paid?</span></td>
                                <td>{$his_paid}</td>
                            </tr>
                        </table>";
                    $count++;
                endforeach;
            }

            $additional_occupants = "";
            if(!empty($getData->additional_occupants)){
                $count = 1;
                $additional_occupants .= "<h4>Additional Occupants</h4>";
                foreach($getData->additional_occupants as $key => $occupants):
                $occ_name       = ( $occupants->name != '' ) ? $occupants->name : 'None';
                $occ_dob        = ( $occupants->dob != '' ) ? date('F d, Y',strtotime($occupants->dob)) : 'None';
                $occ_relation   = ( $occupants->relation != '' ) ? $occupants->relation : 'None';

                $additional_occupants .= "
                    <table>
                        <tr>
                            <td><h4><strong>Occupant {$count}</strong></h4></td>
                        </tr>
                        <tr>
                            <td><span class='info-label'>Name:</span></td>
                            <td>{$occ_name}</td>
                        </tr>
                        <tr>
                            <td><span class='info-label'>Date of Birth:</span></td>
                            <td>{$occ_dob}</td>
                        </tr>
                        <tr>
                            <td><span class='info-label'>Relation:</span></td>
                            <td>{$occ_relation}</td>
                        </tr>
                    </table>";
                    
                    $count++;
                endforeach;
            }

            $second_applicant = "";
            if(!empty($getData->second_applicant)){
                $sec_dob = date("M d, Y", strtotime($getData->second_applicant->dob));
                $second_applicant .= "
                    <h4>Second Applicant</h4>
                    <table>
                        <tr><td>Full Name: </td><td>{$getData->second_applicant->f_name}</td></tr>
                        <tr><td>Email: </td><td>{$getData->second_applicant->email}</td></tr>
                        <tr><td>Address: </td><td>{$getData->second_applicant->address}, {$getData->second_applicant->zipcode}</td></tr>
                        <tr><td>City: </td><td>{$getData->second_applicant->city}</td></tr>
                        <tr><td>State: </td><td>{$getData->second_applicant->state}</td></tr>
                        <tr><td>Home Phone: </td><td>{$getData->second_applicant->h_phone}</td></tr>
                        <tr><td>Contact Phone: </td><td>{$getData->second_applicant->c_phone}</td></tr>
                        <tr><td>SSS #: </td><td>{$getData->second_applicant->ss_number}</td></tr>
                        <tr><td>Birth date: </td><td>{$sec_dob}</td></tr>
                    </table>
                ";
            }

            $pets = "";
            if( empty( $getData->pets ) ):
                $pets .= "<h4>No Pets</h4>";
            else: 
                $no_pets = ( $getData->pets->Y->no_pets != '' ) ? $getData->pets->Y->no_pets : 'None';
                $breed_pets = ( $getData->pets->Y->breed != '' ) ? $getData->pets->Y->breed : 'None';
                $desc_pets = ( $getData->pets->Y->desc != '' ) ? $getData->pets->Y->desc : 'None';
                $lbs_pets = ( $getData->pets->Y->lbs != '' ) ? $getData->pets->Y->lbs : 'None';

                $pets .= "
                <h4>Pets</h4>
                <table>
                    <tr>
                        <td><span class='info-label'>No of Pets:</span></td>
                        <td>{$no_pets}</td>
                    </tr>
                    <tr>
                        <td><span class='info-label'>Breed:</span></td>
                        <td>{$breed_pets}</td>
                    </tr>
                    <tr>
                        <td><span class='info-label'>Description:</span></td>
                        <td>{$desc_pets}</td>
                    </tr>
                    <tr>
                        <td><span class='info-label'>LBS:</span></td>
                        <td>{$lbs_pets}</td>
                    </tr>
                </table>";
            endif;

            $convicted = "";
            if( !empty( $getData->miscellaneous ) ):
                $con        = ( $getData->miscellaneous->convicted_felony != '' ) ? $getData->miscellaneous->convicted_felony : 'None';
                $evc        = ( $getData->miscellaneous->evicted != '' ) ? $getData->miscellaneous->evicted : 'None';
                $explain    = ( $getData->miscellaneous->explain != '' ) ? $getData->miscellaneous->explain : 'None';

                $convicted .= "
                <h4>Have you ever been:</h4>
                <table>
                    <tr>
                        <td><span class='info-label'>Convicted of a Felony?</span></td>
                        <td>{$con}</td>
                    </tr>
                    <tr>
                        <td><span class='info-label'>Evicted?</span></td>
                        <td>$evc</td>
                    </tr>
                    <tr>
                        <td><span class='info-label'>Explain:</span></td>
                        <td>{$explain}</td>
                    </tr>
                </table>";
            endif;

            $emergency_contact = "";
            if( !empty( $getData->emergency_contact ) ):
                $count = 1;

                foreach($getData->emergency_contact as $key => $em_contact):
                    $emer_name = ( $em_contact->name != '' ) ? $em_contact->name : 'None';
                    $emer_relation = ( $em_contact->relation != '' ) ? $em_contact->relation : 'None';
                    $emer_address = ( $em_contact->address != '' ) ? $em_contact->address : 'None';
                    $emer_city = ( $em_contact->city != '' ) ? $em_contact->city : 'None';
                    $emer_state = ( $em_contact->state != '' ) ? $em_contact->state : 'None';
                    $emer_zip = ( $em_contact->zipcode != '' ) ? $em_contact->zipcode : 'None';
                    $emer_phone = ( $em_contact->phone != '' ) ? $em_contact->phone : 'None';

                    $emergency_contact .= "
                        <h4><strong>Emergency Contact {$count}</strong></h4>
                        <table >
                            <tr>
                                <td><span class='info-label'>Name:</span></td>
                                <td>{$emer_name}</td>
                            </tr>
                            <tr>
                                <td><span class='info-label'>Relation:</span></td>
                                <td>{$emer_relation}</td>
                            </tr>
                            <tr>
                                <td><span class='info-label'>Address:</span></td>
                                <td>{$emer_address}</td>
                            </tr>
                            <tr>
                                <td><span class='info-label'>City:</span></td>
                                <td>{$emer_city}</td>
                            </tr>
                            <tr>
                                <td><span class='info-label'>State:</span></td>
                                <td>{$emer_state}</td>
                            </tr>
                            <tr>
                                <td><span class='info-label'>Zipcode:</span></td>
                                <td>$emer_zip</td>
                            </tr>
                            <tr>
                                <td><span class='info-label'>Phone:</span></td>
                                <td>$emer_phone</td>
                            </tr>
                        </table>";
                    $count++;
                endforeach;
            endif;

            $signature = "";
            if( !empty( $getData->signature ) ):
                $signature .= '<h4><strong>Signature</strong></h4>';
                $count = 1;
                $signature .= '<div id="signature" class="tabs__content hide">';
                    foreach($getData->signature as $key => $sign):
                        $signature .= "<h4><strong>Applicant {$count}</strong></h4>";
                        $signature .= "<img src='{$sign->signature}' />";
                        $count++;
                    endforeach;
                $signature .= '</div>';
            endif;

            $message_admin .= "
                <table>
                    <tr><td>Full Name: </td><td>{$getData->f_name}</td></tr>
                    <tr><td>Address: </td><td>{$getData->address}, {$getData->zipcode}</td></tr>
                    <tr><td>City: </td><td>{$getData->city}</td></tr>
                    <tr><td>State: </td><td>{$getData->state}</td></tr>
                    <tr><td>Home Phone: </td><td>{$getData->contact->h_phone}</td></tr>
                    <tr><td>Contact Phone: </td><td>{$getData->contact->c_phone}</td></tr>
                    <tr><td>Email: </td><td>{$getData->other->email}</td></tr>
                    <tr><td>SSS #: </td><td>{$getData->other->ss_number}</td></tr>
                    <tr><td>Birth date: </td><td>{$dob}</td></tr>
                    <tr><td>Interested In: </td><td>{$getData->other->interested_in}</td></tr>
                    <tr><td>How Many People 18+ Years Old Will Be Residing In Home?</td><td>{$getData->other->how_many_people}</td></td>
                </table>";
                $message_admin .= "{$second_applicant}";
                $message_admin .= "{$additional_occupants}";
                $message_admin .= "{$emp_history}";
                $message_admin .= "{$pets}";
                $message_admin .= "{$convicted}";
                $message_admin .= "{$emergency_contact}";
                //$message_admin .= "{$signature}";

            $attachments = array();

            $attachments[] = "$getData->pet_image_name";
            $attachments[] = "$getData->drivers_id_name";
            
            $drivers_data = json_decode($getData->drivers_id_name);
            foreach($drivers_data as $k=>$v){
                $attachments[] = "$v";
            }

            $proof_data = json_decode($getData->proof_of_income_name);
            foreach($proof_data as $k=>$v){
                $attachments[] = "$v";
            }

            $this->sendEmail($to_user, $subject_user, $message_user, $header_user, $from_admin, NULL);
            $this->sendEmail($to_admin, $subject_admin, $message_admin, $header_admin, $from_user, $attachments);
        }
        

        $result["url"] = $paypal_url;
        echo json_encode($result);
        
        exit;
    }

    function reArrayFiles(&$file_post) {
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
    
        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
    
        return $file_ary;
    }

    function paypalPayment($app_id, $no_of_applicant){
        $RASettings = RASettings::getInstance();
        $sel_currency = $RASettings->getSettings('attr_currency');

        $paypal_vars = array();
        $paypal_vars['cmd'] = __('_xclick', RA_PLUGIN_TEXT_DOMAIN);
        $paypal_vars['currency_code'] = $sel_currency;
        $paypal_vars['cbt'] = __('Click here to complete your Application', RA_PLUGIN_TEXT_DOMAIN);
        $paypal_vars['rm'] = "2";
        
        $paypal_vars['business'] = $RASettings->getSettings('paypal_email');
        $paypal_vars['item_name'] = __('Application', RA_PLUGIN_TEXT_DOMAIN);
        $paypal_vars['item_number'] = $app_id;

        if($no_of_applicant == 2){
            $amount = $RASettings->getSettings('app_price_2');
        }else{
            $amount = $RASettings->getSettings('app_price_1');
        }
        $paypal_vars['amount'] = $amount;
        $payment_status = "confirmed";
        
        $paypal_vars['return'] = add_query_arg(array('app_id'=>$app_id,'payment_status'=>$payment_status,'vars'=>$paypal_vars, 'action'=>'ra_paypal_return'), admin_url('admin-ajax.php'));
        $paypal_vars['cancel_return'] = add_query_arg(array('app_id'=>$app_id, 'action'=>'ra_paypal_cancel'), admin_url('admin-ajax.php'));
        $paypal_vars['notify_url'] = add_query_arg(array('app_id'=>$app_id, 'action'=>'ra_paypal_notify'), admin_url('admin-ajax.php'));

        $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
        
        if($RASettings->getSettings('payment_mode') == 'sandbox'){
            $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        }
        
        //var_dump($paypal_vars);
        //die();
        $paypal_url = $paypal_url.'?'.http_build_query($paypal_vars);
        return $paypal_url;
        //header('location:'.$paypal_url);
        exit;
    }

    function paypalCancel() {
        $RASettings = RASettings::getInstance();
        /* Delete the Application */
        $app_id = $_REQUEST['app_id'];
        $this->deleteApplication($app_id);

        wp_redirect( get_permalink($RASettings->getSettings('payment_cancel_page')) );
        exit;
        //print_r($_REQUEST);die();
    }

    function paypalReturn() {
        global $wpdb;
        $RASettings = RASettings::getInstance();
        $RAAdmin    = RAAdmin::getInstance();

        $data           = $_REQUEST;
        $date_payment   = date("Y-m-d H:m", strtotime($data["payment_date"]));
        $app_id         = $data['app_id'];
        $status         = __('confirmed', RA_PLUGIN_TEXT_DOMAIN);
        $amount         = $data["payment_gross"];

        /* Send Email to User & Admin Template */
        if(!empty($RASettings->getSettings("send_to_email"))){
            $email_admin = $RASettings->getSettings("send_to_email");
        }else{
            $email_admin = $RAAdmin->getAdminEmail();
        }
        $to_user        = $RAAdmin->getApplicationById($app_id)->other->email;
        $subject_user   = __('Application Submitted!', RA_PLUGIN_TEXT_DOMAIN);
        $header_user    = get_bloginfo('name');
        $from_admin     = $email_admin;
        $message_user   = __('Your application was successfully submitted!' . "\n\n" . 'We will review your application and email you for further information. Thank you!', RA_PLUGIN_TEXT_DOMAIN);

        $to_admin        = $email_admin;
        $subject_admin   = __('New Application Received!', RA_PLUGIN_TEXT_DOMAIN);
        $header_admin    = strtoupper($RAAdmin->getApplicationById($app_id)->f_name);
        $from_user       = $RAAdmin->getApplicationById($app_id)->other->email;
        $message_admin = "";
        $message_admin   .= "<p>".__('NEW application was Added!' . "\n\n" . 'Application Received and ready to view to your application list!', RA_PLUGIN_TEXT_DOMAIN)."</p>";

        $getData = $RAAdmin->getApplicationById($app_id);
        $dob = date("M d, Y", strtotime($getData->other->dob));

        $emp_history = "";
        if(!empty($getData->emp_history)){
            $count = 1;
            $emp_history .= "<h4>Employment History</h4>";
            foreach($getData->emp_history as $key => $history):

                $his_emp = ( $history->cur_emp != '' ) ? $history->cur_emp : 'None';
                $his_address = ( $history->address != '' ) ? $history->address : 'None';
                $his_city = ( $history->city != '' ) ? $history->city : 'None';
                $his_state = ( $history->state != '' ) ? $history->state : 'None';
                $his_zip = ( $history->zipcode != '' ) ? $history->zipcode : 'None';
                $his_phone = ( $history->phone != '' ) ? $history->phone : 'None';
                $his_long = ( $history->how_long != '' ) ? $history->how_long : 'None';

                $emp_history .= "
                    <table>
                        <tr>
                            <td><strong>Applicant {$count}</strong></td>
                        </tr>
                        <tr>
                            <td><span class='info-label'>Current Employer:</span></td>
                            <td>{$his_emp}</td>
                        </tr>
                        <tr>
                            <td><span class='info-label'>Address:</span></td>
                            <td>{$his_address}</td>
                        </tr>
                        <tr>
                            <td><span class='info-label'>City:</span></td>
                            <td>{$his_city}</td>
                        </tr>
                        <tr>
                            <td><span class='info-label'>State:</span></td>
                            <td>{$his_state}</td>
                        </tr>
                        <tr>
                            <td><span class='info-label'>Zipcode:</span></td>
                            <td>{$his_zip}</td>
                        </tr>
                        <tr>
                            <td><span class='info-label'>Phone:</span></td>
                            <td>{$his_phone}</td>
                        </tr>
                        <tr>
                            <td><span class='info-label'>How Long:</span></td>
                            <td>{$his_long}</td>
                        </tr>
                    </table>";
                $count++;
            endforeach;
        }

        $additional_occupants = "";
        if(!empty($getData->additional_occupants)){
            $count = 1;
            $additional_occupants .= "<h4>Additional Occupants</h4>";
            foreach($getData->additional_occupants as $key => $occupants):
            $occ_name       = ( $occupants->name != '' ) ? $occupants->name : 'None';
            $occ_dob        = ( $occupants->dob != '' ) ? date('F d, Y',strtotime($occupants->dob)) : 'None';
            $occ_relation   = ( $occupants->relation != '' ) ? $occupants->relation : 'None';

            $additional_occupants .= "
                <table>
                    <tr>
                        <td><h4><strong>Occupant {$count}</strong></h4></td>
                    </tr>
                    <tr>
                        <td><span class='info-label'>Name:</span></td>
                        <td>{$occ_name}</td>
                    </tr>
                    <tr>
                        <td><span class='info-label'>Date of Birth:</span></td>
                        <td>{$occ_dob}</td>
                    </tr>
                    <tr>
                        <td><span class='info-label'>Relation:</span></td>
                        <td>{$occ_relation}</td>
                    </tr>
                </table>";
                
                $count++;
            endforeach;
        }

        $second_applicant = "";
        if(!empty($getData->second_applicant)){
            $sec_dob = date("M d, Y", strtotime($getData->second_applicant->dob));
            $second_applicant .= "
                <h4>Second Applicant</h4>
                <table>
                    <tr><td>Full Name: </td><td>{$getData->second_applicant->f_name}</td></tr>
                    <tr><td>Email: </td><td>{$getData->second_applicant->email}</td></tr>
                    <tr><td>Address: </td><td>{$getData->second_applicant->address}, {$getData->second_applicant->zipcode}</td></tr>
                    <tr><td>City: </td><td>{$getData->second_applicant->city}</td></tr>
                    <tr><td>State: </td><td>{$getData->second_applicant->state}</td></tr>
                    <tr><td>Home Phone: </td><td>{$getData->second_applicant->h_phone}</td></tr>
                    <tr><td>Contact Phone: </td><td>{$getData->second_applicant->c_phone}</td></tr>
                    <tr><td>SSS #: </td><td>{$getData->second_applicant->ss_number}</td></tr>
                    <tr><td>Birth date: </td><td>{$sec_dob}</td></tr>
                </table>
            ";
        }

        $pets = "";
        if( empty( $getData->pets ) ):
            $pets .= "<h4>No Pets</h4>";
        else: 
            $no_pets = ( $getData->pets->Y->no_pets != '' ) ? $getData->pets->Y->no_pets : 'None';
            $breed_pets = ( $getData->pets->Y->breed != '' ) ? $getData->pets->Y->breed : 'None';
            $desc_pets = ( $getData->pets->Y->desc != '' ) ? $getData->pets->Y->desc : 'None';
            $lbs_pets = ( $getData->pets->Y->lbs != '' ) ? $getData->pets->Y->lbs : 'None';

            $pets .= "
            <h4>Pets</h4>
            <table>
                <tr>
                    <td><span class='info-label'>No of Pets:</span></td>
                    <td>{$no_pets}</td>
                </tr>
                <tr>
                    <td><span class='info-label'>Breed:</span></td>
                    <td>{$breed_pets}</td>
                </tr>
                <tr>
                    <td><span class='info-label'>Description:</span></td>
                    <td>{$desc_pets}</td>
                </tr>
                <tr>
                    <td><span class='info-label'>LBS:</span></td>
                    <td>{$lbs_pets}</td>
                </tr>
            </table>";
        endif;

        $convicted = "";
        if( !empty( $getData->miscellaneous ) ):
            $con        = ( $getData->miscellaneous->convicted_felony != '' ) ? $getData->miscellaneous->convicted_felony : 'None';
            $evc        = ( $getData->miscellaneous->evicted != '' ) ? $getData->miscellaneous->evicted : 'None';
            $explain    = ( $getData->miscellaneous->explain != '' ) ? $getData->miscellaneous->explain : 'None';

            $convicted .= "
            <h4>Have you ever been:</h4>
            <table>
                <tr>
                    <td><span class='info-label'>Convicted of a Felony?</span></td>
                    <td>{$con}</td>
                </tr>
                <tr>
                    <td><span class='info-label'>Evicted?</span></td>
                    <td>$evc</td>
                </tr>
                <tr>
                    <td><span class='info-label'>Explain:</span></td>
                    <td>{$explain}</td>
                </tr>
            </table>";
        endif;

        $emergency_contact = "";
        if( !empty( $getData->emergency_contact ) ):
            $count = 1;

            foreach($getData->emergency_contact as $key => $em_contact):
                $emer_name = ( $em_contact->name != '' ) ? $em_contact->name : 'None';
                $emer_relation = ( $em_contact->relation != '' ) ? $em_contact->relation : 'None';
                $emer_address = ( $em_contact->address != '' ) ? $em_contact->address : 'None';
                $emer_city = ( $em_contact->city != '' ) ? $em_contact->city : 'None';
                $emer_state = ( $em_contact->state != '' ) ? $em_contact->state : 'None';
                $emer_zip = ( $em_contact->zipcode != '' ) ? $em_contact->zipcode : 'None';
                $emer_phone = ( $em_contact->phone != '' ) ? $em_contact->phone : 'None';

                $emergency_contact .= "
                    <h4><strong>Emergency Contact {$count}</strong></h4>
                    <table >
                        <tr>
                            <td><span class='info-label'>Name:</span></td>
                            <td>{$emer_name}</td>
                        </tr>
                        <tr>
                            <td><span class='info-label'>Relation:</span></td>
                            <td>{$emer_relation}</td>
                        </tr>
                        <tr>
                            <td><span class='info-label'>Address:</span></td>
                            <td>{$emer_address}</td>
                        </tr>
                        <tr>
                            <td><span class='info-label'>City:</span></td>
                            <td>{$emer_city}</td>
                        </tr>
                        <tr>
                            <td><span class='info-label'>State:</span></td>
                            <td>{$emer_state}</td>
                        </tr>
                        <tr>
                            <td><span class='info-label'>Zipcode:</span></td>
                            <td>$emer_zip</td>
                        </tr>
                        <tr>
                            <td><span class='info-label'>Phone:</span></td>
                            <td>$emer_phone</td>
                        </tr>
                    </table>";
                $count++;
            endforeach;
        endif;

        $signature = "";
        if( !empty( $getData->signature ) ):
            $signature .= '<h4><strong>Signature</strong></h4>';
            $count = 1;
            $signature .= '<div id="signature" class="tabs__content hide">';
                foreach($getData->signature as $key => $sign):
                    $signature .= "<h4><strong>Applicant {$count}</strong></h4>";
                    $signature .= "<img src='{$sign->signature}' />";
                    $count++;
                endforeach;
            $signature .= '</div>';
        endif;

        $message_admin .= "
            <table>
                <tr><td>Full Name: </td><td>{$getData->f_name}</td></tr>
                <tr><td>Address: </td><td>{$getData->address}, {$getData->zipcode}</td></tr>
                <tr><td>City: </td><td>{$getData->city}</td></tr>
                <tr><td>State: </td><td>{$getData->state}</td></tr>
                <tr><td>Home Phone: </td><td>{$getData->contact->h_phone}</td></tr>
                <tr><td>Contact Phone: </td><td>{$getData->contact->c_phone}</td></tr>
                <tr><td>Email: </td><td>{$getData->other->email}</td></tr>
                <tr><td>SSS #: </td><td>{$getData->other->ss_number}</td></tr>
                <tr><td>Birth date: </td><td>{$dob}</td></tr>
                <tr><td>Interested In: </td><td>{$getData->other->interested_in}</td></tr>
                <tr><td>How Many People 18+ Years Old Will Be Residing In Home?</td><td>{$getData->other->how_many_people}</td></td>
            </table>";
            $message_admin .= "{$second_applicant}";
            $message_admin .= "{$additional_occupants}";
            $message_admin .= "{$emp_history}";
            $message_admin .= "{$pets}";
            $message_admin .= "{$convicted}";
            $message_admin .= "{$emergency_contact}";
            //$message_admin .= "{$signature}";

        $attachments = array();

        $attachments[] = "$getData->pet_image_name";
        $attachments[] = "$getData->drivers_id_name";
        
        $drivers_data = json_decode($getData->drivers_id_name);
        foreach($drivers_data as $k=>$v){
            $attachments[] = "$v";
        }

        $proof_data = json_decode($getData->proof_of_income_name);
        foreach($proof_data as $k=>$v){
            $attachments[] = "$v";
        }

        /* Send Email to User & Admin Template END*/

		// $app_data['pay_status'] = $status;
        // $app_data['payment_data'] = array(
        //     'txn_id'=>$data['txn_id'],
        //     'raw_data'=> base64_encode(json_encode($data)),
        //     'payment_method'=> __('paypal', RA_PLUGIN_TEXT_DOMAIN)
        // );

        // $payment_data = json_encode($app_data['payment_data'], JSON_UNESCAPED_UNICODE);

        // $wpdb->query("UPDATE {$this->table_application} SET pay_trans_id = '{$data['txn_id']}', amount_paid = '$amount', pay_status = '$status', date_payment = '$date_payment', payment_data = '{$payment_data}' WHERE app_id = '$app_id'");
        
        /* Send Email to User & Admin */
        $this->sendEmail($to_user, $subject_user, $message_user, $header_user, $from_admin, NULL);
        $sendToAdmin = $this->sendEmail($to_admin, $subject_admin, $message_admin, $header_admin, $from_user, $attachments);
		
        if($sendToAdmin){
            /* Redirect to thank you page */
            wp_redirect( get_permalink( $RASettings->getSettings('thank_you_page') ) );
            //echo 'Payment completed..';
        }else{
            echo 'Error';
        }

        exit;
    }

    function performSendEmail($app_id) {
        global $wpdb;
        

        /* Send Email to User & Admin Template END*/

		// $app_data['pay_status'] = $status;
        // $app_data['payment_data'] = array(
        //     'txn_id'=>$data['txn_id'],
        //     'raw_data'=> base64_encode(json_encode($data)),
        //     'payment_method'=> __('paypal', RA_PLUGIN_TEXT_DOMAIN)
        // );

        // $payment_data = json_encode($app_data['payment_data'], JSON_UNESCAPED_UNICODE);

        // $wpdb->query("UPDATE {$this->table_application} SET pay_trans_id = '{$data['txn_id']}', amount_paid = '$amount', pay_status = '$status', date_payment = '$date_payment', payment_data = '{$payment_data}' WHERE app_id = '$app_id'");
        
        /* Send Email to User & Admin */
        $this->sendEmail($to_user, $subject_user, $message_user, $header_user, $from_admin, NULL);
        $this->sendEmail($to_admin, $subject_admin, $message_admin, $header_admin, $from_user, $attachments);
		
        // if($sendToAdmin){
        //     /* Redirect to thank you page */
        //     wp_redirect( get_permalink( $RASettings->getSettings('thank_you_page') ) );
        //     //echo 'Payment completed..';
        // }else{
        //     echo 'Error';
        // }

        exit;
    }

    function deleteApplication($app_id){
        global $wpdb;
        $RAAdmin   = RAAdmin::getInstance();
        $RASettings   = RASettings::getInstance();
        $app_table = $wpdb->prefix."bf_application";
        $app_info  = $wpdb->prefix."bf_applicant_info";

        $app_query = "DELETE {$app_table}, {$app_info} FROM {$app_table} INNER JOIN {$app_info} WHERE {$app_table}.app_id='".$app_id."' AND {$app_table}.info_id = {$app_info}.info_id";

        $wpdb->query($app_query);

        if(!empty($RASettings->getSettings("send_to_email"))){
            $email_admin = $RASettings->getSettings("send_to_email");
        }else{
            $email_admin = $RAAdmin->getAdminEmail();
        }

        $to_user        = $RAAdmin->getApplicationById($app_id)->other->email;
        $subject_user   = __('Application Removed!', RA_PLUGIN_TEXT_DOMAIN);
        $header_user    = get_bloginfo('name');
        $from_admin     = $email_admin;
        $message_user   = __('Your application being Removed!' . "\n\n" . 'Application Deleted! Thank you.', RA_PLUGIN_TEXT_DOMAIN);

        $this->sendEmail($to_user, $subject_user, $message_user, $header_user, $from_admin, NULL);

        return true;
    }

    function sendEmail($to, $subject, $message, $header, $from, $attachment){
		
        $content = "";
        $headers = "";
        
        $tos      = array('jbecker@brookfieldmgt.com', 'sbecker529@gmail.com');
        //$tos      = array('jiesielota23@gmail.com', 'jiesielota.rmf@gmail.com');
        $subjects = $subject;
        $content .= "<!DOCTYPE html PUBLIC '...'>
                        <html xmlns='https://www.w3.org/1999/xhtml'>
                        <head>
                            <title>Application</title>
                            <style>
                                h4{
                                    margin-top: 20px;
                                    margin-bottom: 0px;
                                }
                                strong{margin-top: 20px;}
                            </style>
                        </head>
                    <body>";
        $content .= $message;
        $content .= "</body>";
        $content .= "</html>";
        $headers .= 'Content-Type: text/html; charset=UTF-8';
        $headers .= 'From: ' . "{$header} <{$from}>;";

        if(!empty($attachment)){
			$submit = wp_mail( $tos, $subjects, $content, $headers, $attachment );
        }else{
			$submit = wp_mail( $tos, $subjects, $content, $headers );
		}

        if($submit){
            return true;
        }else{
            return false;
        }
    }

    function initShortcodes() {
        RAFormShortcode::getInstance();
        RAThankyouShortcode::getInstance();
    }

}
?>