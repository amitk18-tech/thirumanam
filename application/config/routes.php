<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'WelcomeController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/* frontend routes */

$route['register'] 						= 'LoginController/register';
$route['login'] 						= 'LoginController/login';
$route['forget_password'] 				= 'LoginController/forgetPassword';
$route['register'] 						= 'LoginController/register';
$route['verify_otp/(:num)/(:any)'] 		= 'LoginController/verifyOtp/$1/$2';
$route['home'] 							= 'WelcomeController/home';
$route['profile'] 						= 'WelcomeController/profileView';
$route['contact'] 						= 'WelcomeController/contact';
$route['memories'] 						= 'WelcomeController/memories';
$route['Subscription'] 			    	= 'WelcomeController/Subscription';
$route['Subscribe/(:num)'] 				= 'WelcomeController/Subscribe/$1';
$route['faq'] 			            	= 'WelcomeController/faq';
$route['terms_and_conditions'] 	    	= 'WelcomeController/termsAndConditions';
$route['privacy_policy'] 				= 'WelcomeController/privacyPolicy';


$route['printMember/(:num)']            = 'WelcomeController/printMember/$1';
$route['matched_members']				='WelcomeController/matchedMembers/0';
$route['matched_members/(:num)']		='WelcomeController/matchedMembers/$1';
$route['matched_member_list']			='WelcomeController/matched_member_list/0';
$route['matched_member_list/(:num)']	='WelcomeController/matched_member_list/$1';
$route['matched_member_lists']			='WelcomeController/matched_member_lists/0';
$route['matched_member_lists/(:num)']	='WelcomeController/matched_member_lists/$1';
$route['short_view/(:num)'] 			= 'WelcomeController/shortView/$1';
$route['full_view/(:num)'] 			    = 'WelcomeController/fullView/$1';
$route['full_view'] 			        = 'WelcomeController/fullView';

$route['active_members']				='WelcomeController/activeMembers/0';
$route['active_members/(:num)']			='WelcomeController/activeMembers/$1';
$route['active_member_list']			='WelcomeController/active_member_list/0';
$route['active_member_list/(:num)']		='WelcomeController/active_member_list/$1';
$route['active_member_lists']			='WelcomeController/active_member_lists/0';
$route['active_member_lists/(:num)']	='WelcomeController/active_member_lists/$1';

$route['active_member_search']				='WelcomeController/active_member_search/';

$route['match_member_search']				='WelcomeController/match_member_search/';

############################################################################
//                             ADMIN PORTAL URLS
############################################################################

$route['administrator']				='LoginController/admin_login';
$route['administrator/home'] = 'AdminController/index';
$route['administrator/logout'] = 'LoginController/admin_logout';
$route['administrator/logout'] = 'LoginController/admin_logout';


