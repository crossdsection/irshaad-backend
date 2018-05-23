<?php
include('header.php');
/*check for email validation*/
if(isset($_GET['email'])) {
?>
<input type="hidden" id="email_url" value="<?=$_GET['email']?>">
<?php
?>
<script>
  $( document ).ready(function() {
    var email1 = $("#email_url").val();
    $('#email').val(email1);
    $('#loginSignup').modal({
      backdrop: 'static',
      keyboard: false
    });
    $('#loginSignup').find(".panel-heading").css("display","none");
    $('#loginSignup').find(".loginsignup-button").css("display","none");
    $('#loginSignup').find(".login-strong").html("Email Verification");
    $('#email').attr('readonly', true);
    $('.login-button').hide();
    $('.login-input').hide();
    $('.verified-button').show();
    $('#loginSignup').find(".loginForm").attr("class","verifyForm");
  });
  function verifiy_account() {
    var email1 = $("#email_url").val();
    $.ajax({
      type: "post",
      url: "../controller/UserController.php?action=verifyEmail",
      data: {verify_email: email1},
      success: function (response) {
        response = JSON.parse(response);
        if(response.status == 1) {
          swal(response.message);
          setTimeout(function(){
            window.location.href= "index.php";
          }, 3000);
        } else {
          swal(response.message)
        }
      }
    });
  }
</script>
<?php
}
?>
<style>
  .subadminstyle {
    font-size: 16px;
    font-weight: bold;
    margin-left: 100px;
  }
  .subadminstyle:hover {
    color: #23527c;
  }
