<?php
    global $path;
?>
<script type="text/javascript" src="<?php echo $path; ?>Modules/user/user.js"></script>
<script type="text/javascript" src="<?php echo $path; ?>Modules/feed/feed.js"></script>
<script type="text/javascript" src="<?php echo $path; ?>Lib/tablejs/table.js"></script>
<script type="text/javascript" src="<?php echo $path; ?>Lib/tablejs/custom-table-fields.js"></script>
<link href="<?php echo $path; ?>Lib/bootstrap-datetimepicker-0.0.11/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo $path; ?>Lib/bootstrap-datetimepicker-0.0.11/js/bootstrap-datetimepicker.min.js"></script>

<style>
#table input[type="text"] {
         width: 88%;
}

#table td:nth-of-type(5) { width:14px; text-align: center; }
#table th:nth-of-type(8), td:nth-of-type(8) { text-align: right; }
#table th:nth-of-type(9), td:nth-of-type(9) { text-align: right; }
#table th:nth-of-type(10), td:nth-of-type(10) { text-align: right; }
#table td:nth-of-type(11) { width:14px; text-align: center; }
#table td:nth-of-type(12) { width:14px; text-align: center; }
#table td:nth-of-type(13) { width:14px; text-align: center; }
#table td:nth-of-type(14) { width:14px; text-align: center; }
#table td:nth-of-type(15) { width:14px; text-align: center; }
</style>

<div>
    <div id="apihelphead" style="float:right;"><a href="api"><?php echo _('Feed API Help'); ?></a></div>
    <div id="localheading"><h2><?php echo _('Feeds'); ?></h2></div>

    <div id="nofeeds" class="alert alert-block hide">
            <h4 class="alert-heading"><?php echo _('No feeds created'); ?></h4>
            <p><?php echo _('Feeds are where your monitoring data is stored. The route for creating storage feeds is to start by creating inputs (see the inputs tab). Once you have inputs you can either log them straight to feeds or if you want you can add various levels of input processing to your inputs to create things like daily average data or to calibrate inputs before storage. Alternatively you can create Virtual feeds, this is a special feed that allows you to do post processing on existing storage feeds data, the main advantage is that it will not use additional storage space and you may modify post processing list that gets applyed on old stored data. You may want to follow the link as a guide for generating your request.'); ?><a href="api"><?php echo _('Feed API helper'); ?></a></p>
    </div>

    <div id="table"><div align='center'>loading...</div></div>

    <div id="bottomtoolbar" class="hide"><hr>
        <button id="refreshfeedsize" class="btn btn-small" ><i class="icon-refresh" ></i>&nbsp;<?php echo _('Refresh feed size'); ?></button>
        <button id="addnewvirtualfeed" class="btn btn-small" data-toggle="modal" data-target="#newFeedNameModal"><i class="icon-plus-sign" ></i>&nbsp;<?php echo _('New virtual feed'); ?></button>
    </div>
</div>

<div id="myModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"><?php echo _('Delete feed'); ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo _('Deleting a feed is permanent.'); ?></p>
        <br>
        <div id="deleteFeedText"><?php echo _('If you have Input Processlist processors that use this feed, after deleting it, review that process lists or they will be in error, freezing other Inputs. Also make sure no Dashboards use the deleted feed.'); ?></div>
        <div id="deleteVirtualFeedText"><?php echo _('This is a Virtual Feed, after deleting it, make sure no Dashboard continue to use the deleted feed.'); ?></div>
        <br><br>
        <p><?php echo _('Are you sure you want to delete?'); ?></p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo _('Cancel'); ?></button>
        <button id="confirmdelete" class="btn btn-primary"><?php echo _('Delete permanently'); ?></button>
    </div>
</div>

