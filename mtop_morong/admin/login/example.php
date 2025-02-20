<?php
if ($this->session->userdata('userid')) {
  header("location:/bpl/main/example");
  //session_destroy();
}; ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>jQuery loadingModal Plugin Demos</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/bpl/source/login/css/jquery.loadingModal.css">

    <style>
    body { font-family:'Open Sans';}
        #wrapper {
            text-align: center;
            padding: 30px;
        }
    </style>
</head>
<body>

<div id="wrapper">
<h1>jQuery loadingModal Plugin Demos</h1>
<div class="jquery-script-ads" style="margin:50px auto" align="center"><script type="text/javascript">
google_ad_client = "ca-pub-2783044520727903";
/* jQuery_demo */
google_ad_slot = "2780937993";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>

</script></div>
    <button onclick="showModal();">Show loading modal</button>
</div>

<script src="http://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
<script src="/bpl/source/login/js/jquery.loadingModal.js"></script>
<script>
    function showModal() {
        $('body').loadingModal({text: 'Showing loader animations...'});

        var delay = function(ms){ return new Promise(function(r) { setTimeout(r, ms) }) };
        var time = 1000;

        delay(time)
                
                .then(function() { $('body').loadingModal('animation', 'wanderingCubes').loadingModal('backgroundColor', 'green'); return delay(time);})
                .then(function() { $('body').loadingModal('color', 'white').loadingModal('text', 'Processing ...').loadingModal('backgroundColor', 'gray');  return delay(time); } )
                .then(function() { $('body').loadingModal('animation', 'foldingCube'); return delay(time); })
                .then(function() { $('body').loadingModal('color', 'white').loadingModal('text', 'Done!').loadingModal('backgroundColor', 'yellow');  return delay(time); } )
                .then(function() { $('body').loadingModal('hide'); return delay(time); } )
                .then(function() { $('body').loadingModal('destroy') ;} );
    }

</script>
</body><script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</html>