</style>
<section>
  <div class="container">
    <div class="row" >
      <div class="col-md-4 col-xs-4 divide_border">
        <h3 class="divide_menu">Courts
        </h3>
      </div>
      <div class="col-md-4 col-xs-4  divide_border">
        <h3 class="divide_menu">Discussion
        </h3>
      </div>
      <div class="col-md-4 col-xs-4  divide_border">
        <h3 class="divide_menu">News
        </h3>
      </div>
    </div>
  </div>
  <div class="container" style="padding-top:20px">
    <div class="row court_scroll">
      <div class="col-md-4" style="margin-left: -20px;" >
        <ul style="list-style-type:none">
          <li>
            <div class="row polls_section">
              <div class="row" style="margin-bottom: 4px;">
                <div class="col-md-2 col-xs-3 col-sm-3">
                  <a href="#"  data-toggle="modal" data-target="#profile">
                    <img src="../assets/img/12.jpg" class="pro_image" />
                  </a>
                </div>
                <div class="col-md-10">
                  <p class="user_head">Name
                    <br>Place
                  </p>
                  <p style="float:right;margin-top: 10px;">Date
                  </p>
                </div>
              </div>
              <div class="row" style="padding-right:15px;padding-left:15px;">
                <div class="" style="">
                  <img src="../assets/img/55.jpg" class="news_img"/>
                </div>
              </div>
              <div class="row " style="background:white;padding-right:15px;padding-left:15px;">
                <h4 class="text-info" style="text-transform:capitalize;width:100%;word-wrap: break-word;font-weight:600">Pictures, abstract symbols, materials, and colors are among
                </h4>
              </div>
              <div class="row">
                <a>
                  <span style="float:right;margin-right: 7px;">
                    <i style="font-size: 17px;" class="far fa-question-circle">
                    </i>
                  </span>
                </a>
              </div>
              <div class="row">
                <div class="col-md-12" style="bottom: 4px;padding: 3px;">
                  <div class="col-md-6 col-xs-6" style="padding-right: 5px;padding-left: 5px;">
                    <button class="btn" style=" width:100%;background: linear-gradient(#ffe45c,#ffae26);border: 1px solid #ffaa22;">
                      <i style="color:green;font-size: 17px;"  class="fas fa-check">
                      </i>
                    </button>
                  </div>
                  <div class="col-md-6 col-xs-6" style="padding-right: 5px; padding-left: 5px;">
                    <button class="btn " style=" width:100%;background: linear-gradient(#ffe45c,#ffae26);border: 1px solid #ffaa22;">
                      <i style="color:red;    font-size: 17px;" class="fas fa-times">
                      </i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="row" style="color:grey">
                <a class= "col-md-2 col-xs-2" style="color:grey" >
                  <i class="fas fa-share-alt">
                  </i>
                </a>
                <a class="col-md-2 col-xs-2" style="color:grey">
                  <i class="far fa-star">
                  </i>
                </a>
                <a class="col-md-2 col-xs-2" style="color:grey" data-toggle="modal" data-target="#myModal">
                  <i class="far fa-comment">
                  </i>
                </a
                  <a class="col-md-2 col-xs-2" style="color:grey">
                  <i class="fal fa-arrow-alt-up">
                  </i>
                </a>
                <a class="col-md-2 col-xs-2" style="color:grey">
                  <i class="far fa-flag">
                  </i>
                </a>
                <a class="col-md-2 col-xs-2" style="color:grey">
                  <i class="fas fa-signal icon_flip" >
                  </i>
                </a>
              </div>
            </div>
          </li>
          <br>
          <br>
          <li>
            <div class="row polls_section">
              <div class="row" style="margin-bottom: 4px;">
                <div class="col-md-2 col-xs-3 col-sm-3">
                  <a href="#"  data-toggle="modal" data-target="#profile">
                    <img src="../assets/img/12.jpg" class="pro_image" />
                  </a>
                </div>
                <div class="col-md-10">
                  <p class="user_head">Name
                    <br>Place
                  </p>
                  <p style="float:right;margin-top: 10px;">Date
                  </p>
                </div>
              </div>
              <div class="row" style="padding-right:15px;padding-left:15px;">
                <div class="" style="">
                  <img src="../assets/img/55.jpg" class="news_img"/>
                </div>
              </div>
              <div class="row" style=";background:white;padding-right:15px;padding-left:15px;">
                <h4 class="text-info" style="text-transform:capitalize;width:100%;word-wrap: break-word;font-weight:600">Pictures, abstract symbols, materials, and colors are among
                </h4>
              </div>
              <div class="row">
                <a>
                  <span style="float:right;margin-right: 7px;">
                    <i style="font-size: 17px;" class="far fa-question-circle">
                    </i>
                  </span>
                </a>
              </div>
              <div class="row">
                <a>
                  <span style="float:right;margin-right: 7px;margin-top: -20px;">
                    <i style="font-size: 17px;" class="far fa-question-circle">
                    </i>
                  </span>
                </a>
                <div class="col-md-12" style="bottom: 4px;padding: 3px;">
                  <div class="col-md-3 col-xs-3" style="padding-right: 5px;padding-left: 5px;">
                    <button class="btn select_box" style=" " >1
                    </button>
                  </div>
                  <div class="col-md-3 col-xs-3" style="padding-right: 5px; padding-left: 5px;">
                    <button class="btn select_box" style="">2
                    </button>
                  </div>
                  <div class="col-md-3 col-xs-3" style="padding-right: 5px;padding-left: 5px;">
                    <button class="btn select_box" style="" >3
                    </button>
                  </div>
                  <div class="col-md-3 col-xs-3" style="padding-right: 5px; padding-left: 5px;">
                    <button class="btn select_box" style="">4
                    </button>
                  </div>
                </div>
              </div>
              <div class="row" style="color:grey">
                <a class= "col-md-2 col-xs-2" style="color:grey" >
                  <i class="fas fa-share-alt">
                  </i>
                </a>
                <a class="col-md-2 col-xs-2" style="color:grey">
                  <i class="far fa-star">
                  </i>
                </a>
                <a class="col-md-2 col-xs-2" style="color:grey"  data-toggle="modal" data-target="#myModal">
                  <i class="far fa-comment">
                  </i>
                </a>
                <a class="col-md-2 col-xs-2" style="color:grey">
                  <i class="fal fa-arrow-alt-up">
                  </i>
                </a>
                <a class="col-md-2 col-xs-2" style="color:grey">
                  <i class="far fa-flag">
                  </i>
                </a>
                <a class="col-md-2 col-xs-2" style="color:grey">
                  <i class="fas fa-signal icon_flip" >
                  </i>
                </a>
              </div>
            </div>
          </li>
          <br>
          <br>
        </ul>
      </div>
      <!------------------discussion-------------------------------------------------------->
      <div class="col-md-4" >
        <ul style="list-style-type:none">
          <li>
            <div class="row polls_section" style="">
              <div class="row" style="margin-bottom: 4px;">
                <div class="col-md-2 col-xs-3 col-sm-3">
                  <a href="#"  data-toggle="modal" data-target="#profile">
                    <img src="../assets/img/12.jpg" class="pro_image" />
                  </a>
                </div>
                <div class="col-md-10">
                  <p class="user_head">Name
                    <br>Place
                  </p>
                  <p style="float:right;margin-top: 10px;">Date
                  </p>
                </div>
              </div>
              <div class="row " style="padding-right:15px;padding-left:15px;">
                <div class="" style="">
                  <img src="../assets/img/55.jpg" class="news_img"/>
                </div>
              </div>
              <div class="row " style=";background:white;padding-right:15px;padding-left:15px;">
                <h4 class="text-info" style="text-transform:capitalize;width:100%;word-wrap: break-word;font-weight:600">Pictures, abstract symbols, materials, and colors are among
                </h4>
              </div>
              <div class="row ">
                <a>
                  <span style="float:right;margin-right: 7px;">
                    <i style="font-size: 17px;" class="far fa-question-circle">
                    </i>
                  </span>
                </a>
              </div>
              <div class="row " style="color:grey">
                <a class= "col-md-2 col-xs-2" style="color:grey" >
                  <i class="fas fa-share-alt">
                  </i>
                </a>
                <a class="col-md-2 col-xs-2" style="color:grey">
                  <i class="far fa-star">
                  </i>
                </a>
                <a class="col-md-2 col-xs-2 comment" style="color:grey"  data-toggle="modal" data-target="#myModal">
                  <i class="far fa-comment">
                  </i>
                </a>
                <a class="col-md-2 col-xs-2 " style="color:grey">
                  <i class="fal fa-arrow-alt-up">
                  </i>
                </a>
                <a class="col-md-2 col-xs-2" style="color:grey">
                  <i class="far fa-flag">
                  </i>
                </a>
                <a class="col-md-2 col-xs-2" style="color:grey">
                  <i class="fas fa-signal icon_flip" >
                  </i>
                </a>
              </div>
            </div>
          </li>
        </ul>
      </div>
      <!--------------------News-------------------------------------------------->
      <div class="col-md-4 news_padding" style="" >
        <ul style="list-style-type:none">
          <li>
            <div class="row polls_section" >
              <div class="row" style="margin-bottom: 4px;">
                <div class="col-md-2 col-xs-3 col-sm-3">
                  <a href="#"  data-toggle="modal" data-target="#profile">
                    <img src="../assets/img/12.jpg" class="pro_image" />
                  </a>
                </div>
                <div class="col-md-10">
                  <p class="user_head text-info">Name
                    <br>Place
                  </p>
                  <p style="float:right;margin-top: 10px;">Date
                  </p>
                </div>
              </div>
              <div class="row " style="padding-right:15px;padding-left:15px;">
                <div class="" style="">
                  <img src="../assets/img/55.jpg" class="news_img"/>
                </div>
              </div>
              <div class="row " style=";background:white;padding-right:15px;padding-left:15px;">
                <h4 class="text-info" style="text-transform:capitalize;width:100%;word-wrap: break-word;font-weight:600">Pictures, abstract symbols, materials, and colors are among
                </h4>
              </div>
              <div class="row " style="padding-left:30px;padding-right:15px;margin-top: -8px;height:48px">
                <p style="text-transform:capitalize;width:100%;line-height: 1.4;word-wrap: break-word;"> vjhgvjhgjhggujgkugugu
                </p>
              </div>
              <div>
                <div class="row ">
                  <a>
                    <span style="float:left;margin-left: 30px;">Read More
                    </span>
                  </a>
                  <a>
                    <span style="float:right;margin-right: 7px;">
                      <i style="font-size: 17px;" class="far fa-question-circle">
                      </i>
                    </span>
                  </a>
                </div>
                <div class="row " style="color:grey">
                  <a class= "col-md-2 col-xs-2" style="color:grey" >
                    <i class="fas fa-share-alt">
                    </i>
                  </a>
                  <a class="col-md-2 col-xs-2" style="color:grey">
                    <i class="far fa-star">
                    </i>
                  </a>
                  <a class="col-md-2 col-xs-2 comment" style="color:grey"  data-toggle="modal" data-target="#myModal">
                    <i class="far fa-comment">
                    </i>
                  </a>
                  <a class="col-md-2 col-xs-2" >
                  </a>
                  <a class="col-md-2 col-xs-2" >
                    <img src="../assets/images/icon/up.png"  style="width: 15px;margin-top: -3px;"/>
                  </a>
                  <a class="col-md-2 col-xs-2" >
                    <img src="../assets/images/icon/eye.png"  style="width: 19px;margin-top: -3px;"/>
                  </a>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>
