<?php
class TableActivate extends RASingleton {
    public $t_app_info;
    public $t_app;
    private $app_id;

    protected function __construct()
    {
        global $wpdb;
        $this->t_app_info = $wpdb->prefix . 'bf_applicant_info';
        $this->t_app = $wpdb->prefix . 'bf_application';
    }

    function createTable(){
        global $wpdb;
        //Create app_info table sql
        $t_app_info_sql = "CREATE TABLE {$this->t_app_info} (
			`info_id` INT(11) NOT NULL AUTO_INCREMENT,
            `f_name` TEXT NOT NULL,
            `address` TEXT NOT NULL,
            `city` TEXT NOT NULL,
            `state` TEXT NOT NULL,
            `zipcode` TEXT NOT NULL,
            `contact` TEXT NOT NULL,
            `other` TEXT NOT NULL,
            `interested_in` TEXT NOT NULL,
            `how_many_people` TEXT NOT NULL,
            `second_applicant` TEXT NOT NULL,
            `additional_occupants` TEXT NOT NULL,
            `emp_history` TEXT NOT NULL,
            `pets` LONGTEXT NOT NULL,
            `miscellaneous` TEXT NOT NULL,
            `emergency_contact` TEXT NOT NULL,
            `signature` TEXT NOT NULL,
            `drivers_id` LONGTEXT NOT NULL,
            `proof_of_income` LONGTEXT NOT NULL,
            PRIMARY KEY (`info_id`)
        );";

        dbDelta($t_app_info_sql);
        $pet_image = $wpdb->query("SHOW COLUMNS FROM `{$this->t_app_info}` LIKE 'pet_image'");
		if($pet_image != 1){
			$wpdb->query("ALTER TABLE `{$this->t_app_info}` ADD `pet_image` LONGTEXT NOT NULL");
		}
        $pet_image_name = $wpdb->query("SHOW COLUMNS FROM `{$this->t_app_info}` LIKE 'pet_image_name'");
		if($pet_image_name != 1){
			$wpdb->query("ALTER TABLE `{$this->t_app_info}` ADD `pet_image_name` LONGTEXT NOT NULL");
		}
        $proof_of_income_name = $wpdb->query("SHOW COLUMNS FROM `{$this->t_app_info}` LIKE 'proof_of_income_name'");
		if($proof_of_income_name != 1){
			$wpdb->query("ALTER TABLE `{$this->t_app_info}` ADD `proof_of_income_name` LONGTEXT NOT NULL");
		}
        $drivers_id_name = $wpdb->query("SHOW COLUMNS FROM `{$this->t_app_info}` LIKE 'drivers_id_name'");
		if($drivers_id_name != 1){
			$wpdb->query("ALTER TABLE `{$this->t_app_info}` ADD `drivers_id_name` LONGTEXT NOT NULL");
		}
        /** END */

        //Create application table sql
        $t_app_sql = "CREATE TABLE {$this->t_app} (
			`app_id` INT(11) NOT NULL AUTO_INCREMENT,
            `info_id` INT(11) NOT NULL,
            `pay_trans_id` TEXT NOT NULL,
            `pay_type` TEXT NOT NULL,
            `pay_status` TEXT NOT NULL,
            `app_status` ENUM('Pending','Completed','Denied','Confirmed') NOT NULL DEFAULT 'Pending',
            `date_created` DATETIME NOT NULL,
            PRIMARY KEY (`app_id`),
            INDEX `info_id` (`info_id`)
        );";
        
        dbDelta($t_app_sql);
        $payment_data = $wpdb->query("SHOW COLUMNS FROM `{$this->t_app}` LIKE 'payment_data'");
		if($payment_data != 1){
			$wpdb->query("ALTER TABLE `{$this->t_app}` ADD `payment_data` TEXT NOT NULL");
		}
        $date_payment = $wpdb->query("SHOW COLUMNS FROM `{$this->t_app}` LIKE 'date_payment'");
		if($date_payment != 1){
			$wpdb->query("ALTER TABLE `{$this->t_app}` ADD `date_payment` DATETIME NOT NULL");
		}
        $amount_paid = $wpdb->query("SHOW COLUMNS FROM `{$this->t_app}` LIKE 'amount_paid'");
		if($amount_paid != 1){
			$wpdb->query("ALTER TABLE `{$this->t_app}` ADD `amount_paid` INT(11) NOT NULL");
		}
        /** END */
        
    }
}
?>