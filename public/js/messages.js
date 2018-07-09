/*!
 *  Lang.js for Laravel localization in JavaScript.
 *
 *  @version 1.1.10
 *  @license MIT https://github.com/rmariuzzo/Lang.js/blob/master/LICENSE
 *  @site    https://github.com/rmariuzzo/Lang.js
 *  @author  Rubens Mariuzzo <rubens@mariuzzo.com>
 */
(function(root,factory){"use strict";if(typeof define==="function"&&define.amd){define([],factory)}else if(typeof exports==="object"){module.exports=factory()}else{root.Lang=factory()}})(this,function(){"use strict";function inferLocale(){if(typeof document!=="undefined"&&document.documentElement){return document.documentElement.lang}}function convertNumber(str){if(str==="-Inf"){return-Infinity}else if(str==="+Inf"||str==="Inf"||str==="*"){return Infinity}return parseInt(str,10)}var intervalRegexp=/^({\s*(\-?\d+(\.\d+)?[\s*,\s*\-?\d+(\.\d+)?]*)\s*})|([\[\]])\s*(-Inf|\*|\-?\d+(\.\d+)?)\s*,\s*(\+?Inf|\*|\-?\d+(\.\d+)?)\s*([\[\]])$/;var anyIntervalRegexp=/({\s*(\-?\d+(\.\d+)?[\s*,\s*\-?\d+(\.\d+)?]*)\s*})|([\[\]])\s*(-Inf|\*|\-?\d+(\.\d+)?)\s*,\s*(\+?Inf|\*|\-?\d+(\.\d+)?)\s*([\[\]])/;var defaults={locale:"en"};var Lang=function(options){options=options||{};this.locale=options.locale||inferLocale()||defaults.locale;this.fallback=options.fallback;this.messages=options.messages};Lang.prototype.setMessages=function(messages){this.messages=messages};Lang.prototype.getLocale=function(){return this.locale||this.fallback};Lang.prototype.setLocale=function(locale){this.locale=locale};Lang.prototype.getFallback=function(){return this.fallback};Lang.prototype.setFallback=function(fallback){this.fallback=fallback};Lang.prototype.has=function(key,locale){if(typeof key!=="string"||!this.messages){return false}return this._getMessage(key,locale)!==null};Lang.prototype.get=function(key,replacements,locale){if(!this.has(key,locale)){return key}var message=this._getMessage(key,locale);if(message===null){return key}if(replacements){message=this._applyReplacements(message,replacements)}return message};Lang.prototype.trans=function(key,replacements){return this.get(key,replacements)};Lang.prototype.choice=function(key,number,replacements,locale){replacements=typeof replacements!=="undefined"?replacements:{};replacements.count=number;var message=this.get(key,replacements,locale);if(message===null||message===undefined){return message}var messageParts=message.split("|");var explicitRules=[];for(var i=0;i<messageParts.length;i++){messageParts[i]=messageParts[i].trim();if(anyIntervalRegexp.test(messageParts[i])){var messageSpaceSplit=messageParts[i].split(/\s/);explicitRules.push(messageSpaceSplit.shift());messageParts[i]=messageSpaceSplit.join(" ")}}if(messageParts.length===1){return message}for(var j=0;j<explicitRules.length;j++){if(this._testInterval(number,explicitRules[j])){return messageParts[j]}}var pluralForm=this._getPluralForm(number);return messageParts[pluralForm]};Lang.prototype.transChoice=function(key,count,replacements){return this.choice(key,count,replacements)};Lang.prototype._parseKey=function(key,locale){if(typeof key!=="string"||typeof locale!=="string"){return null}var segments=key.split(".");var source=segments[0].replace(/\//g,".");return{source:locale+"."+source,sourceFallback:this.getFallback()+"."+source,entries:segments.slice(1)}};Lang.prototype._getMessage=function(key,locale){locale=locale||this.getLocale();key=this._parseKey(key,locale);if(this.messages[key.source]===undefined&&this.messages[key.sourceFallback]===undefined){return null}var message=this.messages[key.source];var entries=key.entries.slice();var subKey="";while(entries.length&&message!==undefined){var subKey=!subKey?entries.shift():subKey.concat(".",entries.shift());if(message[subKey]!==undefined){message=message[subKey];subKey=""}}if(typeof message!=="string"&&this.messages[key.sourceFallback]){message=this.messages[key.sourceFallback];entries=key.entries.slice();subKey="";while(entries.length&&message!==undefined){var subKey=!subKey?entries.shift():subKey.concat(".",entries.shift());if(message[subKey]){message=message[subKey];subKey=""}}}if(typeof message!=="string"){return null}return message};Lang.prototype._findMessageInTree=function(pathSegments,tree){while(pathSegments.length&&tree!==undefined){var dottedKey=pathSegments.join(".");if(tree[dottedKey]){tree=tree[dottedKey];break}tree=tree[pathSegments.shift()]}return tree};Lang.prototype._applyReplacements=function(message,replacements){for(var replace in replacements){message=message.replace(new RegExp(":"+replace,"gi"),function(match){var value=replacements[replace];var allCaps=match===match.toUpperCase();if(allCaps){return value.toUpperCase()}var firstCap=match===match.replace(/\w/i,function(letter){return letter.toUpperCase()});if(firstCap){return value.charAt(0).toUpperCase()+value.slice(1)}return value})}return message};Lang.prototype._testInterval=function(count,interval){if(typeof interval!=="string"){throw"Invalid interval: should be a string."}interval=interval.trim();var matches=interval.match(intervalRegexp);if(!matches){throw"Invalid interval: "+interval}if(matches[2]){var items=matches[2].split(",");for(var i=0;i<items.length;i++){if(parseInt(items[i],10)===count){return true}}}else{matches=matches.filter(function(match){return!!match});var leftDelimiter=matches[1];var leftNumber=convertNumber(matches[2]);if(leftNumber===Infinity){leftNumber=-Infinity}var rightNumber=convertNumber(matches[3]);var rightDelimiter=matches[4];return(leftDelimiter==="["?count>=leftNumber:count>leftNumber)&&(rightDelimiter==="]"?count<=rightNumber:count<rightNumber)}return false};Lang.prototype._getPluralForm=function(count){switch(this.locale){case"az":case"bo":case"dz":case"id":case"ja":case"jv":case"ka":case"km":case"kn":case"ko":case"ms":case"th":case"tr":case"vi":case"zh":return 0;case"af":case"bn":case"bg":case"ca":case"da":case"de":case"el":case"en":case"eo":case"es":case"et":case"eu":case"fa":case"fi":case"fo":case"fur":case"fy":case"gl":case"gu":case"ha":case"he":case"hu":case"is":case"it":case"ku":case"lb":case"ml":case"mn":case"mr":case"nah":case"nb":case"ne":case"nl":case"nn":case"no":case"om":case"or":case"pa":case"pap":case"ps":case"pt":case"so":case"sq":case"sv":case"sw":case"ta":case"te":case"tk":case"ur":case"zu":return count==1?0:1;case"am":case"bh":case"fil":case"fr":case"gun":case"hi":case"hy":case"ln":case"mg":case"nso":case"xbr":case"ti":case"wa":return count===0||count===1?0:1;case"be":case"bs":case"hr":case"ru":case"sr":case"uk":return count%10==1&&count%100!=11?0:count%10>=2&&count%10<=4&&(count%100<10||count%100>=20)?1:2;case"cs":case"sk":return count==1?0:count>=2&&count<=4?1:2;case"ga":return count==1?0:count==2?1:2;case"lt":return count%10==1&&count%100!=11?0:count%10>=2&&(count%100<10||count%100>=20)?1:2;case"sl":return count%100==1?0:count%100==2?1:count%100==3||count%100==4?2:3;case"mk":return count%10==1?0:1;case"mt":return count==1?0:count===0||count%100>1&&count%100<11?1:count%100>10&&count%100<20?2:3;case"lv":return count===0?0:count%10==1&&count%100!=11?1:2;case"pl":return count==1?0:count%10>=2&&count%10<=4&&(count%100<12||count%100>14)?1:2;case"cy":return count==1?0:count==2?1:count==8||count==11?2:3;case"ro":return count==1?0:count===0||count%100>0&&count%100<20?1:2;case"ar":return count===0?0:count==1?1:count==2?2:count%100>=3&&count%100<=10?3:count%100>=11&&count%100<=99?4:5;default:return 0}};return Lang});

(function () {
    Lang = new Lang();
    Lang.setMessages({"en.auth":{"failed":"These credentials do not match our records.","throttle":"Too many login attempts. Please try again in :seconds seconds."},"en.category":{"admin":{"add":{"back":"Back","cancel":"Cancel","name":"Name Category","parent_category":"Parent Category","placeholder_name":"Category Name","reset":"Reset","submit":"Submit","title":"Add Category"},"edit":{"title":"Edit Category"},"list":{"title":"List Categories"},"message":{"add":"Create New Category Successfull!","add_fail":"Can not add New Category. Please check connect database!","del":"Delete Category Successfull!","del_fail":"Can not Delete Category. Please check connect database!","edit":"Update Category Successfull!","edit_fail":"Can not edit Category by this Child!","msg_del":"Do you want to delete this Category?"},"show":{"title":"Show Category"},"table":{"action":"Action","child_category":"Child Category","created_at":"Created At","id":"ID","name":"Name","parent_id":"Parent ID","sum_product":"Sum Product","updated_at":"Updated At"},"title":"Category"}},"en.common":{"approve":"Approved","available":"Available","cancel":"Canceled","cancel-btn":"Cancel","done":"Done","pending":"Pending","reset":"Reset","unavailable":"Unavailable"},"en.homepage":{"admin":{"avg_rating":"Average Rating","new_orders":"New Orders","new_posts":"New Posts","new_users":"New Users","post_comments":"Post and Comments","product_count":"Product(s) in this Order","product_sold":"Product Sold","statistic":{"annually":"Annually Statistic","monthly":"Monthly Statistic","weekly":"Weekly Statistic"},"time":{"all":"All Time","month":"Monthly","week":"Weekly","year":"Yearly"},"title":"HOME","top_active_user":"Top Active Users","top_rating_product":"Top Rating Products","top_text":"Top","top_worth_order":"Top Worth Orders"}},"en.messages":{"add":"Add","add_category":"Add Categories","add_product":"Add Products","adduser":"Add User","categories":"Categories","comments":"Comments","create_product_success":"Create product successfully","create_user_success":"Create user successfully","delete_fail":"Delete Failed","delete_not":"You do not have permission to delete this user !!!","delete_record":"Do you want to delete ?","delete_success":"Delete Successfully","delete_user_fail":"Delete User Fail","delete_user_success":"Delete User Successfully","footer":"Product Tiki - Design by ","home":"Home","orders":"Orders","posts":"Posts","products":"Products","reviews":"Reviews","show_all":"Show All","show_category":"Show Categories","show_order":"Show Order","show_post":"Show Posts","show_product":"Show Products","team":"Team AT Intern Spring PHP","title":"Admin Dashboard","update_product_success":"Update product successfully","update_user_fail":"Update user fail","update_user_success":"Update user successfully","users":"Users"},"en.orders":{"admin":{"list":{"approved_order":"Approved Order","avatar_col":"Avatar","delete_msg":"Do you want to delete Order with ID ","deleted":"Deleted!!!!","id_not_found":"ID not found","note_col":"Note","order_by_total_asc":"Order By Total Ascending","order_by_total_desc":"Order By Total Descending","subtitle":"All Orders","title":"Admin Orders Management","total_col":"Total","total_product":"# of Product(s)","unapproved_order":"Unapproved Order","updated":"Updated!!!!"},"show":{"canceled":"Canceled","on_delivery":"On Delivery","post_col":"Post ID","product_img_col":"Product Images","product_name_col":"Product Name","product_price_col":"Price","quantity_col":"Quantity","subtitle":"All Products of Order ","title":"Order Details","update_msg":"Confirm Status Change For This Order"}}},"en.pagination":{"next":"Next &raquo;","previous":"&laquo; Previous"},"en.passwords":{"password":"Passwords must be at least six characters and match the confirmation.","reset":"Your password has been reset!","sent":"We have e-mailed your password reset link!","token":"This password reset token is invalid.","user":"We can't find a user with that e-mail address."},"en.post":{"admin":{"form":{"content":"Content Text","content_hint":"Input post content","delete_comment_msg":"Do you want to delete comments with ID ","delete_msg":"Do you want to delete posts with ID ","deleted":"Deleted!!!!","form_title":"Form Add Post","id_not_found":"ID not found","product_id":"Product ID","rate":"Reviews Rating","title":"Add Post","type":"Post type","type_comments":"Comments","type_reviews":"Reviews","updated":"Updated!!!!","user_id":"User ID"},"list":{"action_col":"Action","approved_post":"Approved Post","avatar_col":"Avatar","content_col":"Content","go":"Go!","product_col":"Product Name","search":"Search for...","select_title":"Status Option","status_col":"Status","subtitle_index":"All Posts","title":"Admin Posts Management","type_col":"Type","unapproved_post":"Unapproved Post","user_col":"Username"},"show":{"post_col":"Post ID","subtitle":"All subcomments of Post ","title":"Subcomments List"}}},"en.product":{"create":{"category":"Category","create":"Create","description":"Description","file-input":"File Input","image":"Image","name":"Name","preview":"Preview","price":"Price","quantity":"Quantity","table-title":"Create Product","title":"Create Product"},"index":{"action":"Action","avg_rating":"Avg Rating","category":"Category","category_id":"Category Id","created_at":"Created At","delete":"Delete","delete_confirm":"Do you want to delete Product","description":"Description","dir_asc":"ASC","dir_desc":"DESC","edit":"Edit","go":"Go","id":"Id","image":"Image","name":"Name","preview":"Preview","price":"Price","sort_by_avg_rating":"avg_rating","sort_by_category":"category_id","sort_by_name":"name","sort_by_price":"price","sort_by_quantity":"quantity","sort_by_status":"status","status":"Status","table-title":"Product List","title":"Product","update_at":"Update At"},"required":"*","update":{"delete_confirm":"Do you want to delete this Image?","delete_last_file_fail":"Can't delete the last image","table-title":"Update Product","title":"Update Product","update":"Update"}},"en.user":{"index":{"action":"Action","add":"Add","address":"Address","api_token":"Api Token","avatar":"Avatar","back":"Back","created_at":"Created At","createuser":"Create User","delete":"Delete","deleted_at":"Deleted At","detail":"Detail","dob":"Day Of Birth","edit":"Edit","edituser":"Edit User","email":"Email","female":"Female","fullname":"Fullname","gender":"Gender","id":"Id","indentity_card":"Indentity Card","is_active":"Is Active","last_logined_at":"Last Logined at","male":"Male","password":"Password","phone":"Phone","remember_token":"Remember Token","requied":"*","reset":"Reset","role":"Role","showuser":"Show Users","submit":"Submit","title":"USERS","update":"Update","update_at":"Update At","updateuser":"Update User","user_id":"UserId","user_info":"User Info","userinfo":"Detail User Information","username":"Username"}},"en.user.cart":{"need_login_alert":"You need to login to submit cart","quantity_exceed":"The quantity you buy is more than we have","submit_success":"Submit cart successfully"},"en.user.detail_product":{"btn_send_cmt":"Send Comment","cancel":"Cancel","comment":"Comment","five_star":"Five Stars","four_star":"Four Stars","let_see_review":"Check out the review","one_star":"One Star","placeholder_input":"Please enter your comment!","post_message":"Your comment on this product","rating_message":"Your rating of this product","reply":"Reply","review":"Review","review_message":"Write your review below","send":"Send","send_cmt_message":"Send your comment","send_success":"Your comment is sended","three_star":"Three Stars","two_star":"Two Stars"},"en.user.index":{"detail":"Detail","title-new-offers":"New Offers","title-offers":"Top Selling Offers","top-rating":"Top Rating","top-selling":"Top Selling"},"en.user.layout":{"home":"Home","login":"Login","logout":"Logout","page_name":"Product Tiki","products":"Products","profile":"Profile","register":"Register","search":"Search for a Product..."},"en.user.locale":{"en":"English","vi":"Ti\u1ebfng Vi\u1ec7t"},"en.user.login":{"form":{"email_hint":"Email Address","forgot_password":"Forgot Password?","login":"Login","or_go_back":"(Or) go back to","password_hint":"Password","register":"Register Here"},"login_form":"Login Form"},"en.user.mail":{"message":{"approved":"Your order changed status APPROVED","canceled":"Your order changed status CANCELED","on_delivery":"Your order changed status ON DELIVERY","pending":"Your order changed status PENDING"}},"en.user.master":{"title":{"detail":"Detail Product","index":"Product Tiki","product":"Infomation Products"}},"en.user.product":{"price_filter":"Filter By Price","price_range":{"0-5m":"0 - 5.000.000","10m-20m":"10.000.000 - 20.000.000","20m":"20.000.000 - max","5m-10m":"5.000.000 - 10.000.000"},"rating_filter":"Filter by Rating","show":{"description":"Description","preview":"Preview"},"single_page":"Singlepage","sort":{"default":"Default Sorting","popularity":"Sort by popularity","price":"Sort by price","rating":"Sort by average rating"}},"en.user.profile":{"address_col":"Address","avatar":"Avatar","cancel_order_confirm":"Do you want cancel this order?","dob_col":"Day of Birth","edit_profile":"Edit Profile","email_col":"Email","fullname_col":"Full Name","fullname_subcm":"Fullname","gender_col":"Gender","id_col":"Identity Card","next":"More","note_cancel_order":"Please provide a reason for this cancellation blow.","phone_col":"Phone","product_name":"Product name","profile_action":"Action","profile_button_comment":"SubComment","profile_content":"Content","profile_non_order":"Don't have any Order","profile_order_note":"Order's note","profile_product":"Name Product","profile_status":"Status","profile_total":"Total","profile_type":"Type","recent_activity":"Recent Activity","recent_order":"Recent Orders","replies_content_subcm":"Content Subcomment","show_user_post":"Show Posts","show_user_subcomment":"Show Comments","subtitle":"Activity report","title":"My Profile","user_profile":"User Profile","username_col":"Username"},"en.user.register":{"form":{"address":"Address","dob":"Date Of Birth","email":"Email","full_name":"Full Name","gender_default":"Gender","gender_female":"Female","gender_male":"Male","id_card":"Identity Card","information":"Profile information","login_info":"Login information","password":"Password","password_c":"Password Confirmation","phone":"Phone","username":"Username"},"title":"Register"},"en.validation":{"accepted":"The :attribute must be accepted.","active_url":"The :attribute is not a valid URL.","after":"The :attribute must be a date after :date.","after_or_equal":"The :attribute must be a date after or equal to :date.","alpha":"The :attribute may only contain letters.","alpha_dash":"The :attribute may only contain letters, numbers, and dashes.","alpha_num":"The :attribute may only contain letters and numbers.","array":"The :attribute must be an array.","attributes":[],"before":"The :attribute must be a date before :date.","before_or_equal":"The :attribute must be a date before or equal to :date.","between":{"array":"The :attribute must have between :min and :max items.","file":"The :attribute must be between :min and :max kilobytes.","numeric":"The :attribute must be between :min and :max.","string":"The :attribute must be between :min and :max characters."},"boolean":"The :attribute field must be true or false.","confirmed":"The :attribute confirmation does not match.","custom":{"attribute-name":{"rule-name":"custom-message"}},"date":"The :attribute is not a valid date.","date_format":"The :attribute does not match the format :format.","different":"The :attribute and :other must be different.","digits":"The :attribute must be :digits digits.","digits_between":"The :attribute must be between :min and :max digits.","dimensions":"The :attribute has invalid image dimensions.","distinct":"The :attribute field has a duplicate value.","email":"The :attribute must be a valid email address.","exists":"The selected :attribute is invalid.","file":"The :attribute must be a file.","filled":"The :attribute field must have a value.","gt":{"array":"The :attribute must have more than :value items.","file":"The :attribute must be greater than :value kilobytes.","numeric":"The :attribute must be greater than :value.","string":"The :attribute must be greater than :value characters."},"gte":{"array":"The :attribute must have :value items or more.","file":"The :attribute must be greater than or equal :value kilobytes.","numeric":"The :attribute must be greater than or equal :value.","string":"The :attribute must be greater than or equal :value characters."},"image":"The :attribute must be an image.","in":"The selected :attribute is invalid.","in_array":"The :attribute field does not exist in :other.","integer":"The :attribute must be an integer.","ip":"The :attribute must be a valid IP address.","ipv4":"The :attribute must be a valid IPv4 address.","ipv6":"The :attribute must be a valid IPv6 address.","json":"The :attribute must be a valid JSON string.","lt":{"array":"The :attribute must have less than :value items.","file":"The :attribute must be less than :value kilobytes.","numeric":"The :attribute must be less than :value.","string":"The :attribute must be less than :value characters."},"lte":{"array":"The :attribute must not have more than :value items.","file":"The :attribute must be less than or equal :value kilobytes.","numeric":"The :attribute must be less than or equal :value.","string":"The :attribute must be less than or equal :value characters."},"max":{"array":"The :attribute may not have more than :max items.","file":"The :attribute may not be greater than :max kilobytes.","numeric":"The :attribute may not be greater than :max.","string":"The :attribute may not be greater than :max characters."},"mimes":"The :attribute must be a file of type: :values.","mimetypes":"The :attribute must be a file of type: :values.","min":{"array":"The :attribute must have at least :min items.","file":"The :attribute must be at least :min kilobytes.","numeric":"The :attribute must be at least :min.","string":"The :attribute must be at least :min characters."},"not_in":"The selected :attribute is invalid.","not_regex":"The :attribute format is invalid.","numeric":"The :attribute must be a number.","present":"The :attribute field must be present.","regex":"The :attribute format is invalid.","required":"The :attribute field is required.","required_if":"The :attribute field is required when :other is :value.","required_unless":"The :attribute field is required unless :other is in :values.","required_with":"The :attribute field is required when :values is present.","required_with_all":"The :attribute field is required when :values is present.","required_without":"The :attribute field is required when :values is not present.","required_without_all":"The :attribute field is required when none of :values are present.","same":"The :attribute and :other must match.","size":{"array":"The :attribute must contain :size items.","file":"The :attribute must be :size kilobytes.","numeric":"The :attribute must be :size.","string":"The :attribute must be :size characters."},"string":"The :attribute must be a string.","timezone":"The :attribute must be a valid zone.","unique":"The :attribute has already been taken.","uploaded":"The :attribute failed to upload.","url":"The :attribute format is invalid."},"vi.user.detail_product":{"btn_send_cmt":"G\u1eedi b\u00ecnh lu\u1eadn","cancel":"H\u1ee7y","comment":"B\u00ecnh lu\u1eadn","five_star":"Tuy\u1ec7t v\u1eddi","four_star":"T\u1ed1t","let_see_review":"Check out the review","one_star":"Qu\u00e1 k\u00e9m","placeholder_input":"H\u00e3y nh\u1eadp b\u00ecnh lu\u1eadn!","post_message":"B\u00ecnh lu\u1eadn c\u1ee7a b\u1ea1n v\u1ec1 s\u1ea3n ph\u1ea9m","rating_message":"\u0110\u00e1nh gi\u00e1 c\u1ee7a b\u1ea1n v\u1ec1 s\u1ea3n ph\u1ea9m","reply":"Tr\u1ea3 l\u1eddi","review":"\u0110\u00e1nh gi\u00e1","review_message":"Vi\u1ebft \u0111\u00e1nh gi\u00e1 b\u00ean d\u01b0\u1edbi","send":"G\u1eedi","send_cmt_message":"G\u1eedi b\u00ecnh lu\u1eadn.","send_success":"B\u00ecnh lu\u1eadn c\u1ee7a b\u1ea1n \u0111\u00e3 \u0111\u01b0\u1ee3c g\u1eedi","three_star":"Trung b\u00ecnh","two_star":"K\u00e9m"},"vi.user.index":{"detail":"Chi ti\u1ebft","title-new-offers":"S\u1ea3n ph\u1ea9m m\u1edbi","title-offers":"Top b\u00e1n nhi\u1ec1u","top-rating":"Top \u01b0a th\u00edch","top-selling":"Top b\u00e1n nhi\u1ec1u"},"vi.user.layout":{"home":"Trang ch\u1ee7","login":"\u0110\u0103ng nh\u1eadp","logout":"\u0110\u0103ng xu\u1ea5t","page_name":"Product Tiki","products":"S\u1ea3n ph\u1ea9m","profile":"C\u00e1 nh\u00e2n","register":"\u0110\u0103ng k\u00fd","search":"T\u00ecm ki\u1ebfm"},"vi.user.login":{"form":{"email_hint":"Email","forgot_password":"Qu\u00ean m\u1eadt kh\u1ea9u","login":"\u0110\u0103ng nh\u1eadp","or_go_back":"Quay l\u1ea1i","password_hint":"M\u1eadt kh\u1ea9u","register":"\u0110\u0103ng k\u00fd"},"login_form":"\u0110\u0103ng nh\u1eadp"},"vi.user.master":{"title":{"detail":"Chi ti\u1ebft s\u1ea3n ph\u1ea9m","index":"Product Tiki","product":"Th\u00f4ng tin s\u1ea3n ph\u1ea9m"}},"vi.user.product":{"price_filter":"L\u1ecdc theo gi\u00e1 ti\u1ec1n","price_range":{"0-5m":"0 - 5.000.000","10m-20m":"10.000.000 - 20.000.000","20m":"20.000.000 - t\u1ed1i \u0111a","5m-10m":"5.000.000 - 10.000.000"},"rating_filter":"L\u1ecdc theo \u0111\u00e1nh gi\u00e1","show":{"description":"M\u00f4 t\u1ea3 s\u1ea3n ph\u1ea9m"},"single_page":"Chi ti\u1ebft s\u1ea3n ph\u1ea9m","sort":{"default":"S\u1eafp x\u1ebfp m\u1eb7c \u0111\u1ecbnh","popularity":"S\u1eafp x\u1ebfp theo \u0111\u1ed9 ph\u1ed5 bi\u1ebfn","price":"S\u1eafp x\u1ebfp theo gi\u00e1 ti\u1ec1n","rating":"S\u1eafp x\u1ebfp theo \u0111\u00e1nh gi\u00e1"}},"vi.user.profile":{"address_col":"\u0110\u1ecba ch\u1ec9","avatar":"\u1ea2nh \u0111\u1ea1i di\u1ec7n","dob_col":"Ng\u00e0y sinh","edit_profile":"Ch\u1ec9nh s\u1eeda th\u00f4ng tin","email_col":"Email","fullname_col":"T\u00ean \u0111\u1ea7y \u0111\u1ee7","fullname_subcm":"T\u00ean \u0111\u1ea7y \u0111\u1ee7","gender_col":"Gi\u1edbi t\u00ednh","id_col":"CMND","next":"Xem th\u00eam","phone_col":"S\u1ed1 \u0111i\u1ec7n tho\u1ea1i","product_name":"T\u00ean s\u1ea3n ph\u1ea9m","profile_action":"","profile_button_comment":"B\u00ecnh lu\u1eadn","profile_content":"Th\u00f4ng tin","profile_non_order":"Kh\u00f4ng c\u00f3 \u0111\u01a1n h\u00e0ng n\u00e0o","profile_order_note":"Ghi ch\u00fa cho \u0111\u01a1n h\u00e0ng","profile_product":"T\u00ean s\u1ea3n ph\u1ea9m","profile_status":"Tr\u1ea1ng th\u00e1i","profile_total":"T\u1ed5ng gi\u00e1","profile_type":"Lo\u1ea1i","recent_activity":"Ho\u1ea1t \u0111\u1ed9ng g\u1ea7n \u0111\u00e2y","recent_order":"\u0110\u01a1n h\u00e0ng g\u1ea7n \u0111\u00e2y","replies_content_subcm":"N\u1ed9i dung b\u00ecnh lu\u1eadn","show_user_post":"Hi\u1ec7n b\u00e0i \u0111\u0103ng","show_user_subcomment":"Hi\u1ec7n c\u00e1c b\u00ecnh lu\u1eadn","subtitle":"Th\u1ed1ng k\u00ea c\u00e1c ho\u1ea1t \u0111\u1ed9ng","title":"Trang c\u00e1 nh\u00e2n","user_profile":"Th\u00f4ng tin","username_col":"Username"},"vi.user.register":{"form":{"address":"\u0110\u1ecba ch\u1ec9","dob":"Ng\u00e0y sinh","email":"Email","full_name":"T\u00ean \u0111\u1ea7y \u0111\u1ee7","gender_default":"Gi\u1edbi t\u00ednh","gender_female":"N\u1eef","gender_male":"Nam","id_card":"CMND","information":"Th\u00f4ng tin c\u00e1 nh\u00e2n","login_info":"Th\u00f4ng tin \u0111\u0103ng nh\u1eadp","password":"M\u1eadt kh\u1ea9u","password_c":"X\u00e1c nh\u1eadn m\u1eadt kh\u1ea9u","phone":"S\u1ed1 \u0111i\u1ec7n tho\u1ea1i","username":"Username"},"title":"\u0110\u0103ng k\u00fd"}});
})();
