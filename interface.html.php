<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Blackbody Lab Client</title>
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="js/jquery/jquery-ui-multiselect-widget-master/jquery.multiselect.css" />
	<link rel="stylesheet" type="text/css" href="js/jquery/jquery-ui-multiselect-widget-master/demos/assets/style.css" />
	<link rel="stylesheet" href="js/jquery/jquery-ui-1.10.3/themes/base/jquery-ui.css" />
	<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />-->
	<link rel="stylesheet" href="interface.style.css" />
	<!-- jQuery Libs and Extensions -->
	<script type="text/javascript" src="js/jquery/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/jquery/jquery-ui-1.10.3/ui/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jquery/jquery-ui-multiselect-widget-master/src/jquery.multiselect.js"></script>
	<script type="text/javascript" src="js/jquery/jquery.download.js"></script>
	<script type="text/javascript" src="js/jquery/jquery.getUrlVars.js"></script>
	<!-- JS Google Charts -->
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<!-- JS -->
	<script type="text/javascript" src="js/ajaxUpdate.js"></script>
	<script type="text/javascript" src="js/Chart.js"></script>
	<script type="text/javascript" src="js/export.js"></script>
	<script type="text/javascript" src="js/layerHandler.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/sb_Cancel.js"></script>
	<script type="text/javascript" src="js/sb_GetExperimentStatus.js"></script>
	<script type="text/javascript" src="js/sb_RetrieveResult.js"></script>
	<script type="text/javascript" src="js/sb_Submit.js"></script>
	<script type="text/javascript" src="js/updateProgressbar.js"></script>
	<script type="text/javascript" src="js/updateSelectmenus.js"></script>
	<script type="text/javascript" src="js/Video.js"></script>
	<!-- DEBUG/TEST JS -->
	<script type="text/javascript" src="js/_parseSoapFault.js"></script>
	<script type="text/javascript" src="js/_retrievePayload.js"></script>
	<!-- HTML5 Video -->
	<script src="//api.html5media.info/1.1.8/html5media.min.js"></script>
</head>

<body>
<!-- BEGIN CONTENT -->

<!-- <h1>Blackbody Lab-Client v1</h1> -->

<!-- Debug Fields -->
<p id="SBresponse"></p>

<!-- Sample Messageboxes -->
<!--
<p id="messagebox" class="messagebox">Messagebox (Standard)</p>
<p id="messageboxInf" class="messagebox info">Messagebox Info</p>
<p id="messageboxSuc" class="messagebox success">Messagebox Success</p>
<p id="messageboxWar" class="messagebox warning">Messagebox Warning</p>
<p id="messageboxErr" class="messagebox error">Messagebox Error</p>
-->

