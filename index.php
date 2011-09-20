<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<?php

require 'fb-php-sdk/src/facebook.php';

//users reacting on a invitation will be redirected
//to this url
$fb_page = "http://www.facebook.com/mvb";
$fb = new Facebook(array(
  'appId' => '267360273285518',
  'secret' => 'afe67951dbc2e5f9860846f21abb2e69',
));
$isfan = FALSE;
$locale = 'de_DE';
$sr = $fb->getSignedRequest();
if (isset($sr['page']['liked'])) {
  $isfan = $sr['page']['liked'];
} 

if (isset($sr['user']['locale'])) {
  $locale = $sr['user']['locale'];
}
$fbjssdk_url = "http://connect.facebook.net/".$locale."/all.js";

?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="de">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>MVB</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
  </head>
  <body>
    <div id="fb-page">
      
      <div id="fan" >
        <!---->
        <div class="tab_content" id="tab_1">
          <div class="button" id="link_1" onclick="open_link('http://www.mvb-be.ch/onlineberatung/')"></div>
          <div class="button" id="link_2" onclick="open_link('http://www.mvb-be.ch/onlineberatung/')"></div>
        </div>
        <div class="tab_content" style="display: none" id="tab_2">
          <div class="button" id="link_1" onclick="open_link('mailto:klemon@mvb-be.ch')"></div>
          <div class="button" id="link_2" onclick="open_link('mailto:klemon@mvb-be.ch')"></div>
        </div>
        
        
        <div class="tab" id="button_tab_1" tabId="tab_1" onclick="showTab(this);"></div>
        <div class="tab" id="button_tab_2" tabId="tab_2" onclick="showTab(this);"></div>
      </div>
      
      <div id="notfan"></div>
    </div>
    <div id='fb-root'></div>
  </body>
  <script src='<?php echo $fbjssdk_url ?>'></script>
  <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js'></script>
  
  <script type="text/javascript">
    <?php
    //handle apprequests -> just redirect them.
    if (isset($_GET['request_ids'])) {
      echo 'top.location.href="'.$fb_page.'";';
    }
    ?>
    FB.init({
      appId : '<?php echo $fb->getAppID()?>',
      status : true, // check login status
      cookie : true, // enable cookies to allow the server to access the session
      xfbml : false, // parse XFBML
      oauth : true // enable OAuth 2.0
    });
    
    var isFan = '<?php echo $isfan ?>';
    
    if (isFan){
      $('#notfan').fadeOut(500);
    }
    
    function showTab(el) {
      $('.tab_content').hide();
      var tab = $(el);
      $('#' + tab.attr('tabId')).show();
    }
    
    function open_link (url) {
      window.open(url);
    }
    
    function inviteFriends() {
      FB.ui({ method: 'apprequests',
        title: "Freunde einladen",
        message: "Könnte vielleicht auch für dich interessant sein?! 6 Grad – Die Social Media Agentur"
      });
    }
    
    function shareChecklist () {
      FB.ui({ method: 'feed',
            link: 'http://www.facebook.com/6grad',
            picture: "http://www.6grad.ch/facebook/images/6grad-logo_90x90.png",
            name: 'Gratis Facebook-Marketing Checkliste',
            caption: 'www.6grad.ch',
            description: 'Überprüfe die Qualität deiner Facebook-Fanseite mit der 6 Grad-Checkliste!'
      });
    }
    function shareFan () {
      FB.ui({ method: 'feed',
            link: 'http://www.facebook.com/6grad',
            picture: "http://www.6grad.ch/facebook/images/6grad-logo_90x90.png",
            name: '6 Grad – Die Social Media Agentur',
            caption: 'www.6grad.ch',
            description: 'Wir sind mehr "Du" als "Sie", kompetent, pragmatisch und kreativ. Lerne uns kennen!'
      });
    }

  </script>
</html>
