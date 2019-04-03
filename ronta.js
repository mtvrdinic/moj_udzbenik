//SKRIPTA ZA UREDIVANJE CIJENE OGLASA
//stavljanje vrijednosti u modal
$(document).ready(function(){

  $(document).on('click','.update-add',function(){
    var id = $(this).attr('id');

    //console.log(id);

    //var cijena = $('#'+id).children('b[data-target=cijena]').text();
    var cijena = $('#cijenaod' + id).text();
    //alert(cijena);
    $('#cijena').val(cijena);
    $('#idAdd').val(id); 
    $('#myModal').modal('toggle');
  });

  //event za stavljanje vrijednosti iz input fields(modala) u bazu
  $('#save').click(function(){
    var idAdd = $('#idAdd').val();
    var novaCijena = $('#cijena').val();

    $.ajax({
      url    : 'includes/change-ad.inc.php',
      method : 'post',
      data   : {
                  novaCijena: novaCijena,
                  idAdd : idAdd
                },
      success : function(){
              //updejtanje samog html na stranici
              $('#cijenaod'+idAdd).text(novaCijena);
              $('#myModal').modal('toggle');

              }
      });
  });
});


//SKRIPTA ZA ISPISIVANJE DESNOG CHATA
$(document).ready(function(){
$('.forMess').click(function(){
    var id = $(this).attr('id');
    var idneki = $(this).attr('name');
    $('#'+id).removeClass('active_chat');
    //var novo = $('#'+id).find('class');
    //console.log(novo);
    //$('#'+id).find('.active_chat').removeClass('active_chat');
    //$('.active_chat').removeClass('active_chat');

$.ajax({
  url    : 'includes/chat.inc.php',
  method : 'post',
  data   : {
              idChat: id,
              idneki : idneki
            },
  success : function(data){

          //updejtanje samog html na strani
          $('#sveporuke').html(data);

          var updateMess = $('#chatMess').val();
          //console.log(smanji_poruke);
          $('#brojneprocitanih').text(updateMess);
          }
  });

});
})

//SKRIPTA ZA SLANJE PORUKE
$(document).ready(function(){

  $('#send-message').click(function(){
    var idChat = $('#idchat').val();
    var contentMess = $('#message').val();
    var id2 = $('#id2').val();
    var dt = new Date();
    var time = dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate() + " " + 
    dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
    $('#'+idChat).find('.lastMess').text(contentMess);
    $('#'+idChat).find('.lastMessTime').text(time);

    //alert(idChat);
    $.ajax({
      url    : 'includes/send.inc.php',
      method : 'post',
      data   : {
                  idChat: idChat,
                  id2: id2,
                  contentMess : contentMess
                },
      success : function(data){
              //console.log(data);
              //updejtanje samog html na stranici
              $('#sveporuke').html(data);
              $('#message').val("");
              }
      });
      
  });
});

//SKRIPTA ZA MODUL SLANJE PORUKE
  $(document).ready(function(){

        $(document).on('click','.send_msg_to_user',function(){
        var id2 = $(this).attr('id');

        //$('#samaPoruka').val(id2);
        $('#idkorisnika').val(id2);
        $('#sendMessage').modal('toggle');

        });
            $('#posalji').click(function(){
            var id2 = $('#idkorisnika').val();
            var contentPoruke = $('#samaPoruka').val();

            $.ajax({
              url    : 'includes/sendMess_via_module.inc.php',
              method : 'post',
              data   : {
                          contentPoruke: contentPoruke,
                          id2 : id2
                        },
              success : function(){
                      //updejtanje samog html na stranici
                      //console.log("proslo");
                      $('#sendMessage').modal('toggle');

                      }
              });
            });

    });

//KRIPTA ZA ISPISIVANJE BROJA AKTIVNIH OGLASA
$(document).ready(function(){
    var broj_aktivnih = $("#broja").val();

    if(!broj_aktivnih){
      $("#aktivni_oglasi").text(" Aktivni oglasi");  
    }
    else{
      $("#aktivni_oglasi").text(" Aktivni oglasi: "+ broj_aktivnih);
    }
});
//SKRIPTA ZA ISPISIVANJE BROJA PRODANIH OGLASA
$(document).ready(function(){
    var broj_prodanih = $("#brojp").val();

    if(!broj_prodanih){        
      $("#prodani_oglasi").text(" Prodani oglasi");
    }
    else{
      $("#prodani_oglasi").text(" Prodani oglasi: "+ broj_prodanih);
    }

});
// SKRIPTA ZA ISPISIVANJE BROJA KUPLJENI OGLASA 
$(document).ready(function(){
    var broj_kupljenih = $("#brojb").val();

    if(!broj_kupljenih){        
      $("#kupljeni_oglasi").text(" Kupljeni oglasi");
    }
    else{
      $("#kupljeni_oglasi").text(" Kupljeni oglasi: "+ broj_kupljenih);
    }

});
// NOTIFIKACIJA KOD NECHEKIRANIH OGLASA
$(document).ready(function(){
    var broj_necheck = $("#neCheckirani").val();
    //console.log(broj_necheck);
    if(broj_necheck == '0' || broj_necheck == undefined){        
    }else{
      $("#prodani_oglasi").append(" <i class='fas fa-bell' style='color:#BB4349'></i>");
      $("#oglas").append(" <i class='fas fa-bell'></i><span class='badge badge-pill badge-notify pulsate-bck' style='font-size:10px'>"+broj_necheck+"</span>");
    }

});

//NOTIFIKACIJE PORUKA
$(document).ready(function(){
    var broj_unread = $("#unreadMess").val();
    if(broj_unread == '0' || broj_unread == undefined){        
    }else{
      
      $("#poruke").append("<span id='brojneprocitanih' class='badge badge-pill badge-notify-mess pulsate-bck' style='font-size:10px'>"+broj_unread+"</span>");
    }

});

//ZA CHECKIRANJE OGLASA
$(document).ready(function(){
    $(document).on('click','#checked_button',function(){
        var id = $(this).val();
        $("#idoglas").val(id);
        var idAd = $("#idoglas").val();

        $.ajax({
          url    : 'includes/check-ad.inc.php',
          method : 'post',
          data   : {
                        idAd : idAd
                    },
          success : function(){
            
            $('[name="checked' + idAd + '"]').removeClass( "btn-outline-danger" ).addClass("btn-success");
            $('[name="checked' + idAd + '"]').html("Isporučeno <i class='fas fa-check'></i>");
            }
      });


    });
});

//SKRIPTA ZA SHOW MORE ADDS (pretraga po školama)
$(document).ready(function(){
  var adCount = 0;
  $(".plus").click(function(){
    //dohvacanje id knjige spremanje ga u value i opet dohvacanje
    var idknjige = $(this).attr('id');
    $("#book"+idknjige).val(idknjige);
    var idbook = $("#book"+idknjige).val();

    //dohvacanje limita
    var limit = $("#limit"+idbook).val();
    if(limit === undefined){
      adCount = 0;
    }
    adCount +=7;
    
    /*$("#show-more"+idbook).load("load-ads.php", {
      newAdCount: adCount,
      idBooks: idbook
    });*/
    $.ajax({
      url: "includes/load-ads.inc.php",
      method: "POST",
      data: {
              newAdCount: adCount,
              idBooks: idbook
            },
      success: function(data){
        if(data === "<b>Nema više dostupnih oglasa :(<b>"){
          $("#"+idbook).hide();
        }
        $("#show-more"+idbook).append(data);
      }      
    })

  });
});