<!--  Modal Comment------------------------------------------------------------->
<div class="modal fade" id="profile">
  <div class="modal-dialog dialog_width">
    <div class="modal-content">
      <!-- Modal Header -->
      <!-- Modal body -->
      <div class="modal-body" style="padding:0px">
        <div class="container">
          <div class="row">
            <button style="float: left;position: absolute;margin: 10px;z-index: 22;" type="button" class="close" data-dismiss="modal">&times;
            </button>
            <div class="col-md-3 " style="background:yellow">
              <br>
              <br>
              <div class="">
                <img src="../assets/img/12.jpg" style="width: 65%; border-radius: 50%; margin-left: 43px;" class="img-responsive" />
              </div>
              <div class="row">
                <a href="#" >
                  <h4 class="txt_center"> Name
                  </h4>
                </a>
                <p  class="txt_center">POST
                </p>
                <p style="margin: 0 26px 10px;"> 21, north gandhi colony muzaffarnagar
                </p>
              </div>
              <div class="row " style="padding: 14px;">
                <p>Addredss fds fs s dsdfsfsfds dsfsfs s dfsfdsfs
                </p>
              </div>
              <div class="row" style="height:50px" >
                <div class="col-md-4 col-xs-4" style="border-top:2px solid #c2c508;border-bottom:2px solid #c2c508">
                  <p class="txt_center">
                    <span style="font-weight:600">1000
                    </span>
                    Courts
                  </p>
                </div>
                <div class="col-md-4 col-xs-4" style="border:2px solid #c2c508">
                  <p class="txt_center">
                    <span style="font-weight:600">1000
                    </span>
                    Discussion
                  </p>
                </div>
                <div class="col-md-4 col-xs-4"style="border-top:2px solid #c2c508;border-bottom:2px solid #c2c508">
                  <p class="txt_center">
                    <span style="font-weight:600">1000
                    </span>
                    News
                  </p>
                </div>
              </div>
              <div class="row " style="">
                <br>
                <span class="col-md-offset-2 col-xs-offset-2" style="font-weight:600">User Rating
                </span>
                <br>
                <br>
              </div>
              <div class="row txt_center" style="">
                <button class=" btn btn-info" >Follow
                </button>
                <br>
                <br>
              </div>
            </div>
            <div class="col-md-8 profile_module" style="">
              <div class="col-md-6" style="padding-right:0px;">
                <ul  style="list-style-type:none">
                  <li>
                    <div class="row polls_section" style="   ">
                      <div class="row" style="margin-bottom: 4px;">
                        <div class="col-md-2 col-xs-3 col-sm-3">
                          <img src="../assets/img/12.jpg" class="pro_image" />
                        </div>
                        <div class="col-md-9">
                          <p class="user_head">Name
                            <br>Place
                          </p>
                          <p style="float:right;margin-top: 10px;">Date
                          </p>
                        </div>
                      </div>
                      <div class="row " style="padding-right:15px;padding-left:15px;">
                        <div class="" style="">
                          <img src="../assets/img/55.jpg" class="profile_news_img"/>
                        </div>
                      </div>
                      <div class="row " style=";background:white;padding-right:15px;padding-left:15px;">
                        <h4 class="text-info" style="text-transform:capitalize;width:100%;word-wrap: break-word;font-weight:600">Pictures, abstract symbols, materials, and colors are among
                        </h4>
                      </div>
                      <div class="row ">
                        <a>
                          <span style="float:right;margin-right: 7px;">
                            <i style="font-size: 17px;" class="far fa-question-circle">
                            </i>
                          </span>
                        </a>
                        <div class="col-md-12" style="bottom: 4px;padding: 3px;">
                          <div class="col-md-6" style="padding-right: 5px;padding-left: 5px;">
                            <button class="btn" style="width:100%;background: linear-gradient(#ffe45c,#ffae26);border: 1px solid #ffaa22; " >
                              <i style="color:green;font-size: 17px;"  class="fas fa-check">
                              </i>
                            </button>
                          </div>
                          <div class="col-md-6" style="padding-right: 5px; padding-left: 5px;">
                            <button class="btn " style=" width:100%;background: linear-gradient(#ffe45c,#ffae26);border: 1px solid #ffaa22;">
                              <i style="color:red;    font-size: 17px;" class="fas fa-times">
                              </i>
                            </button>
                          </div>
                        </div>
                      </div>
                      <div class="row " style="color:grey">
                        <a class= "col-md-2 col-xs-2" style="color:grey" >
                          <i class="fas fa-share-alt">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey">
                          <i class="far fa-star">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey" data-toggle="modal" data-target="#myModal">
                          <i class="far fa-comment">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey">
                          <i class="fal fa-arrow-alt-up">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey">
                          <i class="far fa-flag">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey">
                          <i class="fas fa-signal icon_flip" >
                          </i>
                        </a>
                      </div>
                    </div>
                  </li>
                  <br>
                  <br>
                  <li>
                    <div class="row polls_section" style="   ">
                      <div class="row" style="margin-bottom: 4px;">
                        <div class="col-md-2 col-xs-3 col-sm-3">
                          <img src="../assets/img/12.jpg" class="pro_image" />
                        </div>
                        <div class="col-md-9" >
                          <p class="user_head">Name
                            <br>Place
                          </p>
                          <p style="float:right;margin-top: 10px;">Date
                          </p>
                        </div>
                      </div>
                      <div class="row " style="padding-right:15px;padding-left:15px;">
                        <div class="" style="">
                          <img src="../assets/img/55.jpg" class="profile_news_img"/>
                        </div>
                      </div>
                      <div class="row " style=";background:white;padding-right:15px;padding-left:15px;">
                        <h4 class="text-info" style="text-transform:capitalize;width:100%;word-wrap: break-word;font-weight:600">Pictures, abstract symbols, materials, and colors are among
                        </h4>
                      </div>
                      <div class="row ">
                        <a>
                          <span style="float:right;margin-right: 7px;">
                            <i style="font-size: 17px;" class="far fa-question-circle">
                            </i>
                          </span>
                        </a>
                        <div class="col-md-12" style="bottom: 4px;padding: 3px;">
                          <div class="col-md-6" style="padding-right: 5px;padding-left: 5px;">
                            <button class="btn" style=" width:100%;background: linear-gradient(#ffe45c,#ffae26); border: 1px solid #ffaa22; " >
                              <i style="color:green;font-size: 17px;"  class="fas fa-check">
                              </i>
                            </button>
                          </div>
                          <div class="col-md-6" style="padding-right: 5px; padding-left: 5px;">
                            <button class="btn " style=" width:100%;background: linear-gradient(#ffe45c,#ffae26); border: 1px solid #ffaa22;">
                              <i style="color:red;    font-size: 17px;" class="fas fa-times">
                              </i>
                            </button>
                          </div>
                        </div>
                      </div>
                      <div class="row " style="color:grey">
                        <a class= "col-md-2 col-xs-2" style="color:grey" >
                          <i class="fas fa-share-alt">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey">
                          <i class="far fa-star">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey" data-toggle="modal" data-target="#myModal">
                          <i class="far fa-comment">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey">
                          <i class="fal fa-arrow-alt-up">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey">
                          <i class="far fa-flag">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey">
                          <i class="fas fa-signal icon_flip" >
                          </i>
                        </a>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="col-md-6" style="    padding: 0px 0px 0px 14px;	">
                <ul  style="list-style-type:none">
                  <li>
                    <div class="row polls_section" style="   ">
                      <div class="row" style="margin-bottom: 4px;">
                        <div class="col-md-2 col-xs-3 col-sm-3">
                          <img src="../assets/img/12.jpg" class="pro_image" />
                        </div>
                        <div class="col-md-9">
                          <p class="user_head">Name
                            <br>Place
                          </p>
                          <p style="float:right;margin-top: 10px;">Date
                          </p>
                        </div>
                      </div>
                      <div class="row " style="padding-right:15px;padding-left:15px;">
                        <div class="" style="">
                          <img src="../assets/img/55.jpg" class="profile_news_img"/>
                        </div>
                      </div>
                      <div class="row " style=";background:white;padding-right:15px;padding-left:15px;">
                        <h4 class="text-info" style="text-transform:capitalize;width:100%;word-wrap: break-word;font-weight:600">Pictures, abstract symbols, materials, and colors are among
                        </h4>
                      </div>
                      <div class="row ">
                        <a>
                          <span style="float:right;margin-right: 7px;">
                            <i style="font-size: 17px;" class="far fa-question-circle">
                            </i>
                          </span>
                        </a>
                        <div class="col-md-12" style="bottom: 4px;padding: 3px;">
                          <div class="col-md-6" style="padding-right: 5px;padding-left: 5px;">
                            <button class="btn" style=" width:100%;background: linear-gradient(#ffe45c,#ffae26);border: 1px solid #ffaa22; " >
                              <i style="color:green;font-size: 17px;"  class="fas fa-check">
                              </i>
                            </button>
                          </div>
                          <div class="col-md-6" style="padding-right: 5px; padding-left: 5px;">
                            <button class="btn " style=" width:100%;background: linear-gradient(#ffe45c,#ffae26); border: 1px solid #ffaa22;">
                              <i style="color:red;    font-size: 17px;" class="fas fa-times">
                              </i>
                            </button>
                          </div>
                        </div>
                      </div>
                      <div class="row " style="color:grey">
                        <a class= "col-md-2 col-xs-2" style="color:grey" >
                          <i class="fas fa-share-alt">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey">
                          <i class="far fa-star">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey" data-toggle="modal" data-target="#myModal">
                          <i class="far fa-comment">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey">
                          <i class="fal fa-arrow-alt-up">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey">
                          <i class="far fa-flag">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey">
                          <i class="fas fa-signal icon_flip" >
                          </i>
                        </a>
                      </div>
                    </div>
                  </li>
                  <br>
                  <br>
                  <li>
                    <div class="row polls_section" style="   ">
                      <div class="row" style="margin-bottom: 4px;">
                        <div class="col-md-2 col-xs-3 col-sm-3">
                          <img src="../assets/img/12.jpg" class="pro_image" />
                        </div>
                        <div class="col-md-9">
                          <p class="user_head">Name
                            <br>Place
                          </p>
                          <p style="float:right;margin-top: 10px;">Date
                          </p>
                        </div>
                      </div>
                      <div class="row " style="padding-right:15px;padding-left:15px;">
                        <div class="" style="">
                          <img src="../assets/img/55.jpg" class="profile_news_img"/>
                        </div>
                      </div>
                      <div class="row " style=";background:white;padding-right:15px;padding-left:15px;">
                        <h4 class="text-info" style="text-transform:capitalize;width:100%;word-wrap: break-word;font-weight:600">Pictures, abstract symbols, materials, and colors are among
                        </h4>
                      </div>
                      <div class="row ">
                        <a>
                          <span style="float:right;margin-right: 7px;">
                            <i style="font-size: 17px;" class="far fa-question-circle">
                            </i>
                          </span>
                        </a>
                        <div class="col-md-12" style="bottom: 4px;padding: 3px;">
                          <div class="col-md-6" style="padding-right: 5px;padding-left: 5px;">
                            <button class="btn" style=" width:100%;background: linear-gradient(#ffe45c,#ffae26); border: 1px solid #ffaa22; " >
                              <i style="color:green;font-size: 17px;"  class="fas fa-check">
                              </i>
                            </button>
                          </div>
                          <div class="col-md-6" style="padding-right: 5px; padding-left: 5px;">
                            <button class="btn " style=" width:100%;background: linear-gradient(#ffe45c,#ffae26); border: 1px solid #ffaa22;">
                              <i style="color:red;    font-size: 17px;" class="fas fa-times">
                              </i>
                            </button>
                          </div>
                        </div>
                      </div>
                      <div class="row " style="color:grey">
                        <a class= "col-md-2 col-xs-2" style="color:grey" >
                          <i class="fas fa-share-alt">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey">
                          <i class="far fa-star">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey" data-toggle="modal" data-target="#myModal">
                          <i class="far fa-comment">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey">
                          <i class="fal fa-arrow-alt-up">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey">
                          <i class="far fa-flag">
                          </i>
                        </a>
                        <a class="col-md-2 col-xs-2" style="color:grey">
                          <i class="fas fa-signal icon_flip" >
                          </i>
                        </a>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal footer -->
    </div>
  </div>