<div id="tabs">

	<ul>
		<li><a href="#tab_d">Measurement over Distance</a></li>
		<li><a href="#tab_h">Measurement History</a></li>
	</ul>


	<!-- Measurement Distance TAB -->
	<div id="tab_d">

		<!-- Left pane -->
		<div style="width:500px; height:450px; float:left;">
		<div id="chart_d" style="width:500px; height:300px;"></div>
		<div>
			<p>Show experiment on graph:</p>
			<p>
			<select title="Select Distance Experiments" multiple="multiple" id="sel_exp_d" name="sel_exp_d" size="1">
			</select>
			<input type="submit" id="btn_showExp_d" value="Show">
			</p>
			<p>Export to Excel (.csv):</p>
			<p>
			<input type="submit" id="btn_exportAll_d" value="All experiments">
			<input type="submit" id="btn_exportGraph_d" value="Only experiments on graph">
			</p>
		</div>
		</div>

		<!-- Right pane -->
		<div>

			<!-- Layer: switchTo -->
			<div id="layer_switchTo_d">
			<h3>Switch to: <span id="btn_layer_settings_d" style="text-decoration: underline; cursor: pointer;">Settings</span> | <span id="btn_layer_vid_d"  style="text-decoration: underline; cursor: pointer;">Video</span></h3>
			</div>

			<!-- Layer: settings -->
			<div id="layer_settings_d">

			<p>Choose Lightsource:</p>
			<div id="lightsources_d">
				<input type="radio" id="src_rad_bulb_d" name="src_rad_d" checked="checked"><label for="src_rad_bulb_d">Lightbulb</label>
				<input type="radio" id="src_rad_esav_d" name="src_rad_d"><label for="src_rad_esav_d">Energy Saver</label>
				<input type="radio" id="src_rad_halg_d" name="src_rad_d"><label for="src_rad_halg_d">Halogen</label>
				<input type="radio" id="src_rad_led_d"  name="src_rad_d"><label for="src_rad_led_d">LED</label>
			</div>
			<p>Choose Sensor:</p>
			<div id="sensors_d">
				<input type="radio" id="sen_rad_s130vc_d" name="sen_rad_d" checked="checked"><label for="sen_rad_s130vc_d">S130VC<br />200nm-1100nm</label>
				<input type="radio" id="sen_rad_s132c_d"  name="sen_rad_d"><label for="sen_rad_s132c_d">S132C<br />700nm-1800nm</label>
				<input type="radio" id="sen_rad_s310c_d"  name="sen_rad_d"><label for="sen_rad_s310c_d">S310C<br />190nm-25&mu;m</label>
			</div>
			<p>
				<label>Set Distance:</label>
				<input type="text" id="txt_distance" style="border:0; color:#f6931f; font-weight:bold;">
			</p>
			<div id="sldr_distance" style="width:300px; overflow:hidden;"></div>
			<p>
				<label>Set Stepsize:</label>
				<input type="text" id="txt_stepsize" style="border:0; color:#f6931f; font-weight:bold;">
			</p>
			<div id="sldr_stepsize" style="width:300px; overflow:hidden;"></div>

			<!-- Layer: submit -->
			<div id="layer_submit_d">
				<br />
				<input type="submit" id="btn_submit_d" value="Run experiment">
				<input type="checkbox" id="chk_recVideo_d"><label for="chk_recVideo_d">Record Video</label>
			</div>

			<!-- Layer: noSubmit -->
			<div id="layer_noSubmit_d">
				<p id="noSubmitMsg_d" class="messagebox info" style="clear:none;width:300px">No new experiments until other one finished!</p>
			</div>

			<!-- Layer: runExp -->
			<div id="layer_runExp_d">
			<br />
			<div id="expProgressbar_d"><div id="lbl_expProgressbar_d" class="lbl_Progressbar">Loading...</div></div>
			&nbsp;&nbsp;
			<input type="submit" id="btn_cancel_d" value="Cancel">
			</div>

			</div>

			<!-- Layer: video -->
			<div id="layer_video_d">
				<div>
					<p>Select video from list:</p>
					<select title="Select Video" id="sel_vid_d" name="sel_vid_d" size="1">
					</select>
				</div>
				<br /><div id="lbl_vid_d">Placeholder:</div>
				<video id="vid_d" width="320" height="240">
					<source id="mp4_d" src="vid/placeholder.mp4" type="video/mp4" />
					Your browser does not support the video tag.
				</video>
				<br />
				<input type="submit" id="btn_playPause_d" value="Play/Pause" />
			</div>

		</div>
		<div class="clear"></div>
	</div>
	<!-- END Measurement Distance TAB -->


	<!-- Measurement History TAB -->
	<div id="tab_h">

		<!-- Left pane -->
		<div style="width:500px; height:450px; float:left;">
		<div id="chart_h" style="width:500px; height:300px;"></div>
		<div>
			<p>Show experiment on graph:</p>
			<p>
			<select title="Select History Experiments" multiple="multiple" id="sel_exp_h" name="sel_exp_h" size="1">
			</select>
			<input type="submit" id="btn_showExp_h" value="Show">
			</p>
			<p>Export to Excel (.csv):</p>
			<p>
			<input type="submit" id="btn_exportAll_h" value="All experiments">
			<input type="submit" id="btn_exportGraph_h" value="Only experiments on graph">
			</p>
		</div>
		</div>

		<!-- Right pane -->
		<div>
		
			<!-- Layer: switchTo -->
			<div id="layer_switchTo_h">
			<h3>Switch to: <span id="btn_layer_settings_h" style="text-decoration: underline; cursor: pointer;">Settings</span> | <span id="btn_layer_vid_h"  style="text-decoration: underline; cursor: pointer;">Video</span></h3>
			</div>

			<!-- Layer: settings -->
			<div id="layer_settings_h">

			<p>Choose Lightsource:</p>
			<div id="lightsources_h">
				<input type="radio" id="src_rad_bulb_h" name="src_rad_h" checked="checked"><label for="src_rad_bulb_h">Lightbulb</label>
				<input type="radio" id="src_rad_heat_h" name="src_rad_h"><label for="src_rad_heat_h">Heater</label>
				<input type="radio" id="src_rad_esav_h" name="src_rad_h"><label for="src_rad_esav_h">Energy Saver</label>
				<input type="radio" id="src_rad_halg_h" name="src_rad_h"><label for="src_rad_halg_h">Halogen</label>
				<input type="radio" id="src_rad_led_h"  name="src_rad_h"><label for="src_rad_led_h">LED</label>
			</div>
			<p>Choose Sensor:</p>
			<div id="sensors_h">
				<input type="radio" id="sen_rad_s130vc_h" name="sen_rad_h" checked="checked"><label for="sen_rad_s130vc_h">S130VC<br />200nm-1100nm</label>
				<input type="radio" id="sen_rad_s132c_h"  name="sen_rad_h"><label for="sen_rad_s132c_h">S132C<br />700nm-1800nm</label>
				<input type="radio" id="sen_rad_s310c_h"  name="sen_rad_h"><label for="sen_rad_s310c_h">S310C<br />190nm-25&mu;m</label>
			</div>
			<p>
				<label>Set Duration:</label>
				<input type="text" id="txt_duration" style="border:0; color:#f6931f; font-weight:bold;">
			</p>
			<div id="sldr_duration" style="width:300px; overflow:hidden;"></div>
			<br />

			<!-- Layer: submit -->
			<div id="layer_submit_h">
				<input type="submit" id="btn_submit_h" value="Run experiment">
				<input type="checkbox" id="chk_recVideo_h"><label for="chk_recVideo_h">Record Video</label>
			</div>

			<!-- Layer: noSubmit -->
			<div id="layer_noSubmit_h">
				<p id="noSubmitMsg_h" class="messagebox info" style="clear:none;width:300px">No new experiments until other one finished!</p>
			</div>

			<!-- Layer: runExp -->
			<div id="layer_runExp_h">
			<br />
			<div id="expProgressbar_h"><div id="lbl_expProgressbar_h" class="lbl_Progressbar">Loading...</div></div>
			&nbsp;&nbsp;
			<input type="submit" id="btn_cancel_h" value="Cancel">
			</div>

			</div>

			<!-- Layer: video -->
			<div id="layer_video_h">
				<div>
					<p>Select video from list:</p>
					<select title="Select Video" id="sel_vid_h" name="sel_vid_h" size="1">
					</select>
				</div>
				<br /><div id="lbl_vid_h">Placeholder:</div>
				<video id="vid_h" width="320" height="240">
					<source id="mp4_h" src="vid/placeholder.mp4" type="video/mp4" />
					Your browser does not support the video tag.
				</video>
				<br />
				<input type="submit" id="btn_playPause_h" value="Play/Pause" />
			</div>

		</div>
		<div class="clear"></div>
	</div>
	<!-- END Measurement History TAB -->


</div>
<!-- END CONTENT -->
</body>
</html>
