<?php
$steps = '8';

// echo '<pre>';
// print_r($_REQUEST);
// echo '</pre>';
?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2 id="heading">Application Form</h2>
                <p>Fill all form field to go to next step</p>
                <form id="msform" enctype="multipart/form-data">
                    <!-- progressbar -->
                    <ul id="progressbar">
                        <li class="active" id="account"><strong>Applicant Personal Information</strong></li>
                        <li id="personal"><strong>Employment History</strong></li>
                        <li id="pets"><strong>Pets</strong></li>
                        <li id="misc"><strong>Miscellaneous</strong></li>
                        <li id="emergency"><strong>Emergency Contacts</strong></li>
                        <li id="proof"><strong>Supporting Documents</strong></li>
                        <li id="signature"><strong>Signature</strong></li>
                    </ul>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> <br> <!-- fieldsets -->
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h3 class="fs-title">Personal Information:</h3>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 1 - <?=$steps;?></h2>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fieldlabels">Full Name: *</label> 
                                    <input type="text" name="f_name" placeholder="Full Name" /> 
                                </div>
                                <div class="col-md-6">
                                    <label class="fieldlabels">Email Address: *</label> 
                                    <input type="email" name="other[email]" placeholder="Email Address" /> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fieldlabels">Current Address: *</label> 
                                    <input type="text" name="address" placeholder="Current Address" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="city" placeholder="City" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="state" placeholder="State" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="zipcode" placeholder="Zip Code" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fieldlabels">Home Phone:</label> 
                                    <input type="text" class="phone-grp" name="contact[h_phone]" placeholder="Home Phone" /> 
                                </div>
                                <div class="col-md-6">
                                    <label class="fieldlabels">Cell Phone:</label> 
                                    <input type="text" class="phone-grp" name="contact[c_phone]" placeholder="Cell Phone" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fieldlabels">Social Security Number: *</label> 
                                    <input type="text" name="other[ss_number]" placeholder="Social Security Number" /> 
                                </div>
                                <div class="col-md-6">
                                    <label class="fieldlabels">Date of Birth: *</label> 
                                    <input type="date" name="other[dob]" placeholder="Date of Birth" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fieldlabels">Interested In: *</label> 
                                    <select name="other[interested_in]">
                                        <option value="">Select Options</option>
                                        <option value="1-Bed/1-Bath">1-Bed/1-Bath</option>
                                        <option value="2-Bed/1-Bath">2-Bed/1-Bath</option>
                                        <option value="3-Bed/1-Bath">3-Bed/1-Bath</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="fieldlabels">How Many People 18+ Years Old Will Be Residing In Home?: *</label> 
                                    <select name="other[how_many_people]">
                                        <option value="">Select Options</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="fs-title">Second Applicant / Co-Signer Information:</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fieldlabels">Full Name:</label> 
                                    <input type="text" name="second_applicant[f_name]" placeholder="Full Name" /> 
                                </div>
                                <div class="col-md-6">
                                    <label class="fieldlabels">Email Address:</label> 
                                    <input type="email" name="second_applicant[email]" placeholder="Email Address" /> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fieldlabels">Current Address:</label> 
                                    <input type="text" name="second_applicant[address]" placeholder="Current Address" /> 
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="second_applicant[city]" placeholder="City" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="second_applicant[state]" placeholder="State" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="second_applicant[zipcode]" placeholder="Zip Code" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fieldlabels">Home Phone:</label> 
                                    <input type="text" name="second_applicant[h_phone]" placeholder="Home Phone" /> 
                                </div>
                                <div class="col-md-6">
                                    <label class="fieldlabels">Cell Phone:</label> 
                                    <input type="text" name="second_applicant[c_phone]" placeholder="Cell Phone" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fieldlabels">Social Security Number:</label> 
                                    <input type="text" name="second_applicant[ss_number]" placeholder="Social Security Number" /> 
                                </div>
                                <div class="col-md-6">
                                    <label class="fieldlabels">Date of Birth:</label> 
                                    <input type="date" name="second_applicant[dob]" placeholder="Date of Birth" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="fs-title">Additional Occupants:</h3>
                                    <h6 style="font-size: 18px; font-weight: 400 !important;"><em>List all others that will reside with you, in the home (full or part time)</em></h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fieldlabels">Name:</label> 
                                    <input type="text" name="additional_occupants[occ_1][name]" placeholder="Name" /> 
                                </div>
                                <div class="col-md-6">
                                    <label class="fieldlabels">Date of Birth:</label> 
                                    <input type="date" name="additional_occupants[occ_1][dob]" placeholder="Date of Birth" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fieldlabels">Relationship to you:</label> 
                                    <input type="text" name="additional_occupants[occ_1][relation]" placeholder="Relationship to you" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fieldlabels">Name:</label> 
                                    <input type="text" name="additional_occupants[occ_2][name]" placeholder="Name" /> 
                                </div>
                                <div class="col-md-6">
                                    <label class="fieldlabels">Date of Birth:</label> 
                                    <input type="date" name="additional_occupants[occ_2][dob]" placeholder="Date of Birth" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fieldlabels">Relationship to you:</label> 
                                    <input type="text" name="additional_occupants[occ_2][relation]" placeholder="Relationship to you" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fieldlabels">Name:</label> 
                                    <input type="text" name="additional_occupants[occ_3][name]" placeholder="Name" /> 
                                </div>
                                <div class="col-md-6">
                                    <label class="fieldlabels">Date of Birth:</label> 
                                    <input type="date" name="additional_occupants[occ_3][dob]" placeholder="Date of Birth" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fieldlabels">Relationship to you:</label> 
                                    <input type="text" name="additional_occupants[occ_3][relation]" placeholder="Relationship to you" />
                                </div>
                            </div>
                        </div> 
                        <input type="button" name="next" class="next action-button" value="Next" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Employment History:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 2 - <?=$steps;?></h2>
                                </div>
                            </div> 
                            <h6 style="font-size: 18px; font-weight: 400 !important;"><em>Applicant 1</em></h6>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fieldlabels">Current Employer*:</label> 
                                    <input type="text" name="emp_history[app_1][cur_emp]" placeholder="Current Employer" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fieldlabels">Address*:</label> 
                                    <input type="text" name="emp_history[app_1][address]" placeholder="Address" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="emp_history[app_1][city]" placeholder="City" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="emp_history[app_1][state]" placeholder="State" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="emp_history[app_1][zipcode]" placeholder="Zip Code" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="fieldlabels">Work Phone*:</label> 
                                    <input type="text" name="emp_history[app_1][phone]" placeholder="Work Phone" /> 
                                </div>
                                <div class="col-md-4">
                                    <label class="fieldlabels">How Long with Current Employer*:</label> 
                                    <input type="text" name="emp_history[app_1][how_long]" placeholder="How Long with Current Employer" />
                                </div>
                                <div class="col-md-4">
                                    <label class="fieldlabels">How are you getting paid?</label>
                                    <select name="emp_history[app_1][paid]">
                                        <option value="">Select Options</option>
                                        <option value="Weekly">Weekly</option>
                                        <option value="B-Weekly">B-Weekly</option>
                                    </select>
                                </div>
                            </div>
                            <h6 style="font-size: 18px; font-weight: 400 !important;"><em>Applicant 2</em></h6>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fieldlabels">Current Employer:</label> 
                                    <input type="text" name="emp_history[app_2][cur_emp]" placeholder="Current Employer" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fieldlabels">Address:</label> 
                                    <input type="text" name="emp_history[app_2][address]" placeholder="Address" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="emp_history[app_2][city]" placeholder="City" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="emp_history[app_2][state]" placeholder="State" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="emp_history[app_2][zipcode]" placeholder="Zip Code" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="fieldlabels">Work Phone:</label> 
                                    <input type="text" name="emp_history[app_2][phone]" placeholder="Work Phone" /> 
                                </div>
                                <div class="col-md-4">
                                    <label class="fieldlabels">How Long with Current Employer:</label> 
                                    <input type="text" name="emp_history[app_2][how_long]" placeholder="How Long with Current Employer" />
                                </div>
                                <div class="col-md-4">
                                    <label class="fieldlabels">How are you getting paid?</label>
                                    <select name="emp_history[app_2][paid]">
                                        <option value="">Select Options</option>
                                        <option value="Weekly">Weekly</option>
                                        <option value="B-Weekly">B-Weekly</option>
                                    </select>
                                </div>
                            </div>
                        </div> 
                        <input type="button" name="next" class="next action-button" value="Next" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Pets:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 3 - <?=$steps;?></h2>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fieldlabels">Do you have any pets?</label> 
                                    <div class="radio-grp-form"><input type="radio" name="pets" value="Y"> Yes</div>
                                    <div class="radio-grp-form"><input type="radio" name="pets" value="N" checked> No</div>
                                    <br/>
                                </div>
                            </div>
                            <div class="pet-opition" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="fieldlabels">Number of Pets</label> 
                                        <input type="text" name="pets[Y][no_pets]" placeholder="Number of Pets" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fieldlabels">Breed of the animal</label> 
                                        <input type="text" name="pets[Y][breed]" placeholder="Breed of the animal" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="fieldlabels">Description of Animal</label> 
                                        <textarea name="pets[Y][desc]" placeholder="Description of Animal"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="fieldlabels">LBS</label> 
                                        <input type="text" name="pets[Y][lbs]" placeholder="LBS" />
                                    </div>
                                </div>
                                <h6 style="font-size: 18px; font-weight: 400 !important;"><em>Please note, you are allowed two pets per household. There is a $250 non-refundable pet fee per pet under 30 lbs., and a $500 non-refundable pet fee per pet over 30 lbs. There is also a $25 (per pet) fee each month for the pet(s). **Certain restrictions apply**</em></h6><br/>

                                <label class="fieldlabels">Image of pet: Please upload image of your pet(s):</label> 
                                <input type="file" id="pet_file" name="pet_image" accept="image/*" multiple>

                                <div id="detail">
                                    <div id="preview" style="height: 100%; width: auto; display: block;">
                                        <!--<img id="previewimg" src="" style="height:50%;width:auto;">-->
                                    </div>
                                </div>
								
								<div id="pet-deposit">
									<br/>
									<h6 style="font-size: 18px; font-weight: 400 !important;"><em>*You are allowed up to two pets per household. There is a $500.00 Pet Deposit for all pets over 40 pounds full grown. This is payable in increments of $50.00 per month if you so choose. Breed restrictions are, but not limited to: Pitbull, Rottweiler, Doberman Pincher, Akita, Chow, German Shepard, Great Dane, Sharpei and St. Bernard.</em></h6>
								</div>
								<div class="checkbox-grp-form"><input type="checkbox" name="pets-deposit" value="Y"> I agree to Pet Deposit FEE</div>
                            </div>

                        </div> 
                        <input type="button" name="next" class="next action-button" value="Next" /> 
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Miscellaneous:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 4 - <?=$steps;?></h2>
                                </div>
                            </div> 

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fieldlabels"><strong>Have you ever been:</strong></label> </br>
                                    <label class="fieldlabels">Convicted of a Felony?</label>
                                    <div class="radio-grp-form"><input  class="miscellaneous" type="radio" name="miscellaneous[convicted_felony]" value="Y"> Yes</div>
                                    <div class="radio-grp-form"><input  class="miscellaneous" type="radio" name="miscellaneous[convicted_felony]" value="N" checked> No</div>
                                    <br/>
                                    <label class="fieldlabels">Evicted?</label>
                                    <div class="radio-grp-form"><input class="miscellaneous" type="radio" name="miscellaneous[evicted]" value="Y" > Yes</div>
                                    <div class="radio-grp-form"><input class="miscellaneous" type="radio" name="miscellaneous[evicted]" value="N" checked > No</div>
                                    <br/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fieldlabels">If Yes to either of these, please explain:</label>
                                    <textarea name="miscellaneous[explain]" style="height: 120px;" placeholder="Explanation goes here..."></textarea>
                                </div>
                            </div>
                        </div> 
                        <input type="button" name="next" class="next action-button" value="Next" /> 
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Emergency Contact:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 5 - <?=$steps;?></h2>
                                </div>
                            </div> 
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fieldlabels">Emergency Contact 1*</label> 
                                    <input type="text" name="emergency_contact[em_contact_1][name]" placeholder="Name" />
                                </div>
                                <div class="col-md-6">
                                    <label class="fieldlabels">Relationship to you*</label> 
                                    <input type="text" name="emergency_contact[em_contact_1][relation]" placeholder="Relation" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fieldlabels">Address*</label> 
                                    <input type="text" name="emergency_contact[em_contact_1][address]" placeholder="Address" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="emergency_contact[em_contact_1][city]" placeholder="City" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="emergency_contact[em_contact_1][state]" placeholder="State" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="emergency_contact[em_contact_1][zipcode]" placeholder="Zip Code" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fieldlabels">Phone*</label> 
                                    <input type="text" name="emergency_contact[em_contact_1][phone]" placeholder="Contact Number" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fieldlabels">Emergency Contact 2</label> 
                                    <input type="text" name="emergency_contact[em_contact_2][name]" placeholder="Name" />
                                </div>
                                <div class="col-md-6">
                                    <label class="fieldlabels">Relationship to you</label> 
                                    <input type="text" name="emergency_contact[em_contact_2][relation]" placeholder="Relation" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fieldlabels">Address</label> 
                                    <input type="text" name="emergency_contact[em_contact_2][address]" placeholder="Address" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="emergency_contact[em_contact_2][city]" placeholder="City" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="emergency_contact[em_contact_2][state]" placeholder="State" />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="emergency_contact[em_contact_2][zipcode]" placeholder="Zip Code" />
                                </div>
                            </div>
                            <div class="row">
                                 <div class="col-md-12">
                                    <label class="fieldlabels">Phone</label> 
                                    <input type="text" name="emergency_contact[em_contact_2][phone]" placeholder="Contact Number" />
                                </div>
                            </div>
                        </div>
                        <input type="button" name="next" class="next action-button" value="Next" /> 
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Supporting Documents</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 6 - <?=$steps;?></h2>
                                </div>
                            </div> 
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 style="font-size: 14px; margin-bottom: 0;">Only for people 18 years of age or older.</h6>
                                </div>
                                <div class="col-md-12">
									<div class="checkbox-grp-form"><input type="checkbox" name="driver-license" value="Y"> Attach Driver License</div>
									<div class="driver-license-wrap" style="display: none;">
										<br/>
										<label class="fieldlabels">Drivers License: Please upload image of your ID  (copies of Front & Back required)*:</label> 
										<input type="file" id="driver_id_input" name="drivers_id[]" accept="image/*,application/pdf" onchange="javascript:updateList()" multiple>

										<div id="detail_id">
											<div id="preview_id" style="height: 100%; width: auto; display: block;">
												<img id="preview_id_img" src="" style="height:50%;width:auto;">
											</div>
										</div>
									</div>
                                </div>
                                <div class="col-md-12">
									<div class="checkbox-grp-form"><input type="checkbox" name="proof-of-income" value="Y"> Attach Proof of Income</div>
										<div class="proof-of-income-wrap" style="display: none;">
											<br/>
										<label class="fieldlabels">Proof of Income: Please upload image of your Income*:</label> 
										<p>Must supply at least the last month's worth:</p>
										<ul style="font-size: 16px; color: grey;">
										<li>Pay Stubs</li>
										<li>Bank Statements (must be two months worth)</li>
										<li>Proof of SSI or Disability</li>
										<li>Letters from Employers does not count as proof of income</li>
										<li>Child Support does not count as proof of income</li>
										</ul>
										<input type="file" id="proof_id_input" name="proof_of_income[]" accept="image/*,application/pdf" onchange="javascript:proofincome()" multiple>

										<div id="proof_id_preview">
											<div id="preview_proof" style="height: 100%; width: auto; display: block;">
												<img id="preview_proof_img" src="" style="height:50%;width:auto;">
											</div>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                        <input type="button" name="next" class="next action-button" value="Next" /> 
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Signature</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 7 - <?=$steps;?></h2>
                                </div>
                            </div> 
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fieldlabels">Print Name</label> 
                                    <input type="text" id="applicant_1" value="Name" readonly />
                                </div>
                                <div class="col-md-6 sign-hide">
                                    <label class="fieldlabels">Print Name</label> 
                                    <input type="text" id="applicant_2" value="Name" readonly />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="fieldlabels">Sign Below.</label> 
                                    <div class="signature" style=''>
                                        <canvas id="signature_app1" class="signature-pad" width="508px" height="150px"></canvas>
                                        <a id="clear_sign1">Clear</a>
                                        <input type="hidden" id="signature1" name="signature[app_1][signature]">
                                    </div>
                                </div>
                                <div class="col-md-6 sign-hide">
                                    <label class="fieldlabels">Sign Below.</label> 
                                    <div class="signature" style=''>
                                        <canvas id="signature_app2" class="signature-pad" width="508px" height="150px"></canvas>
                                        <a id="clear_sign2">Clear</a>
                                        <input type="hidden" id="signature2" name="signature[app_2][signature]">
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-12">
                                    <div class="checkbox-grp-form"><input type="checkbox" name="certify" value="Y"> I certify that permission is given to run my background and that all the information given is true and correct and understand that my lease or rental agreement may be terminated if I have made any material false or incomplete statements in this application. I authorize verification of the information provided in this application.</div></div>
								</div>
                        </div>
                        <input type="hidden" name="action" class="" value="save_form" />
                        <input type="button" name="next" class="next action-button submit-final sign-submit" disabled="disabled" value="Submit Application" />
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <!--<div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Finish:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Payment Step!</h2>
                                </div>
                            </div> <br><br>-->
                            <h2 class="purple-text text-center" style="text-align: center;"><strong>Redirecting... Please wait!</strong></h2> <br>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>