$route['administrator/all_members'] = 'AdminController/allmembers';
$route['administrator/all_members/offline'] = 'AdminController/offlineMembers';
$route['administrator/all_members/online'] = 'AdminController/onlineMembers';
$route['administrator/all_members/report'] = 'AdminController/reportMembers';
$route['administrator/all_members/view_member/(:num)'] = 'AdminController/viewMember/$1';
$route['administrator/all_members/edit_member/(:num)'] = 'AdminController/editMember/$1';
$route['get_city_of_state_ajax_admin']		='AdminController/get_city_of_state_ajax_admin';
$route['get_city_of_state_ajax_front']		='WelcomeController/get_city_of_state_ajax_front';
$route['get_city_of_state_ajax_app']		='AppController/get_city_of_state_ajax_app';
$route['get_email_templates']		='AdminController/get_email_templates';
$route['get_membership_data_ajax_admin']		='AdminController/get_membership_data_ajax_admin';
$route['administrator/printMember/(:num)'] = 'AdminController/printMember/$1';
$route['administrator/print_admin_Member/(:num)'] = 'AdminController/print_admin_Member/$1';
$route['administrator/deleteMember/(:num)'] = 'AdminController/deleteMember/$1';
$route['administrator/matchMember/(:num)'] = 'AdminController/matchMember/$1';
$route['administrator/deleteMemberPermanant/(:any)'] = 'AdminController/deleteMemberPermanant/$1';
$route['administrator/deleteMemberPermanantly/(:any)'] = 'AdminController/deleteMemberPermanantly/$1';
$route['administrator/blockMember'] = 'AdminController/blockMember';
$route['administrator/blockMemberr/(:any)'] = 'AdminController/blockMemberr/$1';
$route['administrator/closeMember'] = 'AdminController/closeMember';
$route['administrator/closeMemberr/(:any)'] = 'AdminController/closeMemberr/$1';
$route['administrator/offline_members'] = 'AdminController/offlineRegisterMembers';
$route['administrator/offline_members/male'] = 'AdminController/offlineRegisterMale';
$route['administrator/offline_members/female'] = 'AdminController/offlineRegisterFemale';
$route['administrator/pending_renewal'] = 'AdminController/pendingRenewal';
$route['administrator/pending_renewal/offline'] = 'AdminController/pendingRenewalOffline';
$route['administrator/pending_renewal/online'] = 'AdminController/pendingRenewalOnline';
$route['administrator/pending_renewal/online_unpaid'] = 'AdminController/pendingOnlineUnpaid';
$route['administrator/incomplete_profile'] = 'AdminController/incompleteProfile';
$route['administrator/incomplete_profile/online_paid'] = 'AdminController/incompleteonlinePaid';
$route['administrator/incomplete_profile/online_unpaid'] = 'AdminController/incompleteonlineUnpaid';
$route['administrator/incomplete_profile/offline'] = 'AdminController/incompleteOffline';
$route['administrator/without_profile'] = 'AdminController/withoutProfile';
$route['administrator/without_profile/offline'] = 'AdminController/withoutProfileOffline';
$route['administrator/without_profile/online'] = 'AdminController/withoutProfileOnline';
$route['administrator/bulk_profile_print'] = 'AdminController/bulkProfilePrint';
$route['administrator/bulk_profile_print/male'] = 'AdminController/bulkPrintMale';
$route['administrator/bulk_profile_print/female'] = 'AdminController/bulkPrintFemale';
$route['administrator/print_bulk_member/0'] = 'AdminController/printBulkMember/$1';
$route['administrator/block_members'] = 'AdminController/blockMembers';
$route['administrator/block_members/offline'] = 'AdminController/blockMembersOffline';
$route['administrator/block_members/online'] = 'AdminController/blockMembersOnline';
$route['administrator/unblockMember/(:num)'] = 'AdminController/unblockMember/$1';
$route['administrator/close_members'] = 'AdminController/closeMembers';
$route['administrator/close_members/offline'] = 'AdminController/closeMembersOffline';
$route['administrator/close_members/online'] = 'AdminController/closeMembersOnline';
$route['administrator/unclosemember/(:num)'] = 'AdminController/uncloseMember/$1';
$route['administrator/duplicate_members'] = 'AdminController/duplicateMembers';
$route['administrator/duplicate_members/offline'] = 'AdminController/duplicateMembersOffline';
$route['administrator/duplicate_members/online'] = 'AdminController/duplicateMembersOnline';
$route['administrator/online_members'] = 'AdminController/onlineRegisterMembers';
$route['administrator/online_members/male'] = 'AdminController/onlineRegisterMale';
$route['administrator/online_members/female'] = 'AdminController/onlineRegisterFemale';
$route['administrator/online_members/renew'] = 'AdminController/onlineRegisterRenew';
$route['administrator/online_members/unpaid'] = 'AdminController/onlineRegisterUnpaid';
$route['administrator/add_new_member'] = 'AdminController/addNewMember';
$route['administrator/deleted_members'] = 'AdminController/deletedMembers';
$route['administrator/restoreMember/(:any)'] = 'AdminController/restoreMember/$1';
$route['administrator/old_id_of_renewed_members'] = 'AdminController/oldIdRenewedMembers';
$route['administrator/reported_members'] = 'AdminController/reportedMembers';
$route['administrator/membership_plans'] = 'AdminController/membershipPlans';
$route['administrator/add_plan'] = 'AdminController/addPlan';
$route['administrator/edit_plan/(:num)'] = 'AdminController/editPlan/$1';
$route['administrator/stories'] = 'AdminController/successStories';
$route['administrator/stories/view_story/(:num)'] = 'AdminController/viewStory/$1';
$route['administrator/aprove/(:num)'] = 'AdminController/aproveStory/$1';
$route['administrator/disaprove/(:num)'] = 'AdminController/disaproveStory/$1';
$route['administrator/deleteStory/(:num)'] = 'AdminController/deleteStory/$1';
$route['administrator/activation/online'] = 'AdminController/onlineEarnings';
$route['administrator/activation/offline'] = 'AdminController/offlineEarnings';
$route['administrator/activation'] = 'AdminController/totalEarnings';
$route['administrator/acceptMember'] = 'AdminController/acceptMember';
$route['administrator/deletepayment/(:num)'] = 'AdminController/deletePayment/$1';
$route['administrator/contact_message'] = 'AdminController/contactMessage';
$route['administrator/contact_message/view_message/(:num)'] = 'AdminController/viewMessage/$1';
$route['administrator/deleteMessage/(:num)'] = 'AdminController/deleteMessage/$1';
$route['administrator/news_letter'] = 'AdminController/newsLetter';
$route['administrator/expiry_alert'] = 'AdminController/expiryAlert';
$route['administrator/memories'] = 'AdminController/memories';
$route['administrator/send_sms'] = 'AdminController/feedSms';
$route['administrator/important_notes'] = 'AdminController/importantNotes';
$route['administrator/Manage_admin_profile'] = 'AdminController/ManageAdminProfile';
$route['administrator/all_staffs'] = 'AdminController/allStaffs';
$route['administrator/all_staffs/edit_admin/(:num)'] = 'AdminController/editAdmin/$1';
$route['administrator/deleteAdmin/(:num)'] = 'AdminController/deleteAdmin/$1';
$route['administrator/add_staff'] = 'AdminController/addStaff';
$route['administrator/manage_role'] = 'AdminController/manageRole';
$route['administrator/manage_role/edit_role/(:num)'] = 'AdminController/editRole/$1';
$route['administrator/add_role'] = 'AdminController/addRole';
$route['administrator/deleteRole/(:num)'] = 'AdminController/deleteRole/$1';
$route['administrator/reports'] = 'AdminController/reports';
$route['administrator/edit_terms_and_conditions'] = 'AdminController/editTermsandConditions';
$route['administrator/edit_privacy_policy'] = 'AdminController/editPrivacyPolicy';
$route['administrator/member_activity'] = 'AdminController/memberActivity';
$route['administrator/edit_template/(:num)'] = 'AdminController/editTemplate/$1';
$route['administrator/admin_activity'] = 'AdminController/adminActivity';
$route['administrator/matched_members'] = 'AdminController/matchedMembers';
$route['administrator/matched_members/male'] = 'AdminController/matchedMembersMale';
$route['administrator/matched_members/female'] = 'AdminController/matchedMembersFemale';
$route['administrator/add_faq'] = 'AdminController/addFaq';
$route['administrator/view_faq'] = 'AdminController/viewFaq';
$route['administrator/Common_faq'] = 'AdminController/CommonFaq';
$route['administrator/online_faq'] = 'AdminController/onlineFaq';
$route['administrator/offline_faq'] = 'AdminController/offlineFaq';
$route['administrator/view_template'] = 'AdminController/viewTemplate';
$route['administrator/add_template'] = 'AdminController/addtemplate';
$route['administrator/edit_faq/(:num)'] = 'AdminController/editFaq/$1';
$route['administrator/deactivated_members'] = 'AdminController/deactivatedMembers';
$route['administrator/activateMember/(:num)'] = 'AdminController/activateMember/$1';
$route['administrator/printMember/(:num)'] = 'AdminController/printMember/$1';
$route['administrator/preview_template/(:num)'] = 'AdminController/previewTemplate/$1';
$route['administrator/customer_server_table']='AjaxController/all_customers_server_data_table';
$route['administrator/offline_customer_server_table']='AjaxController/offline_customer_server_table';
$route['administrator/online_customer_server_table']='AjaxController/online_customer_server_table';
$route['administrator/offlineRegisterMembers']='AjaxController/offlineRegisterMembers';
$route['administrator/offlineRegisterMale']='AjaxController/offlineRegisterMale';
$route['administrator/offlineRegisterFemale']='AjaxController/offlineRegisterFemale';
$route['administrator/pendingRenewalMembers']='AjaxController/pendingRenewalMembers';
$route['administrator/pendingRenewalOfflineMembers']='AjaxController/pendingRenewalOfflineMembers';
$route['administrator/pendingRenewalOnlineMembers']='AjaxController/pendingRenewalOnlineMembers';
$route['administrator/pendingRenewalUnpaidMembers']='AjaxController/pendingRenewalUnpaidMembers';
$route['administrator/incompleteMembers']='AjaxController/incompleteMembers';
$route['administrator/incompleteOnlinePaidMembers']='AjaxController/incompleteOnlinePaidMembers';
$route['administrator/incompleteOnlineUnPaidMembers']='AjaxController/incompleteOnlineUnPaidMembers';
$route['administrator/incompleteOfflineMembers']='AjaxController/incompleteOfflineMembers';
$route['administrator/withoutProfileMembers']='AjaxController/withoutProfileMembers';
$route['administrator/withoutProfileOfflineMembers']='AjaxController/withoutProfileOfflineMembers';
$route['administrator/withoutProfileOnlineMembers']='AjaxController/withoutProfileOnlineMembers';
$route['administrator/blockedMembers']='AjaxController/blockedMembers';
$route['administrator/blockedOnlineMembers']='AjaxController/blockedOnlineMembers';
$route['administrator/blockedOfflineMembers']='AjaxController/blockedOfflineMembers';
$route['administrator/closedMembers']='AjaxController/closedMembers';
$route['administrator/closedOnlineMembers']='AjaxController/closedOnlineMembers';
$route['administrator/closedOfflineMembers']='AjaxController/closedOfflineMembers';
$route['administrator/duplicatedMembers']='AjaxController/duplicatedMembers';
$route['administrator/duplicatedOnlineMembers']='AjaxController/duplicatedOnlineMembers';
$route['administrator/duplicatedOfflineMembers']='AjaxController/duplicatedOfflineMembers';
$route['administrator/onlineRegisterMember']='AjaxController/onlineRegisterMember';
$route['administrator/onlineRegistermaleMember']='AjaxController/onlineRegistermaleMember';
$route['administrator/onlineRegisterfemaleMember']='AjaxController/onlineRegisterfemaleMember';
$route['administrator/onlineRegisterRenewedMember']='AjaxController/onlineRegisterRenewedMember';
$route['administrator/deleteMembers']='AjaxController/deleteMembers';
$route['administrator/oldRenewedMember']='AjaxController/oldRenewedMember';
$route['administrator/reportMember']='AjaxController/reporteMember';
$route['administrator/matchedMember']='AjaxController/matchedProfileMember';
$route['administrator/matchedProfileMaleMember']='AjaxController/matchedProfileMaleMember';
$route['administrator/matchedProfileFeMaleMember']='AjaxController/matchedProfileFeMaleMember';
$route['administrator/deactivatedMember']='AjaxController/deactivatedMember';
$route['administrator/reportProfileMember']='AjaxController/reportProfileMember';
$route['administrator/total_earnings']='AjaxController/total_earnings';
$route['administrator/total_earnings_online']='AjaxController/total_earnings_online';
$route['administrator/total_earnings_offline']='AjaxController/total_earnings_offline';
$route['administrator/member_activities']='AjaxController/member_activities';


