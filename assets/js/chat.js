/* 
Created by: Kenrick Beckett

Name: Chat Engine
*/

var instance = false;
var state;
var mes;
var file;
var chat_div = "chat-box";

function Chat(txtfile) {
  file = txtfile;
  this.update = updateChat;
  this.send = sendChat;
  this.getState = getStateOfChat;
  this.firstTimeLoadChat = firstTimeLoadChat;
}

//gets the state of the chat
function getStateOfChat() {
  if (!instance) {
    instance = true;
    $.ajax({
      type: "POST",
      url: "ajax.php",
      data: {
        'function': 'getState',
        'file': file
      },
      dataType: "json",
      cache: false,
      success: function (data) {
        state = data.state;
        instance = false;
      },
    });
  }
}

//Updates the chat
function updateChat() {
  if (!instance) {
    instance = true;
    $.ajax({
      type: "POST",
      url: "ajax.php",
      data: {
        'function': 'update',
        'state': state,
        'file': file
      },
      dataType: "json",
      cache: false,
      success: function (data) {
        //console.log(data);  
        if (data.text) {
          var $str = "";
          for (var i = 0; i < data.text.length; i++) {
            //console.log(data.text[i]);  
            //$('#chat').append($("<p>" + data.text[i] + "</p>"));

            $str = '<div class="list-group-item"><div class="media"><div class="img-list"><span class="avatar fas fa-user"></span></div><div class="media-body">' + data.text[i] + '</div></div></div>';

            console.log("updateChat str", $str);  
            $("#" + chat_div).append($($str));
          }
        }
        //document.getElementById(chat_div).scrollTop = document.getElementById(chat_div).scrollHeight;
        instance = false;
        state = data.state;
      },
    });
  } else {
    setTimeout(updateChat, 1000);
  }
}

function firstTimeLoadChat() {
  if (!instance) {
    //console.log("firstTimeLoadChat");
    instance = true;
    $.ajax({
      type: "POST",
      url: "ajax.php",
      data: {
        'function': 'firstTimeLoadChat',
        'state': state,
        'file': file
      },
      dataType: "json",
      cache: false,
      beforeSend: function (xhr, settings) {
        $("#" + chat_div).showLoading();
      },    
      success: function (data) {
         $("#" + chat_div).hideLoading();
        if (data.text) {
          $("#" + chat_div).html("");
            
          var $str = "";
          for (var i = 0; i < data.text.length; i++) {
            //console.log(data.text[i]);  
            //$('#chat').append($("<p>" + data.text[i] + "</p>"));

            //$str = '<div class="row chat-item"><div class="col-1"><span class="avatar fas fa-user"></span></div><div class="col-11">' + data.text[i] + '</div></div>';

            $str = '<div class="list-group-item"><div class="media"><div class="img-list"><span class="avatar fas fa-user"></span></div><div class="media-body">' + data.text[i] + '</div></div></div>';

            //console.log("firstTimeLoadChat str", $str);  
            $("#" + chat_div).append($str);
          }
        }
        document.getElementById(chat_div).scrollTop = document.getElementById(chat_div).scrollHeight;
        instance = false;
        state = data.state;
      },
    });
  } else {
    setTimeout(firstTimeLoadChat, 1000);
  }
}

//send the message
function sendChat(message, nickname) {
  updateChat();

  $.ajax({
    type: "POST",
    url: "ajax.php",
    data: {
      'function': 'send',
      'message': message,
      'nickname': nickname,
      'file': file
    },
    dataType: "json",
    cache: false,
    success: function (data) {
      updateChat();
    },
  });
}
