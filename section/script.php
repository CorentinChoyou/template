<!-- Start script for Reload page/show pop up on the eve of event starts on time -->
<?php
$perform_action_before_event_time_sec = ( 30 * 60 ); // 30 mins to seconds
//echo "<pre>perform_action_before_event_time_sec => ".$perform_action_before_event_time_sec."</pre>";  
?>
<script type="text/javascript">
  $( document ).ready(function() {
    var is_logged_in_status = Number("<?php echo is_logged_in_status; ?>");
    //console.log("is_logged_in_status", is_logged_in_status);
      
    var login_required = Number("<?php echo $login_required; ?>");
    //console.log("login_required", login_required);  
      
    var event_starts_on_timestamp = Number("<?php echo $event_starts_on_timestamp; ?>");
    //console.log("event_starts_on_timestamp => ", event_starts_on_timestamp);
    //console.log("event_starts_on_datetime => ", new Date( event_starts_on_timestamp * 1000) );
      
    var curent_timestamp = Math.floor(new Date().getTime() / 1000);
    //console.log("curent_timestamp js => ", curent_timestamp);
    //console.log("curent_datetime => ", new Date(curent_timestamp * 1000));
      
    // this will start 30 mins before event start     
    var action_time_sec = Number("<?php echo $perform_action_before_event_time_sec; ?>"); //minutes in seconds
    //console.log("action_time_sec", action_time_sec);
      
    var delay_time_millisec = Number(2 * 60 * 1000); //2 * 60
    //console.log("delay_time_millisec", delay_time_millisec);  
      
    // second condition
    // if today is >= event day 
      
    function displayPopup() {
      if( $(".btnModalLoginForm").length){
          //alert("btnModalLoginForm trigger click 0");   
          $(".btnModalLoginForm").trigger("click");
        }
    }
    
    <?php if( $event_starts_on_timestamp > 0 && ( ( date('Y-m-d') >= $event_starts_on_date ) || ( isset( $login_required ) &&  $login_required ) ) ){ ?>  
    if( event_starts_on_timestamp > 0 ){
        var action_starts_on_timestamp = event_starts_on_timestamp - action_time_sec;
        //console.log("action_starts_on_timestamp", action_starts_on_timestamp);
        //console.log("action_starts_on_datetime => ", new Date( action_starts_on_timestamp * 1000) );
        
        var btnModalLoginFormTriggerClick = ( $.session.get("btnModalLoginFormTriggerClick") ) ? $.session.get("btnModalLoginFormTriggerClick") : 0 ;
        //console.log("btnModalLoginFormTriggerClick", btnModalLoginFormTriggerClick ); 
        
        if( ( curent_timestamp >= action_starts_on_timestamp ) || login_required == 1 ){
            if(is_logged_in_status == 0){ 
               displayPopup(); 
                
               //  show the 1st initial pop-up after some time    
               /*setTimeout(function() {
                    displayPopup();
                  }, delay_time_millisec/2);*/    
                
               setInterval(function() {
                  //alert("btnModalLoginForm click 1");    
                  displayPopup();   
                   $.session.set("btnModalLoginFormTriggerClick", 1); 
                }, ( delay_time_millisec ) ); 
            }
        }
        
        <?php if( ( date('Y-m-d') == $event_starts_on_date ) && ( $curent_timestamp <= $event_starts_on_timestamp ) ){ ?>
         setInterval(function() { 
            perform_action_on_time();
        }, (1 * 1000 ) ); // 1 sec
        <?php } ?>
    }
      
    function perform_action_on_time(){
        //console.log("perform_action_on_time");
        //console.log("is_logged_in_status", is_logged_in_status);
        
        //console.log("event_starts_on_timestamp js => ", event_starts_on_timestamp);
        //console.log("event_starts_on_datetime => ", new Date(event_starts_on_timestamp * 1000));

        var curent_timestamp = Math.floor(new Date().getTime() / 1000);
        //console.log("curent_timestamp js => ", curent_timestamp);
        //console.log("curent_datetime => ", new Date(curent_timestamp * 1000));
        
        //console.log("action_starts_on_timestamp", action_starts_on_timestamp);
        //console.log("action_starts_on_datetime => ", new Date( action_starts_on_timestamp * 1000) );
        
        var btnModalLoginFormTriggerClick = ( $.session.get("btnModalLoginFormTriggerClick") ) ? $.session.get("btnModalLoginFormTriggerClick") : 0 ;
        //console.log("btnModalLoginFormTriggerClick", btnModalLoginFormTriggerClick); 
        
        var time_diff = Math.floor( event_starts_on_timestamp - curent_timestamp);
        //console.log("time_diff => ", time_diff);
        
       if( time_diff == 2 ){ // 2 seconds
            //alert("window refresh!");
            if(is_logged_in_status == 1 ){ 
              $.alert({
                title: "Information!",
                content: "Your event is starting.",
                type: 'green',
                typeAnimated: true,
                closeIcon: true,
                closeIconClass: 'fa fa-close',
                autoClose: 'close|5000',
                buttons: {
                  close: function () {
                      window.location.reload(true);
                  }
                }
              });
            }
            else {
               $.alert({
                title: "Information!",
                content: "Your event is starting, please login.",
                type: 'green',
                typeAnimated: true,
                closeIcon: true,
                closeIconClass: 'fa fa-close',
                autoClose: 'close|5000',
                buttons: {
                  close: function () {
                      window.location.reload(true);
                  }
                }
              }); 
            }
        }
        
        if( time_diff == action_time_sec ){
           //alert("yes window reload!");
            var mins = Math.floor(action_time_sec/60); //Get remaining minutes
            
           $.alert({
                title: "Reminder!",
                content: "Your event is starting in "+ mins +" minutes, please login.",
                type: 'blue',
                typeAnimated: true,
                closeIcon: true,
                closeIconClass: 'fa fa-close',
                autoClose: 'close|5000',
                buttons: {
                  close: function () {
                      window.location.reload(true);
                      
                      /*displayPopup();
                
                       setInterval(function() {
                          //alert("btnModalLoginForm click 1");    
                          displayPopup();   
                           $.session.set("btnModalLoginFormTriggerClick", 1); 
                        }, ( delay_time_millisec ) ); */
                  }
                }
              });     
        }
        
           if( ( (curent_timestamp >= action_starts_on_timestamp) && is_logged_in_status == 0 ) ){
               //console.log("yessssss");
               if( btnModalLoginFormTriggerClick == 0){
                  displayPopup();
                
                   setInterval(function() {
                      //alert("btnModalLoginForm click 1");    
                      displayPopup();   
                       $.session.set("btnModalLoginFormTriggerClick", 1); 
                    }, ( delay_time_millisec ) ); 
               }
        }
    }
    <?php } ?>
      
    // check is user logged in  
    setInterval(function() { $().check_is_user_connected("<?php echo is_logged_in_status; ?>"); }, (5 * 1000 ) ); // 5 sec
});
</script>
<!-- End of script for Reload page on the eve of event starts on time -->