<div id="ExportModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="ExportModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="ExportModalLabel">CSV export: </h3>
    </div>
    <div class="modal-body">
    <p>Selected feed: <b><span id="SelectedExportFeed"></span></b></p>
    <p>Select the time range and interval that you wish to export: </p>
    
        <table class="table">
        <tr>
            <td>
                <p><b>Start date & time</b></p>
                <div id="datetimepicker1" class="input-append date">
                    <input id="export-start" data-format="dd/MM/yyyy hh:mm:ss" type="text" />
                    <span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                </div>
            </td>
            <td>
                <p><b>End date & time</b></p>
                <div id="datetimepicker2" class="input-append date">
                    <input id="export-end" data-format="dd/MM/yyyy hh:mm:ss" type="text" />
                    <span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <p><b>Interval</b></p>
                <select id="export-interval" >
                    <option value="">Select interval</option>
                    <option value=5>5s</option>
                    <option value=10>10s</option>
                    <option value=30>30s</option>
                    <option value=60>1 min</option>
                    <option value=300>5 mins</option>
                    <option value=600>10 mins</option>
                    <option value=900>15 mins</option>
                    <option value=1800>30 mins</option>
                    <option value=3600>1 hour</option>
                    <option value=21600>6 hour</option>
                    <option value=43200>12 hour</option>
                    <option value=86400>Daily</option>
                    <option value=604800>Weekly</option>
                    <option value=2678400>Monthly</option>
                    <option value=31536000>Annual</option>
                </select>
            </td>
            <td>
                <p><b>Timezone offset (for day export):</b></p>
                <input id="export-timezone-offset" type="text" />
            </td>
        </tr>
        <tr>
            <td><br><button class="btn" id="export">Export</button></td><td><br>Estimated download size: <span id="downloadsize">0</span>kB</td>
        </tr>
        </table>
        <p>Feed intervals: if the selected interval is shorter than the feed interval the feed interval will be used instead</p>
        <p>Averages are only returned for feed engines with built in averaging.</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo _('Close'); ?></button>
    </div>
</div>

<div id="newFeedNameModal" class="modal hide keyboard" tabindex="-1" role="dialog" aria-labelledby="newFeedNameModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="newFeedNameModalLabel"><?php echo _('New Virtual Feed'); ?></h3>
    </div>
    <div class="modal-body">
        <label>Feed Name: </label>
        <input type="text" value="New Virtual Feed" id="newfeed-name">
        <label>Feed Tag: </label>
        <input type="text" value="Virtual" id="newfeed-tag">
        <label>Feed DataType: </label>
        <select id="newfeed-datatype">
            <option value=1>Realtime</option>
            <option value=2>Daily</option>
        </select>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo _('Cancel'); ?></button>
        <button id="newfeed-save" class="btn btn-primary"><?php echo _('Save'); ?></button>
    </div>
</div>

<?php require "Modules/process/Views/process_ui.php"; ?>