</div>
<div id="enact" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;
        </button>
        <h3 class="text-center modal-title" style="font-weight: 600;">ENACT
        </h3>
      </div>
      <div class="modal-body" style="padding: 0px 15px;">
        <div class="row">
          <div class="col-md-12">
            <div class="row" style="background: #a8a7a9;">
              <textarea class="form-control" placeholder="Let's change the World" style="height:180px;padding: 26px;font-size: 18px;">
              </textarea>
              <div class="col-md-4 col-xs-4" style="padding-right: 0px;padding-left: 0px;">
                <button class="btn" style="background: #a8a7a9;border-radius:0px;width:100%;border: 1px solid #ccc4d4;">Polls
                </button>
              </div>
              <div class="col-md-4 col-xs-4" style="padding-right: 0px;padding-left: 0px;">
                <button class="btn"style="border-radius:0px;width:100%;background: #a8a7a9;border: 1px solid #ccc4d4;">Discussion
                </button>
              </div>
              <div class="col-md-4 col-xs-4" style="padding-right: 0px;padding-left: 0px;">
                <button class="btn"style="border-radius:0px;width:100%;background: #a8a7a9;border: 1px solid #ccc4d4;">News
                </button>
              </div>
            </div>
            <div class="row" style="background:#cac1c1;padding:7px">
              <span style="margin-left: 10px;">
                <img src="../assets/images/icon/camera.png"  />
              </span>
              <span>
                <img src="../assets/images/icon/video.png" />
              </span>
              <span>
                <img src="../assets/images/icon/notes.png" />
              </span>
              <span>
                <img src="../assets/images/icon/loc.png" />
              </span>
            </div>
            <div class="row">
              <button class="btn" style="width: 100%;height: 45px;font-weight: 500;background: linear-gradient(#ebf904,#ff9703);font-size: 24px;">ENACT</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!----------------------login modal------------------------------------------------------>