/* Mobile App */
$route['app/login'] 					    = 'AppController/index';
$route['app/register'] 						= 'LoginController/appregister';
$route['app_verify_otp/(:num)/(:any)'] 		= 'LoginController/appverifyOtp/$1/$2';
$route['app_forget_password'] 				= 'LoginController/appforgetPassword';
$route['app'] 					            = 'AppController/index';
$route['app/home'] 					        = 'AppController/home';
$route['app/profile'] 						= 'AppController/profileView';
$route['app/edit_profile'] 					= 'AppController/editProfile';
$route['app/my_interests'] 					= 'AppController/myInterests/0';
$route['app/my_interests/(:num)'] 					= 'AppController/myInterests/$1';
$route['app/opposite_interests'] 					= 'AppController/oppositeInterests/0';
$route['app/opposite_interests/(:num)'] 					= 'AppController/oppositeInterests/$1';
$route['app/matched_members'] 					= 'AppController/matchedMembers/0';
$route['app/matched_members/(:num)'] 					= 'AppController/matchedMembers/$1';
$route['app/shortlist'] 					= 'AppController/shortlist/0';
$route['app/shortlist/(:num)'] 					= 'AppController/shortlist/$1';
$route['app/viewlist'] 					= 'AppController/viewlist/0';
$route['app/viewlist/(:num)'] 					= 'AppController/viewlist/$1';
$route['app/followed_users'] 				= 'AppController/followedUsers/0';
$route['app/followed_users/(:num)'] 				= 'AppController/followedUsers/$1';
$route['app/ignored_list'] 					= 'AppController/ignoredList/0';
$route['app/ignored_list/(:num)'] 					= 'AppController/ignoredList/$1';
$route['app/profile_viewed_details'] 		= 'AppController/profileViewedDetails/0';
$route['app/profile_viewed_details/(:num)'] 		= 'AppController/profileViewedDetails/$1';
$route['app/profile_viewer_details'] 		= 'AppController/profileViewerDetails/0';
$route['app/profile_viewer_details/(:num)'] 		= 'AppController/profileViewerDetails/$1';
$route['app/messaging'] 					= 'AppController/messaging';
$route['app/gallery'] 						= 'AppController/gallery';
$route['app/happy_story'] 					= 'AppController/happyStory';
$route['app/change_password'] 				= 'AppController/changePassword';
$route['app/notification'] 					= 'AppController/notification';
$route['app/message'] 						= 'AppController/message';




