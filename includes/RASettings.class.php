<?php
class RASettings extends RASingleton {
    private $optionKey;

    public function __construct() {
        $this->optionKey = RA_PLUGIN_SLUG.'_settings';
    }
    public function getSettings($option, $default='') {
        $options = get_option( $this->optionKey );

        if(is_array($options)) {
            if(isset($options[$option]))
                return stripcslashes($options[$option]);
        }

        return $default;
    }
    public function setSettings($option, $value='') {
        $options = get_option( $this->optionKey );

        if(!is_array($options)) {
            $options = array();
        }

        $options[$option] = $value;
        update_option( $this->optionKey, $options );
        return true;
    }
	
	public function get_user_rolebyID($user_id) {
		$user = new WP_User($user_id);
		$role = array_shift($user -> roles);
		return $role;
	}
	
	public function get_user_role() {
		global $user_ID;
		$user = new WP_User($user_ID);
		$role = array_shift($user -> roles);
		return $role;
	}
}