<?php
/** TEST DATA
 * INSERT INTO `wp_bf_applicant_info` (`info_id`, `f_name`, `address`, `contact`, `other`, `second_applicant`, `additional_occupants`, `emp_history`, `pets`, `miscellaneous`, `emergency_contact`, `signature`, `drivers_id`, `proof_of_income`) VALUES
 *	(1, '', '', '{"h_phone":"","c_phone":""}', '{"ss_number":"","dob":"","email":""}', '{"f_name":"","address":"","h_phone":"","c_phone":"","ss_number":"","dob":"","email":""}', '{"1":{"name":"","dob":"","relation":""},"2":{"name":"","dob":"","relation":""},"3":{"name":"","dob":"","relation":""}}', '{"app_1":{"cur_emp":"","address":"","phone":"","how_long":""},"app_2":{"cur_emp":"","address":"","phone":"","how_long":""}}', '{"Y":{"no_pets":"","breed":"","desc":"","lbs":"","pet_image":""}}', '{"convicted_felony":"Y/N","evicted":"Y/N","explain":""}', '{"1":{"name":"","relation":"","address":"","phone":""},"2":{"name":"","relation":"","address":"","phone":""}}', '{"app_1":{"signature":""},app_2":{"signature":""}}', '', '');
 * INSERT INTO `wp_bf_application` (`app_id`, `info_id`, `pay_trans_id`, `pay_type`, `pay_status`, `app_status`) VALUES
 *	(1, 1, '123abcqweasd', 'paypal', 'pending', 'Pending');
 * INSERT INTO `wp_bf_settings` (`tokens`, `app_prices`) VALUES
 *	('{"paypal":{"email":""},"stripe":{"SK":"","PK":""}}', '{"application_1":"40","application_2":"45","currency":""}');
 */
