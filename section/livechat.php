<link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/chat.css" />
<div id="liveChat" style="display: <?php echo ( isset( $is_logged_in_status ) && $is_logged_in_status ) ? "block" : "none"; ?>;">
  <nav>
    <button class="logout btn btn-sm">Déconnexion <i class="fas fa-sign-out-alt"></i></button>
    <header class="nav nav-tabs" id="nav-tab" role="tablist"> <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><span>CHAT EN DIRECT <i class="fa fa-comment"></i></span></a></header>
  </nav>
  <div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
      <div class="list-group h-100">
        <div class="direct-chat-messages" id="chat-box">
          <?php /*for($i=1 ; $i<8 ; $i++){ ?>
          <!--<div class="list-group-item">
<div class="media">
  <div class="img-list"><span class="avatar fas fa-user"></span></div>
  <div class="media-body">
    <div class="username-message clearfix"><span class="direct-chat-name float-left">ChoYou</span><span class="direct-chat-timestamp float-right">10/03/2021, 04:51 PM</span></div>
    <div class="text-message">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
  </div>
</div>
</div> -->
          <?php }*/ ?>
        </div>
        <footer>
          <form name="frm_chat_message" id="frm_chat_message" method="POST" accept-charset="UTF-8" class="">
            <p>Connecté en tant que : <?php echo $nickname; ?> </p>
            <div class="form-row">
              <div class="col-10">
                <textarea id="message" name="message" placeholder="Tapez votre message" class="form-control form-control-sm" maxlength="100" rows="1" data-emojiable="true" data-emoji-input="unicode"></textarea>
              </div>
              <div class="col-2">
                <button type="submit" id="btn_submit" class="btn btn-sm"><span class="fas fa-paper-plane"></span></button>
              </div>
            </div>
          </form>
        </footer>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo SITE_URL;?>assets/js/chat.js"></script> 
<script type="text/javascript">
    var chat_file = "chat_21_04_2022.txt";
    //console.log("chat_file", chat_file);    
    if( $.trim( chat_file ) != ""){
       var chat = new Chat(chat_file);
       $( document ).ready(function() {
        //console.log("nickname", nickname);
        if( $.trim( nickname ) != ""){
           // strip tags
           nickname = nickname.replace(/(<([^>]+)>)/ig,"");
           //console.log("nickname", nickname);
        }
        
         chat.getState();
         chat.firstTimeLoadChat();
         setInterval("chat.update()", (1 * 1000 ) ); // 1 sec
        
        // Prevent the form to be submitted on ENTER
        if($('#frm_chat_message').length){
           $('#frm_chat_message').submit(function(e){
              e.preventDefault();
              //console.log("frm_chat_message submit");
              var text = $.trim( $("#message").val() );
              var maxLength = $("#message").attr("maxlength");  
              var length = text.length; 
              //console.log("length", length);

             if( length > 0){
                if (length <= maxLength + 1) { 
                    // send
                    chat.send(text, nickname);	
                    $('#message').val("");
					//$(".emoji-wysiwyg-editor").html('');
                } else {
                    $('#message').val(text.substring(0, maxLength));
					//$(".emoji-wysiwyg-editor").html(text.substring(0, maxLength)); 
                }
            }
            else {
				$.alert( {
					title: "Vous avez rencontré une erreur!",
					content: "Veuillez saisir votre message.",
					type: 'red',
					typeAnimated: true,
					closeIcon: true,
					closeIconClass: 'fa fa-close',
					autoClose: 'close|5000',
					buttons: {
						close: {
							text: "Fermer",
							action: function ( button ) {

							}
						},
					}
				} );
				
                /*$.alert({
                    title: "Encountered an error!",
                    content: "Please enter your message.",
                     type: 'red',
                     typeAnimated: true,
                     closeIcon: true,
                     closeIconClass: 'fa fa-close',
                     autoClose: 'close|5000',
                     buttons: {
                         close: function () { }
                     }
                 });*/
                }
            });
           } 
    });    
    }    
</script>