$route['app/active_member_search']			= 'AppController/activeSearch';
$route['app/active_member_search/appearance_search']			= 'AppController/appearanceSearch';
$route['app/active_member_search/edupro_search']			= 'AppController/eduProSearch';
$route['app/active_member_search/family_search']			= 'AppController/familySearch';
$route['app/active_member_search/astrologic_search']			= 'AppController/astrologicSearch';
$route['app/active_member_search/active_search_all']				= 'AppController/activeSearchAll';


$route['app/match_member_search']			= 'AppController/matchSearch';
$route['app/match_member_search/appearance_search']			= 'AppController/matchappearanceSearch';
$route['app/match_member_search/edupro_search']			= 'AppController/matcheduProSearch';
$route['app/match_member_search/family_search']			= 'AppController/matchfamilySearch';
$route['app/match_member_search/astrologic_search']			= 'AppController/matchastrologicSearch';
$route['app/match_member_search/match_search_all']				= 'AppController/matchSearchAll';




$route['app/active_member_list']			= 'AppController/active_member_list/0';
$route['app/active_member_list/(:num)']		= 'AppController/active_member_list/$1';
$route['app/active_member_lists']			= 'AppController/active_member_lists/0';
$route['app/active_member_lists/(:num)']	= 'AppController/active_member_lists/$1';
$route['app/short_view/(:num)'] 			= 'AppController/shortView/$1';
$route['app/full_view/(:num)'] 			    = 'AppController/fullView/$1';
$route['app/Subscription'] 			    	= 'AppController/Subscription';
$route['app/contact'] 						= 'AppController/contact';
$route['app/memories'] 						= 'AppController/memories';

$route['app/active_seach_list']				= 'AppController/active_seach_list';

$route['app/match_seach_list']				= 'AppController/match_seach_list';



$route['app/matched_member_search']			= 'AppController/matchedSearch';
$route['app/matched_member_list']			= 'AppController/matched_member_list/0';
$route['app/matched_member_list/(:num)']	= 'AppController/matched_member_list/$1';
$route['app/matched_member_lists']			= 'AppController/matched_member_lists/0';
$route['app/matched_member_lists/(:num)']	= 'AppController/matched_member_lists/$1';