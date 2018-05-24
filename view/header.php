<?php
include_once "../controller/SessionController.php";
if(isset($user->id))
{
$userLocation = explode(",",$user->address);
$showAddress = implode(" >",$userLocation);
?>
<input type="hidden" value="<?=$showAddress?>" name="location" id="location">
<?php
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="../assets/js/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="../assets/js/bootstrap/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="../assets/fontawesome-free-5.0.9/web-fonts-with-css/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/css/switch-button.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="google-signin-client_id" content="676093572411-cub5jckhvr30amda7vqcq15730kjgno9.apps.googleusercontent.com">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>World Voting</title>
    <style>
      .profile{
        border: 3px solid #B7B7B7;
        padding: 10px;
        margin-top: 10px;
        width: 350px;
        background-color: #F7F7F7;
        height: 160px;
      }
      .profile p{
        margin: 0px 0px 10px 0px;
      }
      .head{
        margin-bottom: 10px;
      }
      .head a{
        float: right;
      }
      .profile img{
        width: 100px;
        float: left;
        margin: 0px 10px 10px 0px;
      }
      .proDetails{
        float: left;
      }
    </style>
  </head>
  <body>
    <section>
      <div class="container-fluid" style="background: #013775;">
        <?php
        if(!isset($user->id)) {
        ?>
        <div  style="z-index: 55;position:absolute;margin-left: 88%;float: right;top: 18px;">
          <a href="" data-toggle="modal" data-target="#loginSignup" style="font-weight:600;color: white;font-size: 19px;">
            <span class="glyphicon glyphicon-log-in">
            </span> Login/Signup
          </a>
        </div>
        <?php
        } else {
        ?>
        <div  style="z-index: 55;position:absolute;margin-left: 83%;float: right;top: 18px;">
          <a href="#" style="font-weight:600;color: white;font-size: 18px;">Welcome,
            <?=$user->firstName." ".$user->lastName?>
          </a>
        </div>
        <?php	 } ?>
        <div class="row">
          <div class="col-md-2 col-sm-4 col-xs-4" style="border-right: 2px solid #9c9cdd;padding: 23px 0px 0px 0px;height: 160px;">
            <img src="../assets/images/logo.png" class="img-responsive"/>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-4">
            <ul style="display:flex;list-style-type: none;padding: 9px 5px;">
              <li class="flag_img">
        <?php if(!isset($user->id)) { ?>
                <img src="../assets/images/users/no_image_user.png" class="head_img"/>
        <?php } else {
                if((isset($user->profile)) && ($user->profile != '')) {
        ?>
                <img src="../assets/images/users/<?=$user->profile?>" class="head_img"/>
        <?php } else { ?>
                <img src="../assets/images/users/no_image_user.png" class="head_img"/>
        <?php	}
        }
        ?>
              </li>
              <li class="flag_img">
                <img src="../assets/images/country/india-flag.jpg" class="head_flag_img"/>
              </li>
            </ul>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-8">
            <div id="custom-search-input">
              <div class="input-group ">
                <input type="text" class=" search_input search-query " placeholder="Search on worldvoting.org " />
                <span class="input-group-btn input_left">
                  <button class="btn btn-danger" type="button">
                    <span class=" glyphicon glyphicon-search">
                    </span>
                  </button>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-8">
            <?php
              if(isset($user->id)) {
            ?>
            <span class="menu_icons">
              <span title="Profile">
                <i class="far fa-user-circle">
                </i>
              </span>
              <span title="Location">
                <i class="far fa-compass">
                </i>
              </span>
              <span title="Notification">
                <i class="far fa-bell">
                </i>
              </span>
              <span title="Logout" class="logout">
                <i class="fas fa-sign-out-alt">
                </i>
              </span>
            </span>
            <?php
              }
            ?>
          </div>
        </div>
      </div>
    </section>
    <div class="container-fluid">
      <div class="row scroll123">
        <div class="col-md-2 col_padding" style="background:#619919;">
          <?php if( isset( $user->id ) ) { ?>
          <a class="nav_menu_a nav_li_font active flagvote" href="#" >World </a>
          <?php } else { ?>
          <a class="nav_menu_a nav_li_font active" href="#" >World </a>
          <?php } ?>
        </div>
        <div class="col-md-2 col_padding" style="background:#dd7518;text-align: center;">
          <?php if(isset($user->id)) { ?>
          <a class="nav_menu_a nav_li_font flagvote" href="#"  >
            <?=$userLocation[5]?>
          </a>
          <?php } else { ?>
          <a class="nav_menu_a nav_li_font" href="#" >country
          </a>
          <?php } ?>
        </div>
        <div class="col-md-2 col_padding" style="background:#1995bf;text-align: center;">
          <?php if( isset( $user->id ) ) {
                  $state = $userLocation[4];
                  $case = " ";
                  $state1 = trim($state,$case);
                  $state2 = explode(" ",$state1);
            ?>
          <a class="nav_menu_a nav_li_font flagvote" href="#" >
            <?=$state2[0]?>
          </a>
          <?php } else { ?>
          <a class="nav_menu_a nav_li_font" href="#" >state
          </a>
          <?php } ?>
        </div>
        <div class="col-md-2 col_padding" style="background:#995219;text-align: center;">
          <?php if( isset( $user->id ) ) { ?>
          <a class="nav_menu_a nav_li_font flagvote" href="#" >
            <?=$userLocation[3]?>
          </a>
          <?php } else { ?>
          <a class="nav_menu_a nav_li_font" href="#" >city
          </a>
          <?php } ?>
        </div>
        <div class="col-md-2 col_padding" style="background:#ca0c5c;text-align: center;">
          <?php if(isset($user->id)) { ?>
          <a class="nav_menu_a nav_li_font flagvote" href="#" >
            <?=$userLocation[2]?>
          </a>
          <?php } else { ?>
          <a class="nav_menu_a nav_li_font" href="#" >Locality</a>
          <?php } ?>
        </div>
        <div class="col-md-2 col_padding" style="background:#bfb119;text-align: center;">
          <a class="nav_menu_a nav_li_font" href="#" >RWA</a>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row depart">
        <div  class="nav " style="height: 51px;">
          <div class="col-md-4 col-xs-4 department_menu">
            <a href="#government" data-toggle="tab">
              <p class="depart_style">Govt. Department</br>
            <span>
              <i class="fas fa-chevron-down"></i>
            </span>
            </p>
          </a>
      </div>
      <div class="col-md-4 col-xs-4 department_menu">
        <a href="#topNews" data-toggle="tab">
          <p class="depart_style">Top News</br>
        <span>
          <i class="fas fa-chevron-down"></i>
        </span>
        </p>
      </a>
    </div>
  <div class="col-md-4 col-xs-4 department_menu">
    <a href="#myDeskboard" data-toggle="tab">
      <p class="depart_style">My Deskboard</br>
    <span>
      <i class="fas fa-chevron-down"></i>
    </span>
    </p>
  </a>
</div>
</div>
<span class="drop_ind">
  <i class="fas fa-chevron-down"></i>
</span>
<section>
  <div id="slide_menu" class="container-fluid tab-content category_tab" style="">
    <div class="row">
      <div class="col-md-5 col-xs-9">
        <div id="custom-search">
          <div class="input-group">
            <input type="text" class=" search_input_category search-query " placeholder="Search on worldvoting.org " />
            <span class="input-group-btn">
              <button class="btn btn-danger" type="button">
                <span class=" glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xs-2" style="margin-top: 9px;">
        <p class="toggle_text">Normal Mode</p>
        <br>
        <div class="onoffswitch onoffbar" style="">
          <input type="checkbox" name="onoffswitch" class="on onoffswitch-checkbox" id="myonoffswitch" checked>
          <label class="onoffswitch-label" for="myonoffswitch">
            <span class="onoffswitch-inner"></span>
            <span class="onoffswitch-switch"></span>
          </label>
        </div>
      </div>
    </div>
    <div class="tab-pane active row" id="government">
      <div class="gov_toggle">
        <div class="col-md-3 col-xs-6" >
          <ul class="submenu_ul " >
            <li>
              <a href="#" class="selected_option">Department of Administrative</a>
            </li>
            <li>
              <a href="#" class="selected_option">Department of Biotechnology</a>
            </li>
            <li>
              <a href="#" class="selected_option">Department of Commerce</a>
            </li>
            <li >
              <a href="#" class="selected_option">Department of Industrial</a>
            </li>
            <li>
              <a href="#" class="selected_option">Separated link</a>
            </li>
          </ul>
        </div>
        <div class="col-md-3 col-xs-6">
          <ul class="submenu_ul">
            <li>
              <a href="#" >Action</a>
            </li>
            <li>
              <a href="#" >Another action</a>
            </li>
            <li>
              <a href="#" >Something else here</a>
            </li>
            <li></li>
            <li>
              <a href="#" >Separated link</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="toggle_gov">
        <div class="col-md-3 col-xs-6" >
          <ul class="submenu_ul">
            <li>
              <a href="#">Law Making</a>
            </li>
            <li>
              <a href="#">Corruption</a>
            </li>
            <li>
              <a href="#">Water</a>
            </li>
            <li >
              <a href="#">Electricity</a>
            </li>
            <li>
              <a href="#">Road</a>
            </li>
          </ul>
        </div>
        <div class="col-md-3 col-xs-6">
          <ul class="submenu_ul">
            <li>
              <a href="#">Action</a>
            </li>
            <li>
              <a href="#">Another action</a>
            </li>
            <li>
              <a href="#">Something else here</a>
            </li>
            <li >
            </li>
            <li>
              <a href="#">Separated link</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="tab-pane row " id="topNews">
      <div>
        <div class="col-md-3 col-xs-12" style="padding-bottom: 10px;">
          <img src="../assets/img/55.jpg" class="size"/><br>
          <button class="btn " style="width: 80%;height: 45px;margin-top: 60px;font-weight: 500;background: linear-gradient(#ebf904,#ff9703);font-size: 24px;">Say Something</button>	&nbsp;&nbsp;
          <img src="../assets/images/icon/s-logo.png" style="margin-top: 60px;"/>
        </div>
        <div class="col-md-3 col-xs-12">
          <div>
            <img src="../assets/img/55.jpg" class="size"/>
          </div>
          <div class=" " style="background:white;padding-right:15px;padding-left:15px;">To begin customizing your site go to Appearance -> Customizer and
            </p>
        </div>
        &nbsp;&nbsp;
        <div style="text-align:center;padding-bottom: 8px;margin-top: -11px;">
          <img src="../assets/images/ndtv.jpg" style="height: 50px;width: 200px;"/>
        </div>
      </div>
      <div class="col-md-3 col-xs-12">
        <div>
          <img src="../assets/img/55.jpg" class="size" />
        </div>
        <div class=""  style="background:white;padding-right:15px;padding-left:15px;">
          <p>To begin customizing your site go to Appearance -> Customizer and</p>
        </div>
        &nbsp;&nbsp;
        <div style="text-align:center;padding-bottom: 8px;margin-top: -11px;">
          <img src="../assets/images/ndtv.jpg" style="height: 50px;width: 200px;"/>
        </div>
      </div>
      <div class="col-md-3 col-xs-12">
        <div>
          <img src="../assets/img/55.jpg" class="size" />
        </div>
        <div class=""  style="background:white;padding-right:15px;padding-left:15px;">
          <p>To begin customizing your site go to Appearance -> Customizer and</p>
        </div>
        &nbsp;&nbsp;
        <div style="text-align:center;padding-bottom: 8px;margin-top: -11px;">
          <img src="../assets/images/ndtv.jpg" style="height: 50px;width: 200px;"/>
        </div>
      </div>
    </div>
  </div>
  <div class="tab-pane row" id="myDeskboard">
    <div>
      <div class="col-md-3 col-xs-6">
        <ul class="submenu_ul">
          <li>
            <a href="#">
              <img src="../assets/images/icon/mail.png" /> &nbsp;&nbsp;Notification
            </a>
          </li>
          <li>
            <a href="#">
              <img src="../assets/images/icon/warning.png" /> &nbsp;&nbsp;Attention Required
            </a>
          </li>
          <li>
            <a href="#">
              <img src="../assets/images/icon/request.png" /> &nbsp;&nbsp;Friends Requests
            </a>
          </li>
          <li>
            <a href="#">
              <img src="../assets/images/icon/followers.png" /> &nbsp;&nbsp;Followers
            </a>
          </li>
          <li>
            <a href="#">
              <img src="../assets/images/icon/following.png" /> &nbsp;&nbsp;Following
            </a>
          </li>
          <li>
            <a href="#">&nbsp;&nbsp;Points</a>
          </li>
          <li>
            <a href="#">&nbsp;&nbsp;Wallet</a>
          </li>
        </ul>
      </div>
      <div class="col-md-3 col-xs-6">
        <ul class="submenu_ul" >
          <li>
            <a href="#">
              <img src="../assets/images/icon/elections.png" /> &nbsp;&nbsp;Votes
            </a>
          </li>
          <li>
            <a href="#">
              <img src="../assets/images/icon/bookmark.png" /> &nbsp;&nbsp;Bookmarks
            </a>
          </li>
          <li>
            <a href="#">
              <img src="../assets/images/icon/request.png" /> &nbsp;&nbsp;Favorite
            </a>
          </li>
          <li>
            <a href="#">
              <img src="../assets/images/icon/settings.png" /> &nbsp;&nbsp;Settings
            </a>
          </li>
          <li>
            <a href="#">
              <img src="../assets/images/icon/idea.png" /> &nbsp;&nbsp;My Creation
            </a>
          </li>
          <li>
            <a href="#">
              <img src="../assets/images/icon/crown.png" /> &nbsp;&nbsp;Successful Polls
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  </div>
</section>
<div style="" class="container-fluid india_color">
  <div class="row" >
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
      <h1 class="show_details_data show_details" style="text-align:center;font-size: 45px;font-weight:700">India</h1>
      <div class="row" style="padding: 5px 45px;">
        <div class="col-md-6 col-xs-6">
          <button class="btn " style="width: 100%;height: 45px;margin-top: 4px;font-weight: 500;background: linear-gradient(#ebf904,#ff9703);font-size: 24px;">Good</button>
        </div>
        <div class="col-md-6 col-xs-6">
          <button class="btn " style="width: 100%;height: 45px;margin-top: 4px;font-weight: 500;background: linear-gradient(#ebf904,#ff9703);font-size: 24px;">Bad</button>
        </div>
      </div>
      <br>
      <h4 style="color:#7e7e82;text-align:center"> You may changes your Vote anytime after 24 hours</h4>
      <br>
    </div>
    <div class="col-md-4"></div>
  </div>
  <div class="row" style="height: 18px;background:green;text-align:center;">
    <span class="">
      <i style="font-size:22px" class="fas fa-chevron-down"></i>
    </span>
  </div>
</div>
<div class="container-fluid">
  <div class="row" style="background:#013775">
    <div class=" col-md-1">
      <span>
        <i style="font-size: 32px;color: white;padding: 10px 30px;" class="fas fa-bars"></i>
      </span>
    </div>
    <?php if(isset($user->id)){ ?>
    <div class="col-md-8 government_option" style="color:white;margin-top: 10px;font-size: 17px;">
      <?=$showAddress?>
    </div>
    <?php } else { ?>
    <div class="col-md-4">
    </div>
    <?php } ?>
    <div class="col-md-3" style="display:flex;float:right">
      <img src="../assets/images/icon/s-logo.png" style="width: 60px;height: 50px;"/>
      <button class="btn " data-toggle="modal" data-target="#enact" style="width: 40%;height: 45px;margin-top: 4px;font-weight: 500;background: linear-gradient(#ebf904,#ff9703);font-size: 24px;">ENACT</button>
      <img src="../assets/images/icon/com-icon.png" style="width: 60px;height: 50px;"/>
    </div>
  </div>
</div>
</div>
</div>
<script>
  $(document).on("click", ".on", function(){
    $(this).addClass('off');
    $(this).removeClass('on');
    $(".gov_toggle").css("display","none");
    $(".toggle_gov").css("display","block");
    $(".toggle_text").html("Easy Mode");
  });
  $(document).on("click", ".off", function(){
    $(this).addClass('on');
    $(this).removeClass('off');
    $(".toggle_gov").css("display","none");
    $(".gov_toggle").css("display","block");
    $(".toggle_text").html("Normal Mode");
  });
  $(document).on("click",".department_menu",function(){
    $(this).addClass('department_menu_drop');
    $(this).removeClass('department_menu');
    $(".department_menu").removeClass('department_menu_drop');
    $(".department_menu_drop").addClass('department_menu');
    $("#slide_menu").slideDown("slow");
  });
  $(document).on("click",".department_menu_drop",function(){
    $(this).removeClass('department_menu_drop');
    $("#slide_menu").slideToggle("slow");
  });
  $(document).on("click",".col_padding",function(){
    var backColor = $(this).css("background");
    $(".department_menu").css("background",backColor);
    $(".category_tab").css("background",backColor);
  });
  /* 	$('body').on('click', function() {
				$(".department_menu").removeClass('department_menu_drop');
			}); */
  // $(document).ready(function(){
    /* 				$(".depart").slideToggle("slow");
  });
		 */
  $(document).on("click",".drop_ind",function(){
    $(".india_color").slideToggle("slow");
  });
  $(document).on("click", ".logout", function(){
    $.ajax({
      url:"../controller/LoginController.php?action=logout",
      method:"post",
      success:function( response ) {
        response = JSON.parse( response );
        if( response.status == 1 ) {
          location.reload(true);
        }
      }
    });
  });
  // code for changing the tab according to click
  $(document).on("click",".col_padding", function(event){
    var details = $(this).html();
    $(".show_details_data").html(details);
    $(".show_details").css("font-size", "45px !important");
  });
  // code for append the selected government-department
  $(document).on("click",".selected_option", function(){
    event.preventDefault();
    var option = $(this).html();
    $(".government_option").html("");
    var location = $("#location").val();
    $(".government_option").append(location + " > "+option);
  });
  $(document).on("click",".logout",function(){
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      document.location.href = "https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://localhost/googleLogin/index.html";
    });
  });

</script>
