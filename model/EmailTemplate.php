<?php
   //***************** Author : Bhawna Pandey *******************//
    
   require_once "Globals.php";
   
   class EmailTemplate
   {
	   public static function getVerifyEmailTemplate($user, $link)
	   {
		   return $str = '<head>
		                    <title></title>
						    <meta http-equiv="X-UA-Compatible" content="IE=edge">
			                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			                <meta name="ROBOTS" content="noindex, nofollow">
							<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">
							<style type="text/css">
                               @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
                            </style>
		                  </head>
						  <body>
						     <div style="background-color:#F9F9F9;">
							    <div style="max-width:640px;margin:0 auto;box-shadow:0px 1px 5px rgba(0,0,0,0.1);border-radius:4px;overflow:hidden">
								  <div style="margin:0px auto;max-width:640px;background:#7289DA ">
									<table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#7289DA align="center" border="0" >
										<tbody>
											<tr>
												<td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:57px;">
													<div style="cursor:auto;color:white;font-family:Whitney, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif;font-size:30px;font-weight:500;line-height:36px;text-align:center;margin-bottom: 34px;    margin-top: -46px;	">Welcome to World Voting!	
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								  </div>
								  <div style="margin:0px auto;max-width:640px;background:#ffffff;">
								     <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#ffffff;" align="center" border="0">
									    <tbody>
										   <tr>
										      <td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:40px 70px;">
											      <div aria-labelledby="mj-column-per-100" class="mj-column-per-100 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%;">
												      <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
													     <tbody>
														      <tr>
															     <td style="word-break:break-word;font-size:0px;padding:0px 0px 20px;" align="left">
																    <div style="cursor:auto;color:#737F8D;font-family:Whitney, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif;font-size:16px;line-height:24px;text-align:left;">
																	  <h2 style="font-family: Whitney, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif;font-weight: 500;font-size: 20px;color: #4F545C;letter-spacing: 0.27px;">Hey ' . $user . ',</h2>
																	   <p>Thanks for registering an account with world voting. </p>
															<p>Before we get started, we\'ll need to verify your email.</p><br/>
																	</div>
																 </td>
															  </tr>	
															  <tr>
													            <td style="word-break:break-word;font-size:0px;padding:10px 25px;" align="center">
													               <table role="presentation" cellpadding="0" cellspacing="0" style="border-collapse:separate;" align="center" border="0">
																	   <tbody>
																			<tr>
																			<td style="border:none;border-radius:3px;color:white;cursor:auto;padding:15px 19px;" align="center" valign="middle" bgcolor="#7289DA">
																					<a href="' .Globals::$emailImagePath. $link . '" style="text-decoration:none;line-height:100%;background:#7289DA;color:white;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;font-weight:normal;text-transform:none;margin:0px;" target="_blank">
																					Verify Email
																					</a>
																				</td>
																			</tr>
																		</tbody>
																	</table>
													            </td>
												              </tr>
														 </tbody>
													  </table>
												  </div>
											  </td>
										   </tr>
										</tbody>
									 </table>
								  </div>
								</div>
							 </div>
							 <div style="margin:0px auto;max-width:640px;background:transparent;">
				               <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:transparent;" align="center" border="0">
					             <tbody>
						          <tr>
							       <td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:20px 0px;">
								     <div aria-labelledby="mj-column-per-100" class="mj-column-per-100 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%;">
									    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
										   <tbody>
											  <tr>
												 <td style="word-break:break-word;font-size:0px;padding:0px;" align="center">
													<div style="cursor:auto;color:#99AAB5;font-family:Whitney, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif;font-size:12px;line-height:24px;text-align:center;">
														Sent by world voting with &hearts; 
													</div>
												  </td>
											   </tr>
											</tbody>
									    </table>
								   </div>
							    </td>
						      </tr>
					        </tbody>
				             </table>
			               </div>
						  </body>
						  ';
	   }
   }
   
?>