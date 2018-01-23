(function($){

  var interval = setInterval(refreshMsg, 500);
  function refreshMsg(){
    $.post(
      'refresh_msg.php',
      {
        id_channel: $('#form-chat').data('id-channel'),
        id_msg: $('.message').last().data('id-msg')
      },
      function(response){
        if($('#no-msg').length && response){
          $('#no-msg').hide();
        }
        $('#separator').before(response);
      },
      'JSON'
    );
  }

})(jQuery);
