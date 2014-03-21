<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <title>
        </title>
        <!--link rel="stylesheet" href="https://s3.amazonaws.com/codiqa-cdn/mobile/1.2.0/jquery.mobile-1.2.0.min.css" /-->
        <!--link rel="stylesheet" href="my.css" /-->
        <!--script src="jquery.min.js"></script -->
	
		<link rel="stylesheet" href="style.css"/>
		        <link rel="stylesheet" href="themes/AndroidHoloDarkLight.min.css" />
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile.structure-1.3.1.min.css" />
		
        <script src="jquery-ui-slider.min.js"></script>

		<script type="text/javascript" src="jscolor.js"></script>
		<script src="rsvp.js"></script>
		<script src="pagespecific.js"></script>
        <script src="https://s3.amazonaws.com/codiqa-cdn/mobile/1.2.0/jquery.mobile-1.2.0.min.js">
        </script>
        <script src="my.js">
        </script>

		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
        <!-- User-generated css -->
        <style>
        </style>
        <!-- User-generated js -->
        <script>
            try {

    $(function() {

    });

  } catch (error) {
    console.error("Your javascript has an error: " + error);
  }
  


        </script>
        
<script>
$(document).ready(function(){
	$('#queryform').submit(function() {
	 if ( $.browser.msie ) return true;
	  return false;
});

	$('#VisitURL').keyup(function(e){
		var key = ( e.charCode ? e.charCode : (e.keyCode ? e.keyCode : 0) );
		//alert(key)
		if(key == 8){
			  $('#message').val("");
		}
	});
	$('#btn_track_job').click(function(){
		
		var VisitURL = $.trim( $('#VisitURL').val() );
		if(VisitURL.length==0) {
			alert('Please fill in url you\'d like to read.');
			$('#VisitURL').focus();
		}
		else {
			$('#loadcont').show();
			 $.post("queryjob.php", { 'url': VisitURL }, function(json_data){
			  var newdata = jQuery.parseJSON(json_data);
			  if(newdata.title != "" && newdata.content != "") { /// data.length==6
				  var str_content = newdata.content;
				  var str_title = newdata.title;
				  $('#title').val(str_title);
				  $('#input_text_ta').val(str_content);
				  $('#loadcont').hide();
				  startNewPlayback(); return false;
			  }else{
				alert("There's no item found.");
				$('#input_text_ta').val("");
				$('#loadcont').hide();
				}
			});
		}
		
	});
	
});

        </script>
        
    </head>
    <body>
    	

        <!-- Home -->
        <div data-role="page" id="reader">
            <div data-role="content">
            	
<form method=get action="#" id="queryform">
<input type=hidden name=type value="main">
<label for="textinput1">
Enter URL
</label>
<input name="VisitURL" id="VisitURL" placeholder="e.g. http://www.fnord.be/blog/bitcoinadventures" value="<?PHP 
if(isset($_GET['url'])) echo $_GET['url'];
?>" type="text"  min="5" > <br/>




<!--Words per minute: --><input type="hidden" size="3" id="groupsPerMinute" value="300" data-inline="true" onchange="recomputeWpm()"/>
<!--input type="button" value="Save changes" onclick="changeSettingsButtonCallback();"/><br/-->
</br/>
<br/>
<input class=rounded style="background-color:#eeeeee; " id="title" name="title" readonly="readonly" type="hidden" class="job_input"/>

<div class="result" style="visibility:hidden"></div>
<div class="log" style="visibility:hidden"></div>
</p>
<script>
$(document).ready(function(){
	$('#queryform').submit(function() {
	 if ( $.browser.msie ) return true;
	  return false;
});

	$('#VisitURL').keyup(function(e){
		var key = ( e.charCode ? e.charCode : (e.keyCode ? e.keyCode : 0) );
		//alert(key)
		if(key == 8){
			  $('#message').val("");
		}
	});
	$('#btn_track_job').click(function(){
		
		var VisitURL = $.trim( $('#VisitURL').val() );
		if(VisitURL.length==0) {
			alert('Please fill in url you\'d like to read.');
			$('#VisitURL').focus();
		}
		else {
			$('#loadcont').show();
			 $.post("queryjob.php", { 'url': VisitURL }, function(json_data){
			  var newdata = jQuery.parseJSON(json_data);
			  if(newdata.title != "" && newdata.content != "") { /// data.length==6
				  var str_content = newdata.content;
				  var str_title = newdata.title;
				  $('#title').val(str_title);
				  $('#input_text_ta').val(str_content);
				  $('#loadcont').hide();
				  startNewPlayback(); return false;
			  }else{
				alert("There's no item found.");
				$('#input_text_ta').val("");
				$('#loadcont').hide();
				}
			});
		}
		
	});
	
});

        </script>
</td></tr></table>
<!--/div-->
</form>

<input type=button height=35px id="btn_track_job" data-inline="true" class="button_add" name="btn_track_job" class="hand" value="Read" onclick="playButtonCallback(); return false;" />
<input type=button height=35px id="btn_track_job" data-inline="true" class="button_add" name="btn_track_job" class="hand" value="Pause" onclick="pauseButtonCallback(); return false;" /> </br>
<br/></br>

<div id="display" style="font-size:300%">
	Select your url and press load.
</div>



		<!--div id="playback_controls" class="controls_div">
			<table id="controls_table">
				<tr>
					<td>
						
						<a href="#" onclick="playButtonCallback(); return false;" class="playback_control_a"><img src="images/play.gif"></a>
						<a href="#" onclick="pauseButtonCallback(); return false;" class="playback_control_a"><img src="images/pause.gif"></a>
						<a href="#" onclick="rewindButtonCallback(); return false;" class="playback_control_a"><img src="images/rewind.gif"></a>
					</td>
					<td>
						<!--div id='slider_div'>
							<div class='ui-slider-handle'></div>
						</div-->
					<!--/td>
				</tr>
			</table>
		</div-->
		
<input type="hidden" size="3" id="numLines" value="1" onchange="recomputeWpm()"/>
<input type="hidden" size="3" id="wordsPerLine" value="1" onchange="recomputeWpm()"/>
<input type="hidden" size="3" value="600" id="wordsPerMinute" onchange="recomputeWpm()" disabled="true"/></td>
<input class="color" id="bg_color" size="6" value="FFFFFF" type="hidden"/>
<input class="color" id="text_color" size="6" value="000000" type="hidden"/>
<textarea id="viewer_ta" rows="5" cols="70" style="visibility:hidden"></textarea>
<textarea id="input_text_ta" cols="70" rows="10" style="visibility:hidden"></textarea>


            </div>
            <div data-theme="a" data-role="footer" data-position="fixed">
                <div data-role="navbar" data-iconpos="right">
                    <ul>
                        <li>
                            <a href="home.html" data-transition="slide" data-direction="reverse" data-theme="" data-icon="star">
                                Select URL
                            </a>
                        </li>
                        <li>
                            <a href="#reader" data-transition="slide" data-theme="" data-icon="search" class="ui-btn-active ui-state-persist">
                                Read
                            </a>
                        </li>
                        <li>
                            <a href="about.html" data-transition="slide" data-theme="" data-icon="info">
                                About
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
	<script>
	

	$(document).ready(function() {	
	if($('#input_text_ta') == ''){
		$('#input_text_ta').val("you need to enter a URL!");
		location.reload();
	}
		  var qs = decodeURIComponent(window.location.search);	
			qs= qs.replace("?url=","");
			if(qs ){
				$('#input_text_ta').val(qs);
			}
	});
	
	</script>
</html>
