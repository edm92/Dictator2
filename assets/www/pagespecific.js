// ---------------------------------------------------------------------------
// Functions that bind the UI to the Rsvp object

function extractSettings(){
	return {
			'numLines': parseInt($('#numLines').val()),
			'wordsPerLine': parseInt($('#wordsPerLine').val()),
			'groupsPerMinute': parseInt($('#groupsPerMinute').val())
		};
}

function changeSettingsButtonCallback(){
	var newSettings = extractSettings();
	
	if($("#display").data('rsvpInstance'))
		$("#display").data('rsvpInstance').changeSettings(newSettings);
	
	recomputeWpm();
}

function recomputeWpm(){
	var newSettings = extractSettings();

	$("#wordsPerMinute").val(
			newSettings.numLines *
			newSettings.wordsPerLine *
			newSettings.groupsPerMinute);
}

function _incrementSpeed(wpm_plus){
	var rsvpInstance = $("#display").data('rsvpInstance');
	
	if(rsvpInstance){
		newGpm = rsvpInstance.incrementSpeed(wpm_plus);
		$('#groupsPerMinute').val(newGpm);
		recomputeWpm();
	}
}

function startNewPlayback(){
	
	var oldInstance = $("#display").data(
		'rsvpInstance');
		
	if(oldInstance){
		oldInstance.destroy();
	}
	
	$('#viewer_ta').val($('#input_text_ta').val());
	
	var rsvpInstance = new Rsvp(
			$("#input_text_ta").val(),
			$('#display'),
			extractSettings(),
			$('#slider_div'),
			$('#viewer_ta')
		);

	$("#display").data(
		'rsvpInstance',
		rsvpInstance
	);
	
	rsvpInstance.start();
}

function handleSlideEvent(e, ui){
	var newValue = ui.value;

	var rsvpInstance = $("#display").data('rsvpInstance');
	
	if(rsvpInstance){
		if(!rsvpInstance.sliderEventDisabled){
			//rsvpInstance.moveToPercentage(newValue / 200);
		}
	}
}

var playing = false;

function togglePlayPause(){
	if(!playing){
		playing = true;
		playButtonCallback();
	}else{
		playing = false;
		pauseButtonCallback();
	}
}

function playButtonCallback(){
	var rsvpInstance = $("#display").data('rsvpInstance');
	
	if(rsvpInstance){
		rsvpInstance.playOrResume();
	}else{
		if(!playing){
			$(queryform).hide();
			startNewPlayback();
			playing = true;
		}
	}
}

function pauseButtonCallback(){
	var rsvpInstance = $("#display").data('rsvpInstance');
	
	if(rsvpInstance){
		rsvpInstance.pause();
	}
}

function rewindButtonCallback(){
	var rsvpInstance = $("#display").data('rsvpInstance');
	
	if(rsvpInstance){
		rsvpInstance.rewind();
	}
}

$(function(){
	$('#slider_div').slider({ min: 0, max: 200, startValue: 0, slide: handleSlideEvent });
});



function _keyupHandler(event){
	keycode = event.keyCode;

	if(keycode == 38){
		// up key
		_incrementSpeed(10)
	}else if(keycode == 40){
		// down key
		_incrementSpeed(-10)
	}

	return false;
}

function _setBgColor(color){
	$("#display").css("background-color", "#"+color);
	$("#viewer_ta").css("background-color", "#"+color);
}

function _setFgColor(color){
	$("#display").css("color", "#"+color);
	$("#viewer_ta").css("color", "#"+color);
}

$(function(){
	// To use the text given by the bookmarklet
//	var qs = window.location.search;
	
//	if(qs && qs.length > 1){
//		$('#input_text_ta').val(decodeURIComponent(qs.substring(1)));
//	}

	$(".playback_control_a img")
		.mouseover(function(){ $(this).css('background-color', '#888'); })
		.mouseout(function(){ $(this).css('background-color', '#aaa'); });

	$(document).keyup(_keyupHandler);

	$("#bg_color").change(
		function(){ _setBgColor(  $("#bg_color").val()  );  }
		);
	$("#text_color").change(
		function(){ _setFgColor(  $("#text_color").val()  );  }
		);

	$("#viewer_ta").keydown(_keyupHandler);
});