<div id="loginSignup" class="modal fade loginSignup1" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <div class="panel with-nav-tabs panel-info">
                <div class="panel-heading">
                  <ul class="nav nav-tabs">
                    <li class="active">
                      <a href="#login" data-toggle="tab"> Login
                      </a>
                    </li>
                    <li>
                      <a href="#signup" data-toggle="tab"> Signup
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="panel-body">
                  <div class="tab-content">
                    <div id="login" class="tab-pane fade in active register">
                      <div class="container-fluid">
                        <div class="row">
                          <h2 class="text-center" style="color: #5cb85c;">
                            <strong class="login-strong"> Login
                            </strong>
                          </h2>
                          <hr />
                          <form action="javascript:void(0)" class="loginForm" >
                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                  <div class="input-group">
                                    <div class="input-group-addon">
                                      <span class="glyphicon glyphicon-user">
                                      </span>
                                    </div>
                                    <input type="email" id="email" placeholder="Enter Email" name="email" class="form-control">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                  <div class="input-group  login-input">
                                    <div class="input-group-addon">
                                      <span class="glyphicon glyphicon-lock">
                                      </span>
                                    </div>
                                    <input type="password" placeholder="Enter Password" name="password" class="form-control">
                                    <input type="hidden" name="login-user-latitude" id="login-user-latitude">
                                    <input type="hidden" name="login-user-longitude" id="login-user-longitude">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                              <div class="col-xs-6 col-sm-6 col-md-6">
                              </div>
                              <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                  <!--a href="#forgot" data-toggle="modal"> Forgot Password? </a-->
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6 col-md-6 col-lg-6">
                              </div>
                              <div class="col-sm-6 col-md-6 col-lg-6">
                                <a href="../admin/index.php" class="subadminstyle">Login as subadmin
                                </a>
                              </div>
                            </div>
                            <hr/>
                            <div class="row">
                              <div  class="col-xs-12 col-sm-12 col-md-12">
                                <button type="submit" id="gSignInclass" class="btn btn-success btn-block btn-lg login-button"> Login
                                </button>
                                <button type="submit" class="btn btn-success btn-block btn-lg verified-button" onclick="verifiy_account();">Verified Account
                                </button>
                              </div>
                            </div>
                          </form>
                          <div class="row" style="text-align:center">
                            <!--button class="loginBtn loginBtn--facebook">
                              Login with Facebook
                              </button-->
                            <button data-onsuccess="onSignIn" class="g-signin2  " style="padding:0px">
                              Login with Google
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <style>
                      .abcRioButtonLightBlue {
                        background-color: #fff;
                        color: #757575;
                        height: 31px !important;
                        width: 170px !important;
                      }
                    </style>
                    <div id="signup" class="tab-pane fade">
                      <div class="container-fluid">
                        <div class="row">
                          <h2 class="text-center" style="color: #f0ad4e;">
                            <Strong> Register
                            </Strong>
                          </h2>
                          <hr />
                          <form action="javascript:void(0)" class="signupForm">
                            <div class="row">
                              <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                  <div class="input-group">
                                    <div class="input-group-addon iga1">
                                      <span class="glyphicon glyphicon-user">
                                      </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="First Name" name="firstName">
                                  </div>
                                </div>
                              </div>
                              <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                  <div class="input-group">
                                    <div class="input-group-addon iga1">
                                      <span class="glyphicon glyphicon-user">
                                      </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Last Name" name="lastName">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                  <div class="input-group">
                                    <div class="input-group-addon iga1">
                                      <span class="glyphicon glyphicon-envelope">
                                      </span>
                                    </div>
                                    <input type="email" class="form-control" placeholder="Enter E-Mail" name="email">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                  <div class="input-group">
                                    <div class="input-group-addon iga1">
                                      <span class="glyphicon glyphicon-lock">
                                      </span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Enter Password" name="password">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                  <div class="input-group">
                                    <div class="input-group-addon iga1">
                                      <span class="glyphicon glyphicon-lock">
                                      </span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Enter Confirm Password" name="confirm_password">
                                    <input type="hidden" name="signup-user-latitude" id="signup-user-latitude">
                                    <input type="hidden" name="signup-user-longitude" id="signup-user-longitude">
                                    <!--input type="hidden" name="user_address" id="user_address">
                                    <input type="hidden" name="user_address_latitude" id="user_address_latitude">
                                    <input type="hidden" name="user_address_longitude" id="user_address_longitude"-->
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6 col-md-6 col-lg-6">
                              </div>
                              <div class="col-sm-6 col-md-6 col-lg-6">
                                <!--a href="" class="subadminstyle" style=" margin-left: 90px;">Signup as subadmin</a-->
                                <select class="form-control signup-as-subadmin">
                                  <option value="00">Signup as subadmin</option>
                                  <option value="0">World voting subadmin</option>
                                  <option value="1">Government department subadmin</option>
                                  <option value="2">Media subadmin</option>
                                  <option value="3">RWA subadmin</option>
                                </select>
                              </div>
                            </div>
                            <hr>
                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                  <button type="submit" id="submit_block" class="btn btn-lg btn-block btn-warning"> Register</button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="forgot">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss='modal' aria-hidden="true">
                  <span class="glyphicon glyphicon-remove"></span>
                </button>
                <h4 class="modal-title" style="font-size: 32px; padding: 12px;"> Recover Your Password</h4>
              </div>
              <div class="modal-body">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-addon iga2">
                            <span class="glyphicon glyphicon-envelope"></span>
                          </div>
                          <input type="email" class="form-control" placeholder="Enter Your E-Mail ID" name="email">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-addon iga2">
                            <span class="glyphicon glyphicon-lock"></span>
                          </div>
                          <input type="password" class="form-control" placeholder="Enter Your New Password" name="newpwd">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <div class="form-group">
                  <button type="submit" class="btn btn-lg btn-info"> Save
                    <span class="glyphicon glyphicon-saved"></span>
                  </button>
                  <button type="button" data-dismiss="modal" class="btn btn-lg btn-default"> Cancel
                    <span class="glyphicon glyphicon-remove"></span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer loginsignup-button">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on("submit", ".signupForm", function (event){
    event.preventDefault();
    var firstName = $(this).find('input[name="firstName"]').val();
    var lastName = $(this).find('input[name="lastName"]').val();
    var email = $(this).find('input[name="email"]').val();
    var password = $(this).find('input[name="password"]').val();
    var confirm_password = $(this).find('input[name="confirm_password"]').val();
    if(firstName.length == 0) {
      swal("FirstName should be Mandatory");
      return;
    }
    if(lastName.length == 0) {
      swal("LastName should be Mandatory");
      return;
    }
    if(email.length == 0) {
      swal("Email should be Mandatory");
      return;
    }
    if(password.length == 0) {
      swal("Password should be Mandatory");
      return;
    }
    if(confirm_password.length == 0) {
      swal("Confirm Password should be Mandatory");
      return;
    }
    if(password != confirm_password) {
      swal("Password and Confirm Password Doesnot Match");
      return;
    }
    var formData = new FormData($(this) [0]);
    $("#submit_block").html('Please Wait......').prop('disabled', true);
    $.ajax({
      url: "../controller/UserController.php?action=userSignup",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function ( response ) {
        // $("#submit").prop('disabled', false);
        response = JSON.parse(response);
        if (response.status == 1) {
          swal(response.message);
          setTimeout(function(){
            window.location.href = "index.php";
          } , 3000);
        } else if (response.status == 0) {
          swal(response.message);
        }
        $("#submit_block").html('Register').prop('disabled', false);
      }
    });
  });
  $(document).on('submit', '.loginForm', function (event) {
    event.preventDefault();
    var formData = new FormData($(this) [0]);
    $.ajax({
      url: "../controller/LoginController.php?action=userLogin",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        response = JSON.parse(response);
        if (response.status == 1) {
          window.location.href = 'index.php';
        } else if(response.status == 0) {
          swal(response.message);
        }
      }
    });
  });
  $(document).ready(function (){
    if(navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showLocation);
    } else {
      $("#location").html("Geolocation is not supported by this browser.");
    }
  });
  function showLocation(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    $("#login-user-latitude").val(latitude);
    $("#login-user-longitude").val(longitude);
    $("#signup-user-latitude").val(latitude);
    $("#signup-user-longitude").val(longitude);
/* $.ajax({
type:'POST',
url:'../controller/GeolocationController.php?action=getLocation',
data:{latitude:latitude,longitude:longitude},
success:function(response)
{
response = JSON.parse(response);
if(response.status == 1)
{
var data = response.data;
data = data.split('`');
$("#user_address").val(data[0]);
$("#user_address_latitude").val(data[1]);
$("#user_address_longitude").val(data[2]);
}
else
{
console.log(response.message);
$("#user_address").val('');
$("#user_address_latitude").val('');
$("#user_address_longitude").val('');
}
}
});*/
  }
