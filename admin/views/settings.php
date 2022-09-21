<?php
    $RASettings = RASettings::getInstance();
	$availablePages = get_pages();
	$payment_mode = array(
		'live'=>__('Live', RA_PLUGIN_TEXT_DOMAIN),
		'sandbox'=>__('Sandbox', RA_PLUGIN_TEXT_DOMAIN)
    );
    
	$attr_currency = array(
		'AUD'=>__('Australian Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'AED'=> __('United Arab Emirates Dirham', RA_PLUGIN_TEXT_DOMAIN),
		'ANG'=> __('Netherlands Antillean Gulden', RA_PLUGIN_TEXT_DOMAIN),
		'ALL'=> __('Albanian Lek', RA_PLUGIN_TEXT_DOMAIN),
		'ARS'=> __('Argentine Peso', RA_PLUGIN_TEXT_DOMAIN),
		'AWG'=> __('Aruban Florin', RA_PLUGIN_TEXT_DOMAIN),
		'BBD'=> __('Barbadian Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'BIF'=> __('Burundian Franc', RA_PLUGIN_TEXT_DOMAIN),
		'BND'=> __('Brunei Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'BRL'=> __('Brazilian Real', RA_PLUGIN_TEXT_DOMAIN),
		'BWP'=> __('Botswana Pula', RA_PLUGIN_TEXT_DOMAIN),
		'BDT'=> __('Bangladeshi Taka', RA_PLUGIN_TEXT_DOMAIN),
		'BMD'=> __('Bermudian Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'BOB'=> __('Bolivian Boliviano', RA_PLUGIN_TEXT_DOMAIN),
		'BSD'=> __('Bahamian Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'BZD'=> __('Belize Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'CAD'=> __('Canadian Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'CLP'=> __('Chilean Peso', RA_PLUGIN_TEXT_DOMAIN),
		'COP'=> __('Colombian Peso', RA_PLUGIN_TEXT_DOMAIN),
		'CVE'=> __('Cape Verdean Escudo', RA_PLUGIN_TEXT_DOMAIN),
		'CHF'=> __('Swiss Franc', RA_PLUGIN_TEXT_DOMAIN),
		'CNY'=> __('Chinese Renminbi Yuan', RA_PLUGIN_TEXT_DOMAIN),
		'CRC'=> __('Costa Rican Colon', RA_PLUGIN_TEXT_DOMAIN),
		'CZK'=> __('Czech Koruna', RA_PLUGIN_TEXT_DOMAIN),
		'DJF'=> __('Djiboutian Franc', RA_PLUGIN_TEXT_DOMAIN),
		'DOP'=> __('Dominican Peso', RA_PLUGIN_TEXT_DOMAIN),
		'DKK'=> __('Danish Krone', RA_PLUGIN_TEXT_DOMAIN),
		'DZD'=> __('Algerian Dinar', RA_PLUGIN_TEXT_DOMAIN),
		'EGP'=> __('Egyptian Pound', RA_PLUGIN_TEXT_DOMAIN),
		'EUR'=> __('Euros', RA_PLUGIN_TEXT_DOMAIN),
		'ETB'=> __('Ethiopian Birr', RA_PLUGIN_TEXT_DOMAIN),
		'FKP'=> __('Falkland Islands Pound', RA_PLUGIN_TEXT_DOMAIN),
		'FJD'=> __('Fijian Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'GBP'=> __('British Pound', RA_PLUGIN_TEXT_DOMAIN),
		'GIP'=> __('Gibraltar Pound', RA_PLUGIN_TEXT_DOMAIN),
		'GNF'=> __('Guinean Franc', RA_PLUGIN_TEXT_DOMAIN),
		'GYD'=> __('Guyanese Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'GMD'=> __('Gambian Dalasi', RA_PLUGIN_TEXT_DOMAIN),
		'GTQ'=> __('Guatemalan Quetzal', RA_PLUGIN_TEXT_DOMAIN),
		'HNL'=> __('Honduran Lempira', RA_PLUGIN_TEXT_DOMAIN),
		'HTG'=> __('Haitian Gourde', RA_PLUGIN_TEXT_DOMAIN),
		'HKD'=> __('Hong Kong Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'HRK'=> __('Croatian Kuna', RA_PLUGIN_TEXT_DOMAIN),
		'HUF'=> __('Hungarian Forint', RA_PLUGIN_TEXT_DOMAIN),
		'IDR'=> __('Indonesian Rupiah', RA_PLUGIN_TEXT_DOMAIN),
		'INR'=> __('Indian Rupee', RA_PLUGIN_TEXT_DOMAIN),
		'ILS'=> __('Israeli New Sheqel', RA_PLUGIN_TEXT_DOMAIN),
		'ISK'=> __('Icelandic Krona', RA_PLUGIN_TEXT_DOMAIN),
		'JMD'=> __('Jamaican Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'JPY'=> __('Japanese Yen', RA_PLUGIN_TEXT_DOMAIN),
		'KES'=> __('Kenyan Shilling', RA_PLUGIN_TEXT_DOMAIN),
		'KMF'=> __('Comorian Franc', RA_PLUGIN_TEXT_DOMAIN),
		'KYD'=> __('Cayman Islands Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'KHR'=> __('Cambodian Riel', RA_PLUGIN_TEXT_DOMAIN),
		'KRW'=> __('South Korean Won', RA_PLUGIN_TEXT_DOMAIN),
		'KZT'=> __('Kazakhstani Tenge', RA_PLUGIN_TEXT_DOMAIN),
		'LAK'=> __('Lao Kip', RA_PLUGIN_TEXT_DOMAIN),
		'LKR'=> __('Sri Lankan Rupee', RA_PLUGIN_TEXT_DOMAIN),
		'LBP'=> __('Lebanese Pound', RA_PLUGIN_TEXT_DOMAIN),
		'LRD'=> __('Liberian Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'MAD'=> __('Moroccan Dirham', RA_PLUGIN_TEXT_DOMAIN),
		'MNT'=> __('Mongolian Togrog', RA_PLUGIN_TEXT_DOMAIN),
		'MRO'=> __('Mauritanian Ouguiya', RA_PLUGIN_TEXT_DOMAIN),
		'MVR'=> __('Maldivian Rufiyaa', RA_PLUGIN_TEXT_DOMAIN),
		'MXN'=> __('Mexican Peso', RA_PLUGIN_TEXT_DOMAIN),
		'MDL'=> __('Moldovan Leu', RA_PLUGIN_TEXT_DOMAIN),
		'MOP'=> __('Macanese Pataca', RA_PLUGIN_TEXT_DOMAIN),
		'MUR'=> __('Mauritian Rupee', RA_PLUGIN_TEXT_DOMAIN),
		'MWK'=> __('Malawian Kwacha', RA_PLUGIN_TEXT_DOMAIN),
		'MYR'=> __('Malaysian Ringgit', RA_PLUGIN_TEXT_DOMAIN),
		'NAD'=> __('Namibian Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'NIO'=> __('Nicaraguan Cordoba', RA_PLUGIN_TEXT_DOMAIN),
		'NPR'=> __('Nepalese Rupee', RA_PLUGIN_TEXT_DOMAIN),
		'NGN'=> __('Nigerian Naira', RA_PLUGIN_TEXT_DOMAIN),
		'NOK'=> __('Norwegian Krone', RA_PLUGIN_TEXT_DOMAIN),
		'NZD'=> __('New Zealand Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'PAB'=> __('Panamanian Balboa', RA_PLUGIN_TEXT_DOMAIN),
		'PGK'=> __('Papua New Guinean Kina', RA_PLUGIN_TEXT_DOMAIN),
		'PKR'=> __('Pakistani Rupee', RA_PLUGIN_TEXT_DOMAIN),
		'PYG'=> __('Paraguayan Guarani', RA_PLUGIN_TEXT_DOMAIN),
		'PEN'=> __('Peruvian Nuevo Sol', RA_PLUGIN_TEXT_DOMAIN),
		'PHP'=> __('Philippine Peso', RA_PLUGIN_TEXT_DOMAIN),
		'PLN'=> __('Polish Zloty', RA_PLUGIN_TEXT_DOMAIN),
		'QAR'=> __('Qatari Riyal', RA_PLUGIN_TEXT_DOMAIN),
		'RUB'=> __('Russian Ruble', RA_PLUGIN_TEXT_DOMAIN),
		'SBD'=> __('Solomon Islands Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'SEK'=> __('Swedish Krona', RA_PLUGIN_TEXT_DOMAIN),
		'SHP'=> __('Saint Helenian Pound', RA_PLUGIN_TEXT_DOMAIN),
		'SOS'=> __('Somali Shilling', RA_PLUGIN_TEXT_DOMAIN),
		'SVC'=> __('Salvadoran Colon', RA_PLUGIN_TEXT_DOMAIN),
		'SAR'=> __('Saudi Riyal', RA_PLUGIN_TEXT_DOMAIN),
		'SCR'=> __('Seychellois Rupee', RA_PLUGIN_TEXT_DOMAIN),
		'SGD'=> __('Singapore Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'SLL'=> __('Sierra Leonean Leone', RA_PLUGIN_TEXT_DOMAIN),
		'STD'=> __('Sao Tome and Principe Dobra', RA_PLUGIN_TEXT_DOMAIN),
		'SZL'=> __('Swazi Lilangeni', RA_PLUGIN_TEXT_DOMAIN),
		'THB'=> __('Thai Baht', RA_PLUGIN_TEXT_DOMAIN),
		'TTD'=> __('Trinidad and Tobago Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'TZS'=> __('Tanzanian Shilling', RA_PLUGIN_TEXT_DOMAIN),
		'TOP'=> __('Tongan Paanga', RA_PLUGIN_TEXT_DOMAIN),
		'TWD'=> __('New Taiwan Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'UGX'=> __('Ugandan Shilling', RA_PLUGIN_TEXT_DOMAIN),
		'UYU'=> __('Uruguayan Peso', RA_PLUGIN_TEXT_DOMAIN),
		'UAH'=> __('Ukrainian Hryvnia', RA_PLUGIN_TEXT_DOMAIN),
		'USD'=> __('United States Dollar', RA_PLUGIN_TEXT_DOMAIN),
		'UZS'=> __('Uzbekistani Som', RA_PLUGIN_TEXT_DOMAIN),
		'VND'=> __('Vietnamese Dong', RA_PLUGIN_TEXT_DOMAIN),
		'VUV'=> __('Vanuatu Vatu', RA_PLUGIN_TEXT_DOMAIN),
		'WST'=> __('Samoan Tala', RA_PLUGIN_TEXT_DOMAIN),
		'XOF'=> __('West African Cfa Franc', RA_PLUGIN_TEXT_DOMAIN),
		'XAF'=> __('Central African Cfa Franc', RA_PLUGIN_TEXT_DOMAIN),
		'XPF'=> __('Cfp Franc', RA_PLUGIN_TEXT_DOMAIN),
		'YER'=> __('Yemeni Rial', RA_PLUGIN_TEXT_DOMAIN),
		'ZAR'=> __('South African Rand', RA_PLUGIN_TEXT_DOMAIN)
	);
	?>
    
	<div class="wrap">
		<h1>Application Settings</h1><br/>
        <form method="post" action="" >
			<div class="desc" style="width: 100%;margin-bottom: 40px;font-size: 18px;"><?php _e('To add form must have [ra_form /] shortcode in any page you want!', RA_PLUGIN_TEXT_DOMAIN); ?></div>
			<table>
				<tr>
					<td><b><?php _e('Application Success Page', RA_PLUGIN_TEXT_DOMAIN); ?></b><br/>
						<?php _e('Selected page must have [ra_thankyou /] shortcode', RA_PLUGIN_TEXT_DOMAIN); ?>
					</td>
					<td>
						<select id="thank_you_page" name="thank_you_page" class="large-text">
							<?php foreach($availablePages as $page):
								$selected = '';
								if( $page->ID == $RASettings->getSettings('thank_you_page') )
									$selected = 'selected="selected"';
								?>
								<option value="<?php echo $page->ID; ?>" <?php echo $selected; ?>><?php echo $page->post_title; ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><b><?php _e('PayPal Email ID', RA_PLUGIN_TEXT_DOMAIN); ?></b></td>
					<td>
						<input type="text" id="paypal_email" name="paypal_email" value="<?php echo $RASettings->getSettings('paypal_email'); ?>" class="large-text" placeholder="<?php _e('PayPal Email', RA_PLUGIN_TEXT_DOMAIN); ?>">
					</td>
				</tr>
				<tr>
					<td><b><?php _e('Payment Mode', RA_PLUGIN_TEXT_DOMAIN); ?></b></td>
					<td>
						<select id="payment_mode" name="payment_mode" class="large-text">
							<?php foreach($payment_mode as $mode=>$text):
								$selected = '';
								if( $mode == $RASettings->getSettings('payment_mode') )
									$selected = 'selected="selected"';
								?>
								<option value="<?php echo $mode; ?>" <?php echo $selected; ?>><?php echo $text; ?></option>
							<?php endforeach; ?>
						</select><br/>
					</td>
				</tr>
				<tr>
					<td><b><?php _e('1st Applicant Price', RA_PLUGIN_TEXT_DOMAIN); ?></b></td>
					<td>
					<input type="number" id="app_price_1" name="app_price_1" value="<?php echo $RASettings->getSettings('app_price_1'); ?>" class="large-text" placeholder="0.00">
					</td>
				</tr>
				<tr>
					<td><b><?php _e('2nd Applicant Price', RA_PLUGIN_TEXT_DOMAIN); ?></b></td>
					<td>
						<input type="number" id="app_price_2" name="app_price_2" value="<?php echo $RASettings->getSettings('app_price_2'); ?>" class="large-text" placeholder="0.00">
					</td>
				</tr>
				<tr>
					<td><b><?php _e('Currency', RA_PLUGIN_TEXT_DOMAIN); ?></b></td>
					<td>
						<select id="currency" name="attr_currency" class="large-text">
							<?php foreach($attr_currency as $curr=>$text):
								$selected = '';
								if( $curr == $RASettings->getSettings('attr_currency') ){
									$selected = 'selected="selected"';
								}
							?>
							<option value="<?php echo $curr; ?>" <?php echo $selected; ?>><?php echo $text; ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr style="display: table;padding-bottom: 10px;">
					<td></td><td></td>
				</tr>
				<tr>
					<td><b><?php _e('Send to Email: ', RA_PLUGIN_TEXT_DOMAIN); ?></b></td>
					<td>
						<input type="email" id="send_to_email" name="send_to_email" value="<?php echo $RASettings->getSettings('send_to_email'); ?>" class="large-text" placeholder="Ex: admin@email.com">
					</td>
				</tr>
			</table>
			
            <div class="settings-btn-save">
                <input type="hidden" name="ra_cmd" id="ra_cmd" value="RAAdmin:saveSettings" />
                <input type="submit" value="<?php _e('Save', RA_PLUGIN_TEXT_DOMAIN); ?>" class="button button-primary">
            </div>
        </form>
	</div>
