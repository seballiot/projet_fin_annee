(function($){

  // HOVER STARS POST
  $('#stars li').on('mouseover', function(){
    var valueStar = parseInt($(this).data('value'), 10); // valeur étoile du hover
    $(this).parent().children('li.star').each(function(e){ // parse toutes les étoiles
      if (e < valueStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });

  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });


  // CLICK STARS POST
  $('#stars li').on('click', function(){
    var valueStar = $(this).data('value'); // nouvelle valeur nb étoile
    var stars = $(this).parent().children('li.star'); // toutes les étoiles

    $.post(
    'like.php',
    {
      id_post: $(this).parent().data('id_post'),
      vote: valueStar
    },
    function(response){
      console.log(response);
      if(response.code != 0){
        if(response.code == 1){
          $('#rep_msg').text('Votre changement de vote a bien été pris en compte').fadeIn().delay(2000).fadeOut();
        }
        else{
          $('#rep_msg').text('Merci d\'avoir voté ').fadeIn().delay(2000).fadeOut();
          $('#count_vote').text(response.count_vote);
        }
        $('#rating').text(response.rating);
        // on retire toutes les classes 'selected'
        for (i = 0; i < stars.length; i++) {
          $(stars[i]).removeClass('selected');
        }
        // on met la classe 'selected' sur toutes les étoiles en dessous de la note moyenne
        for (i = 0; i < Math.floor(response.rating); i++) {
          $(stars[i]).addClass('selected');
        }
      }
    },
    'JSON');
  });

  // SEND REPLY COMMENT
  $('.reply').click(function(e){
    e.preventDefault();
    var $form = $('#form-comment');
    var id_parent = $(this).data('id');
    var $comment = $('#comment-'+id_parent);

    $('#comment_content').attr("placeholder", "Rédigez votre réponse");
    $('#id_parent').val(id_parent);
    $comment.after($form);
  });


  // SEND MESSAGE CHAT
  $('#form-chat').submit(function(e){
    e.preventDefault();
    $.post(
      'send_message.php',
      {
        id_channel: $(this).data('id-channel'),
        id_msg: $('.message').last().data('id-msg'),
        message: $('#chat-message').val()
      },
      function(response){
        $('#no-msg').hide();
        $('#separator').before(response);
        $('#form-chat')[0].reset();
      },
      'JSON'
    );
  });

})(jQuery);