$RAAdmin = RAAdmin::getInstance();
$app_details = $RAAdmin->getApplicationById($_GET['app_id']);
?>
<h1 class="wp-heading-inline">View Application</h1>
<div class="view">
    <div class="view__wrapper">
        <div class="view__left">
            <h3 class="view__name"><?=$app_details->f_name;?></h3>
            <address><?=$app_details->address;?></address>
            <p class="view__dob <?= ( empty($app_details->other->dob) ) ? 'hide' : ''; ?>"><i class="fa fa-calendar"></i><?=$app_details->other->dob;?></p>
            <p class="view__email <?= ( empty($app_details->other->email) ) ? 'hide' : ''; ?>"><i class="fa fa-envelope"></i><?=$app_details->other->email;?></p>
            <p class="view__ssnumber <?= ( empty($app_details->other->ss_number) ) ? 'hide' : ''; ?>"><span class="info-label">SS Number:</span><?=$app_details->other->ss_number;?></p>
            <p class="view__phone <?= ( empty($app_details->contact->h_phone) ) ? 'hide' : ''; ?>"><i class="fa fa-phone"></i><?=$app_details->contact->h_phone;?></p>
            <p class="view__cell <?= ( empty($app_details->contact->c_phone) ) ? 'hide' : ''; ?>"><i class="fa fa-mobile"></i><?=$app_details->contact->c_phone;?></p>
            <span class="view__paymentstatus <?=($app_details->pay_status == 'pending') ? 'view__paymentstatus--pending' : ''?>"><?=$app_details->pay_status;?></span>
            <p class="view_interest" style="text-align: center;"><span class="info-label">Interested In:</span><br/><?=$app_details->other->interested_in;?></p>
            <p class="view_how_many_people" style="text-align: center;"><span class="info-label">How Many People 18+ Years Old Will Be Residing In Home?:</span><br/><?=$app_details->other->how_many_people;?></p>
        </div>
        <div class="view__right">
                <ul class="tabs">
                    <!--<li class="tabs__item active <?= ( empty($app_details->second_applicant) ) ? 'hide' : ''; ?>" data-id="second__applicant">Second Applicant</li>
                    <li class="tabs__item <?= ( empty($app_details->additional_occupants) ) ? 'hide' : ''; ?>" data-id="additional_occupants">Additional Occupants</li>
                    <li class="tabs__item <?= ( empty($app_details->emp_history) ) ? 'hide' : ''; ?>" data-id="emp_history">Employment History</li>
                    <li class="tabs__item <?= ( empty($app_details->emp_history) ) ? 'hide' : ''; ?>" data-id="pets">Pets</li>-->
                    <li class="tabs__item active" data-id="second__applicant">Second Applicant</li>
                    <li class="tabs__item" data-id="additional_occupants">Additional Occupants</li>
                    <li class="tabs__item" data-id="emp_history">Employment History</li>
                    <li class="tabs__item" data-id="pets">Pets</li>
                    <li class="tabs__item" data-id="miscellaneous">Miscellaneous</li>
                    <li class="tabs__item" data-id="emergency_contact">Emergency Contact</li>
                    <li class="tabs__item" data-id="signature">Signature</li>
                </ul>
                <div id="second__applicant" class="tabs__content">
                    <table>
                        <tr>
                            <td><span class="info-label">Full Name:</span></td>
                            <td><?=$app_details->second_applicant->f_name;?></td>
                        </tr>
                        <tr>
                            <td><span class="info-label">Address:</span></td>
                            <td><?=$app_details->second_applicant->address;?></td>
                        </tr>
                        <tr>
                            <td><span class="info-label">City:</span></td>
                            <td><?=$app_details->second_applicant->city;?></td>
                        </tr>
                        <tr>
                            <td><span class="info-label">State:</span></td>
                            <td><?=$app_details->second_applicant->state;?></td>
                        </tr>
                        <tr>
                            <td><span class="info-label">Zipcode:</span></td>
                            <td><?=$app_details->second_applicant->zipcode;?></td>
                        </tr>
                        <tr>
                            <td><span class="info-label">Home Phone:</span></td>
                            <td><?=$app_details->second_applicant->h_phone;?></td>
                        </tr>
                        <tr>
                            <td><span class="info-label">Cell Number:</span></td>
                            <td><?=$app_details->second_applicant->c_phone;?></td>
                        </tr>
                        <tr>
                            <td><span class="info-label">Date of Birth:</span></td>
                            <td><?=$app_details->second_applicant->dob;?></td>
                        </tr>
                        <tr>
                            <td><span class="info-label">Email:</span></td>
                            <td><?=$app_details->second_applicant->email;?></td>
                        </tr>

                    </table>
                </div>
                <div id="additional_occupants" class="tabs__content hide">
                    <?php $count = 1; ?>
                    <?php foreach($app_details->additional_occupants as $key => $occupants): ?>
                        <table>
                            <tr>
                                <td><h6><strong>Occupant <?php echo $count; ?></strong></h6></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">Name:</span></td>
                                <td><?php echo ( $occupants->name != '' ) ? $occupants->name : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">Date of Birth:</span></td>
                                <td><?php echo ( $occupants->dob != '' ) ? date('F d, Y',strtotime($occupants->dob)) : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">Relation:</span></td>
                                <td><?php echo ( $occupants->relation != '' ) ? $occupants->relation : 'None' ;?></td>
                            </tr>
                        </table>
                        <?php $count++; ?>
                    <?php endforeach; ?>
                </div>
                <div id="emp_history" class="tabs__content hide">
                    <?php $count = 1; ?>
                    <?php foreach($app_details->emp_history as $key => $occupants): ?>
                        <table>
                            <tr>
                                <td><h6><strong>Applicant <?php echo $count; ?></strong></h6></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">Current Employer:</span></td>
                                <td><?php echo ( $occupants->cur_emp != '' ) ? $occupants->cur_emp : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">Address:</span></td>
                                <td><?php echo ( $occupants->address != '' ) ? $occupants->address : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">City:</span></td>
                                <td><?php echo ( $occupants->city != '' ) ? $occupants->city : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">State:</span></td>
                                <td><?php echo ( $occupants->state != '' ) ? $occupants->state : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">Zipcode:</span></td>
                                <td><?php echo ( $occupants->zipcode != '' ) ? $occupants->zipcode : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">Phone:</span></td>
                                <td><?php echo ( $occupants->phone != '' ) ? $occupants->phone : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">How Long:</span></td>
                                <td><?php echo ( $occupants->how_long != '' ) ? $occupants->how_long : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">How are you getting paid?</span></td>
                                <td><?php echo ( $occupants->paid != '' ) ? $occupants->paid : 'None' ;?></td>
                            </tr>
                        </table>
                        <?php $count++; ?>
                    <?php endforeach; ?>
                </div>
                <div id="pets" class="tabs__content hide">
                    <?php if( empty( $app_details->pets ) ): ?>
                        <h6>No Pets</h6>
                    <?php else: ?>
                        <table>
                            <tr>
                                <td><span class="info-label">No of Pets:</span></td>
                                <td><?php echo ( $app_details->pets->Y->no_pets != '' ) ? $app_details->pets->Y->no_pets : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">Breed:</span></td>
                                <td><?php echo ( $app_details->pets->Y->breed != '' ) ? $app_details->pets->Y->breed : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">Description:</span></td>
                                <td><?php echo ( $app_details->pets->Y->desc != '' ) ? $app_details->pets->Y->desc : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">LBS:</span></td>
                                <td><?php echo ( $app_details->pets->Y->lbs != '' ) ? $app_details->pets->Y->lbs : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">Pet Image:</span></td>
                            </tr>
                        </table>
                        <img src="<?= $app_details->pet_image; ?>" />
                    <?php endif; ?>
                </div>
                <div id="miscellaneous" class="tabs__content hide">
                    <h6>Have you ever been:</h6>
                    <table>
                        <tr>
                            <td><span class="info-label">Convicted of a Felony?</span></td>
                            <td><?php echo ( $app_details->miscellaneous->convicted_felony != '' ) ? $app_details->miscellaneous->convicted_felony : 'None' ;?></td>
                        </tr>
                        <tr>
                            <td><span class="info-label">Evicted?</span></td>
                            <td><?php echo ( $app_details->miscellaneous->evicted != '' ) ? $app_details->miscellaneous->evicted : 'None' ;?></td>
                        </tr>
                        <tr>
                            <td><span class="info-label">Explain:</span></td>
                            <td><?php echo ( $app_details->miscellaneous->explain != '' ) ? $app_details->miscellaneous->explain : 'None' ;?></td>
                        </tr>
                    </table>
                </div>
                <div id="emergency_contact" class="tabs__content hide">
                    <?php $count = 1; ?>
                    <?php foreach($app_details->emergency_contact as $key => $occupants): ?>
                        <h6><strong>Emergency Contact <?php echo $count; ?></strong></h6>
                        <table>
                            <tr>
                                <td><span class="info-label">Name:</span></td>
                                <td><?php echo ( $occupants->name != '' ) ? $occupants->name : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">Relation:</span></td>
                                <td><?php echo ( $occupants->relation != '' ) ? $occupants->relation : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">Address:</span></td>
                                <td><?php echo ( $occupants->address != '' ) ? $occupants->address : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">City:</span></td>
                                <td><?php echo ( $occupants->city != '' ) ? $occupants->city : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">State:</span></td>
                                <td><?php echo ( $occupants->state != '' ) ? $occupants->state : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">Zipcode:</span></td>
                                <td><?php echo ( $occupants->zipcode != '' ) ? $occupants->zipcode : 'None' ;?></td>
                            </tr>
                            <tr>
                                <td><span class="info-label">Phone:</span></td>
                                <td><?php echo ( $occupants->phone != '' ) ? $occupants->phone : 'None' ;?></td>
                            </tr>
                        </table>
                        <?php $count++; ?>
                    <?php endforeach; ?>
                </div>
                <div id="signature" class="tabs__content hide">
                    <?php $count = 1; ?>
                    <?php foreach($app_details->signature as $key => $occupants): ?>
                        <h6><strong>Applicant <?php echo $count; ?></strong></h6>

                        <img src="<?= $occupants->signature; ?>" />

                        <?php if( $count == 1 ): ?>
                            <hr style="color: #fff;"><br/>
                        <?php endif; ?>
                        
                        <?php $count++; ?>
                    <?php endforeach; ?>
                </div>
        </div>
    </div>