</script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script>
  function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    /* console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
console.log('Name: ' + profile.getName());
console.log('Image URL: ' + profile.getImageUrl());
console.log('Email: ' + profile.getEmail()); */ // This is null if the 'email' scope is not present.
    var firstName = profile.getName();
    var email = profile.getEmail();
    var latitude1 = $("#login-user-latitude").val();
    var longitude1 = $("#login-user-longitude").val();
    $.ajax({
      url:"../controller/UserController.php?action=gmailLogin",
      type: "POST",
      data: { firstName: firstName, email: email, latitude: latitude1, longitude: longitude1 },
      success:function( response ) {
        response = JSON.parse(response);
        if ( response.status == 1 ) {
          setTimeout(function(){
            window.location.href= "index.php";
          } , 800000);
          //window.location.href = 'index.php';
        } else if(response.status == 0) {
          swal(response.message);
        }
      }
    });
  }
  $(document).on("click", ".signup-as-subadmin", function(){
    var signupdata = $(this).val();
    if(signupdata == '00') {
      return;
    } else {
      var signupdataaddress = '';
      if(signupdata == '0') {
        signupdataaddress = $("option:selected", this).text();
      } else if(signupdata == '1') {
        signupdataaddress = $("option:selected", this).text();
      } else if(signupdata == '2') {
        signupdataaddress = $("option:selected", this).text();
      } else {
        signupdataaddress = $("option:selected", this).text();
      }
      $(this).prop('selectedIndex',0);
      window.location.href= "../admin/register.php?data="+signupdataaddress;
    }
  });
</script>
<script>
  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }
</script>
</body>
</html>
