<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" /> -->
<link rel="stylesheet" href="./resources/css/chat.css" />
<div class="contain">
  <div class="message-header">
    <!-- <div class="message-header-img">
      <img src="./includes/dp.jpg" alt="Placeholder for User DP" />
    </div> -->
    <div class="activeago">
      <h4>GROUP</h4>
      <!-- <h6>1 hour ago...</h6> -->
    </div>
    <!-- <div class="header-icon">
      <i class="fas fa-info-circle"></i>
    </div> -->
  </div>
  <div class="chatPage">
    <div class="chatBox">
      <div class="chat">
        <div id="chatSkin">
          <!-- <div class="recievedChat">
            <div class="recievedChatImg">
              <img src="./includes/dp.jpg" alt="" />
            </div>
            <div class="recievedMessage">
              <div class="recievedMessageInbox">
                <p>Test Message from BackEnd</p>
                <span class="timeStamp">04:32 | July 22</span>
              </div>
            </div>
          </div> -->

          <!-- <div class="sentChat">
            <div class="sentChatImg">
              <img src="./includes/dp2.jpg" alt="" />
            </div>
            <div class="sentMessage">
              <div class="sentMessageInbox">
              <p>Test Message from BackEnd via sent</p>
              <span class="timeStamp">04:32 | July 22</span>
              </div>
            </div>
          </div> -->





        </div>
      </div>
    </div>
  </div>
  <div class="chatFooter">
    <!-- <div class="chatFooterIcons">
           I have left some space for icons, but I think
          I won't need'em 
        SHITENDU MISHRA
        </div> -->
    <div class="chatFooterInput">
      <input type="text" id="message" class="ChatFooterInputMessage" placeholder="Type here!" />
      <div class="chatFooterInputMessageAppend">
        <span class="inputText btn" id="sent">
          <i class="fas fa-paper-plane"></i>
        </span>
      </div>
    </div>
  </div>
</div>
<?php $user=$_SESSION['login_name']?>


<script>
  setInterval(fetchMess, 1000);
  var roomlocal=localStorage.getItem('room');
  function showroom(){
    var activeago=$('.activeago>h4').html(roomlocal)
  }
  showroom()
  function fetchMess() {
    let room = window.localStorage.getItem("room");
    $.ajax({
      url: '/workstation/includes/actionDispatcher.php?action=fetch_message',
      method: 'POST',
      data: ({ room: room, user: '<?php echo $user ?>' }),
      success: function (data) {
        if (data) {
          $("#chatSkin").html(data);
        }
      }
    })
  }


  $(document).ready(function () {
    fetchMess()
    $('.create_room').click(function (e) {
      e.preventDefault();
      var room = $('#roomname').val();
      $.ajax({
        url: 'ajax.php?action=create_room',
        method: 'POST',
        data: { room: room },
        success: function (data) {
          console.log(data);
          if (data) {
            alert_toast(data);

            setTimeout(function () {

            }, 1500)
          }
        }
      })
    });
    $('.join_room').click(function (e) {
      e.preventDefault();
      var room = $('#roomname').val();
      window.localStorage.setItem("room", room)
    });
    $('#sent').click(function (e) {
      e.preventDefault();
      var message = $('#message').val();
      var room = window.localStorage.getItem("room");
      if (message.length) {

        $.ajax({
          url: '/workstation/includes/actionDispatcher.php?action=message',
          method: 'POST',
          data: ({ room: room, message: message, user: '<?php echo $user ?>' }),
          success: function (data) {
            if (data) {
              alert_toast(data);
              setTimeout(function () {
              }, 1500)
            }
          }
        })


      }

      $(".anyclass").animate({ scrollTop: 1000000 }, 800);
      $('#message').val("");
    });
  });

  var input = document.getElementById("message");

  // Execute a function when the user releases a key on the keyboard
  input.addEventListener("keydown", function (event) {
    // Number 13 is the "Enter" key on the keyboard
    if (event.keyCode === 13) {
      // Cancel the default action, if needed
      event.preventDefault();
      // Trigger the button element with a click
      document.getElementById("sent").click();
    }
  });
  var input = document.getElementById("roomJoin");

  // Execute a function when the user releases a key on the keyboard
  input.addEventListener("keydown", function (event) {
    // Number 13 is the "Enter" key on the keyboard
    if (event.keyCode === 13) {
      // Cancel the default action, if needed
      //event.preventDefault();
      console.log('romjoin')
      // Trigger the button element with a click
      var room = $('#roomJoin').val();
      var activeago=$('.activeago>h4').html(room)
      window.localStorage.setItem("room", room)
    }
  });
  var input = document.getElementById("roomCreate");

  // Execute a function when the user releases a key on the keyboard
  input.addEventListener("keydown", function (event) {
    // Number 13 is the "Enter" key on the keyboard
    if (event.keyCode === 13) {
      // Cancel the default action, if needed
      //event.preventDefault();
      // Trigger the button element with a click
      var room = $('#roomCreate').val();
      $.ajax({
        url: '/workstation/includes/actionDispatcher.php?action=create_room',
        method: 'POST',
        data: { room: room },
        success: function (data) {
          console.log(data);
          if (data) {
            alert_toast(data);

            setTimeout(function () {

            }, 1500)
          }
        }
      })
    }
  });

</script>