</div>

<h2> Supporting Documents </h2>

<div class="docs-wrapper">
    <div id="drivers_license">
        <h3>Drivers License:</h3>
        <?php
        $drivers_data = json_decode($app_details->drivers_id);
        foreach($drivers_data as $k=>$v){
        ?>
            <?php $path_parts = pathinfo($v); ?>
            <?php if( $path_parts['extension'] != 'pdf'){ ?>
                <img src="<?= $v; ?>" style="width: 100%;"/>
            <?php }else{ ?>
                <!--<a href="<?php echo $v; ?>">View PDF</a>-->
                <iframe src="<?php echo $v; ?>" width="100%" height="800"></iframe>
            <?php }  ?>
            
        <?php
        }
        ?>
    </div>

    <div id="proof_of_income">
        <h3>Proof of Income:</h3>
        <?php
        $proof_data = json_decode($app_details->proof_of_income);
        foreach($proof_data as $k=>$v){
        ?>
            <?php $path_parts = pathinfo($v); ?>
            <?php if( $path_parts['extension'] != 'pdf'){ ?>
                <img src="<?= $v; ?>" style="width: 100%;"/>
            <?php }else{ ?>
                <!--<a href="<?php echo $v; ?>">View PDF</a>-->
                <iframe src="<?php echo $v; ?>" width="100%" height="800"></iframe>
            <?php }  ?>
        <?php
        }
        ?>
    </div>
</div>

<?php
//echo '<pre>';
//print_r($app_details);
//echo '</pre>';
?>