<script>
  var path = "<?php echo $path; ?>";

  // Extend table library field types
  for (z in customtablefields) table.fieldtypes[z] = customtablefields[z];
  table.element = "#table";
  table.groupby = 'tag';
  table.deletedata = false;
  table.fields = {
    'id':{'title':"<?php echo _('Id'); ?>", 'type':"fixed"},
    'tag':{'title':"<?php echo _('Tag'); ?>", 'type':"hinteditable"},
    'name':{'title':"<?php echo _('Name'); ?>", 'type':"text"},
    'processList':{'title':'<?php echo _("Process list"); ?>','type':"processlist"},
    'public':{'title':"<?php echo _('Public'); ?>", 'type':"icon", 'trueicon':"icon-globe", 'falseicon':"icon-lock"},
    'datatype':{'title':"<?php echo _('Datatype'); ?>", 'type':"fixedselect", 'options':['','REALTIME','DAILY','HISTOGRAM']},
    'engine':{'title':"<?php echo _('Engine'); ?>", 'type':"fixedselect", 'options':['MYSQL','TIMESTORE','PHPTIMESERIES','GRAPHITE','PHPTIMESTORE','PHPFINA','PHPFIWA','VIRTUAL','MEMORY','REDISBUFFER']},
    'size':{'title':"<?php echo _('Size'); ?>", 'type':"size"},
    'time':{'title':"<?php echo _('Updated'); ?>", 'type':"updated"},
    'value':{'title':"<?php echo _('Value'); ?>",'type':"value"},
    // Actions
    'edit-action':{'title':'', 'type':"edit"},
    'delete-action':{'title':'', 'type':"delete"},
    'view-action':{'title':'', 'type':"iconlink", 'link':path+"vis/auto?feedid="},
    'processlist-action':{'title':'', 'type':"iconconfig", 'icon':'icon-wrench'},
    'icon-basic':{'title':'', 'type':"iconbasic", 'icon':'icon-circle-arrow-down'}
  }

  update();

  function update(){   
    var apikeystr = ""; if (feed.apikey!="") apikeystr = "?apikey="+feed.apikey;

    var requestTime = (new Date()).getTime();
    $.ajax({ url: path+"feed/list.json"+apikeystr, dataType: 'json', async: true, success: function(data, textStatus, xhr) {
      table.timeServerLocalOffset = requestTime-(new Date(xhr.getResponseHeader('Date'))).getTime(); // Offset in ms from local to server time
      table.data = data;
      for (z in table.data){
        if (data[z]['engine'] != 7){ 
          data[z]['#NO_CONFIG#'] = true;  // if the data field #NO_CONFIG# is true, the field type: iconconfig will be ommited from the table row
        }
      }
      table.draw();
      if (table.data.length == 0){
        $("#nofeeds").show();
        $("#localheading").hide();
        $("#apihelphead").hide();
        $("#bottomtoolbar").show();
      } else {
        $("#nofeeds").hide();
        $("#localheading").show();
        $("#apihelphead").show();
        $("#bottomtoolbar").show();
      }
    } });
  }

  var updater;
  function updaterStart(func, interval){
    clearInterval(updater);
    updater = null;
    if (interval > 0) updater = setInterval(func, interval);
  }
  updaterStart(update, 5000);

  $("#table").bind("onEdit", function(e){
    updaterStart(update, 0);
  });

  $("#table").bind("onSave", function(e,id,fields_to_update){
    feed.set(id,fields_to_update);
  });

  $("#table").bind("onResume", function(e){
    updaterStart(update, 5000);
  });

  $("#table").bind("onDelete", function(e,id,row){
    updaterStart(update, 0);
    if (table.data[row]['engine'] == 7) { //Virtual
      $('#myModal #deleteFeedText').hide();
      $('#myModal #deleteVirtualFeedText').show();
    } else {
      $('#myModal #deleteFeedText').show();
      $('#myModal #deleteVirtualFeedText').hide();
    }
    $('#myModal').modal('show');
    $('#myModal').attr('the_id',id);
    $('#myModal').attr('the_row',row);
  });

  $("#confirmdelete").click(function(){
    var id = $('#myModal').attr('the_id');
    var row = $('#myModal').attr('the_row');
    feed.remove(id);
    table.remove(row);
    update();

    $('#myModal').modal('hide');
    updaterStart(update, 5000);
  });

  $("#refreshfeedsize").click(function(){
    $.ajax({ url: path+"feed/updatesize.json", async: true, success: function(data){ update(); alert("Total size of used space for feeds: " + list_format_size(data)); } });
  });

  // Feed Export feature
  $("#table").on("click",".icon-circle-arrow-down", function(){
    var row = $(this).attr('row');
    $("#SelectedExportFeed").html(table.data[row].tag+": "+table.data[row].name);
    $("#export").attr('feedid',table.data[row].id);

    if ($("#export-timezone-offset").val()=="") {
      var timezoneoffset = user.timezoneoffset();
      if (timezoneoffset==null) timezoneoffset = 0;
      $("#export-timezone-offset").val(parseInt(timezoneoffset));
    }
    $('#ExportModal').modal('show');
  });

  $('#datetimepicker1').datetimepicker({
    language: 'en-EN'
  });

  $('#datetimepicker2').datetimepicker({
    language: 'en-EN'
  });

  $('#export-interval').on('change', function(e) 
  {
    var export_start = parse_timepicker_time($("#export-start").val());
    var export_end = parse_timepicker_time($("#export-end").val());
    var export_interval = $("#export-interval").val();
    var downloadsize = ((export_end - export_start) / export_interval) * 17; // 17 bytes per dp
    console.log(downloadsize);
    $("#downloadsize").html((downloadsize/1024).toFixed(0));
  });

  $('#datetimepicker1, #datetimepicker2').on('changeDate', function(e) 
  {
    var export_start = parse_timepicker_time($("#export-start").val());
    var export_end = parse_timepicker_time($("#export-end").val());
    var export_interval = $("#export-interval").val();
    var downloadsize = ((export_end - export_start) / export_interval) * 17; // 17 bytes per dp
    $("#downloadsize").html((downloadsize/1024).toFixed(0));
  });
  
  $("#export").click(function()
  {
    var feedid = $(this).attr('feedid');
    var export_start = parse_timepicker_time($("#export-start").val());
    var export_end = parse_timepicker_time($("#export-end").val());
    var export_interval = $("#export-interval").val();
    var export_timezone_offset = parseInt($("#export-timezone-offset").val());
    
    if (!export_start) {alert("Please enter a valid start date"); return false; }
    if (!export_end) {alert("Please enter a valid end date"); return false; }
    if (export_start>=export_end) {alert("Start date must be further back in time than end date"); return false; }
    if (export_interval=="") {alert("Please select interval to download"); return false; }
    var downloadsize = ((export_end - export_start) / export_interval) * 17; // 17 bytes per dp
    
    if (downloadsize>(10*1048576)) {alert("Download file size to large (download limit: 10Mb)"); return false; }
    url = path+"feed/csvexport.json?id="+feedid+"&start="+(export_start+(export_timezone_offset))+"&end="+(export_end+(export_timezone_offset))+"&interval="+export_interval;
    console.log(url);
    window.open(url);
  });

  function parse_timepicker_time(timestr){
    var tmp = timestr.split(" ");
    if (tmp.length!=2) return false;

    var date = tmp[0].split("/");
    if (date.length!=3) return false;

    var time = tmp[1].split(":");
    if (time.length!=3) return false;

    return new Date(date[2],date[1]-1,date[0],time[0],time[1],time[2],0).getTime() / 1000;
  }


  // Virtual Feed feature
  $("#newfeed-save").click(function (){
    var newfeedname = $('#newfeed-name').val();
    var newfeedtag = $('#newfeed-tag').val();
    var engine = 7;   // Virtual Engine
    var datatype = $('#newfeed-datatype').val();
    var options = {};
    
    var result = feed.create(newfeedtag,newfeedname,datatype,engine,options);
    feedid = result.feedid;

    if (!result.success || feedid<1) {
      alert('ERROR: Feed could not be created. '+result.message);
      return false;
    } else {
      update(); 
      $('#newFeedNameModal').modal('hide');
    }
  });

  // Process list UI js
  processlist_ui.init(1); // is virtual feed

  $("#table").on('click', '.icon-wrench', function() {
    var i = table.data[$(this).attr('row')];
    console.log(i);
    var contextid = i.id; // Feed ID
    var contextname = i.tag + " : " + i.name;
    var processlist = processlist_ui.decode(i.processList); // Feed process list
    processlist_ui.load(contextid,processlist,contextname,null,null); // load configs
   });
  
  $("#save-processlist").click(function (){
    var result = feed.set_process(processlist_ui.contextid,processlist_ui.encode(processlist_ui.contextprocesslist));
    if (result.success) { processlist_ui.saved(); } else { alert('ERROR: Could not save processlist. '+result.message); }
  }); 
</script>
