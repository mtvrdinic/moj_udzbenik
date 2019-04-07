// Scipt used to find SCHOOLS afer inputting partial string    
$(document).ready(function(){

    $('#schoolsearch').keyup(function() {
        var query = $(this).val();
            
        if(query != ''){
            $.ajax({
                url: "includes/school.inc.php",
                method: "GET",
                data: {query:query},
                success: function(data){
                    $('#schoolList').fadeIn();
                    $('#schoolList').html(data);
                }
            })
        }
        else{
            $('#schoolList').fadeOut();
            $('#schoolList').html("");
        }
    });
        
    $(document).on('click', 'li', function(){
        $('#schoolsearch').val($(this).text());
        $('#schoolsearch').popover('hide');
    });
});
    

// Scipt used to find SCHOOLS afer choosing region
$(document).ready(function(){

    $("#regionpicker").change(function(){ 

        var regionpicker = $(this).val();
        var dataString = "regionpicker="+regionpicker;

        $.ajax({ 
            type: "POST", 
            url: "includes/region-school.inc.php", 
            data: dataString,
            success: function(result){ 
                //console.log(result);
                $("#regionSchoolList").html(result);
            }
        });

    });
});

$(document).ready(function(){
    $.ajax({ 
        type: "POST", 
        url: "includes/region-school.inc.php", 
        data: "regionpicker=Zagrebačka",
        success: function(result){ 
            $("#regionSchoolList").html(result);
        }
    });           
});


// Scipt used to find BOOKS afer inputting partial string 
$(document).ready(function(){

    $('#booksearch').keyup(function() {
        var query = $(this).val();
            
        if(query != ''){
            $.ajax({
                url: "includes/book.inc.php",
                method: "GET",
                data: {query:query},
                success: function(data){
                    $('#bookList').fadeIn();
                    $('#bookList').html(data);
                }
            })
        }
        else{
            $('#bookList').fadeOut();
            $('#bookList').html("");
        }
    });
        
    $(document).on('click', '.book-li', function(){
        $('#booksearch').val($(this).text());
        $('#booksearch').popover('hide');
    });
});
    


// Scipt used to ENABLE POPOVERS wooohooo
$(function () {
    $('[data-toggle="popover"]').popover()
})
    

// Scipt used to DISMISS SUCCESS POPOVER
$("#succalert").fadeTo(2000, 500).slideUp(500, function(){
    $("#succalert").slideUp(500);
});
    

// Scipt used to ENABLE TOOLTIPS
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

// Scipt used to stop dropdown from closing uppon toggle
$('.dropdown-menu').click(function(e) {
    e.stopPropagation();
});

// Scipt used to hide certain element
function checkboxToggle(element){
    var x = document.getElementById(element.name);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}     

// Scipt used to focus success msg after new add input DOES NOT WORK
$(document).ready(function(){
     $("#succalert").focus();
});

// Generating img src for signup avatar, SUPER COOL!
$(document).ready(function(){
    if(window.location.href.indexOf("signup") > -1){
        var tmpSrc = generateAvatar();
        document.getElementById("signup-avatar").src = tmpSrc;
        document.getElementById("signup-avatar-value").value = tmpSrc;
    }
});

$(document).on('click', '#signup-avatar', function(){
    var tmpSrc = generateAvatar();
    document.getElementById("signup-avatar").src = tmpSrc;
    document.getElementById("signup-avatar-value").value = tmpSrc;
});

function generateAvatar(){
            var topType = [     "NoHair",
                                "Eyepatch",
                                "Hat",
                                "Hijab",
                                "Turban",
                                "WinterHat1",
                                "WinterHat2",
                                "WinterHat3",
                                "WinterHat4",
                                "LongHairBigHair",
                                "LongHairBob",
                                "LongHairBun",
                                "LongHairCurly",
                                "LongHairCurvy",
                                "LongHairDreads",
                                "LongHairFrida",
                                "LongHairFro",
                                "LongHairFroBand",
                                "LongHairNotTooLong",
                                "LongHairShavedSides",
                                "LongHairMiaWallace",
                                "LongHairStraight",
                                "LongHairStraight2",
                                "LongHairStraightStrand",
                                "ShortHairDreads01",
                                "ShortHairDreads02",
                                "ShortHairFrizzle",
                                "ShortHairShaggyMullet",
                                "ShortHairShortCurly",
                                "ShortHairShortFlat",
                                "ShortHairShortRound",
                                "ShortHairShortWaved",
                                "ShortHairSides",
                                "ShortHairTheCaesar",
                                "ShortHairTheCaesarSidePart"
                                ];

            var accessoriesType = [     "Blank",
                                        "Kurt",
                                        "Prescription01",
                                        "Prescription02",
                                        "Round",
                                        "Sunglasses",
                                        "Wayfarers"
                                        ];

            var hairColor = [       "Auburn",
                                    "Black",
                                    "Blonde",
                                    "BlondeGolden",
                                    "Brown",
                                    "BrownDark",
                                    "PastelPink",
                                    "Platinum",
                                    "Red",
                                    "SilverGray"
                                    ];

            var facialHairType = [      "Blank",
                                        "BeardMedium",
                                        "BeardLight",
                                        "BeardMagestic",
                                        "MoustacheFancy",
                                        "MoustacheMagnum"
                                        ];

            var clotheType = [      "BlazerShirt",
                                    "BlazerSweater",
                                    "CollarSweater",
                                    "GraphicShirt",
                                    "Hoodie",
                                    "Overall",
                                    "ShirtCrewNeck",
                                    "ShirtScoopNeck",
                                    "ShirtVNeck"
                                    ];

            var eyeType = [         "Close",
                                    "Cry",
                                    "Default",
                                    "Dizzy",
                                    "EyeRoll",
                                    "Happy",
                                    "Hearts",
                                    "Side",
                                    "Squint",
                                    "Surprised",
                                    "Wink"
                                    ];

            var eyebrowType = [         "Angry",
                                        "AngryNatural",
                                        "Default",
                                        "DefaultNatural",
                                        "FlatNatural",
                                        "RaisedExcited",
                                        "RaisedExcitedNatural",
                                        "SadConcerned",
                                        "SadConcernedNatural",
                                        "UnibrowNatural",
                                        "UpDown"
                                    ];

            var mouthType = [       "Concerned",
                                    "Default",
                                    "Disbelief",
                                    "Eating",
                                    "Grimace",
                                    "Sad",
                                    "ScreamOpen",
                                    "Serious",
                                    "Smile",
                                    "Tongue",
                                    "Twinkle"
                                    ];

            var skinColor = [       "Tanned",
                                    "Yellow",
                                    "Pale",
                                    "Light",
                                    "Brown",
                                    "DarkBrown",
                                    "Black"
                                    ];

            var urlString = 'https://avataaars.io/png?avatarStyle=Circle';

            //adding top
            var tmpSelection = topType[Math.floor(Math.random() * (topType.length - 1))];
            urlString += '&' + 'topType=' + tmpSelection;

            //adding accessories
            urlString += '&' + 'accessoriesType=' + accessoriesType[Math.floor(Math.random() * (accessoriesType.length - 1))];

            //adding hair color
            urlString += '&' + 'hairColor=' + hairColor[Math.floor(Math.random() * (hairColor.length - 1))];

            //adding facialHairType
            urlString += '&' + 'facialHairType=' + facialHairType[Math.floor(Math.random() * (facialHairType.length - 1))];

            //adding clotheType
            urlString += '&' + 'clotheType=' + clotheType[Math.floor(Math.random() * (clotheType.length - 1))];

            //adding eyeType
            urlString += '&' + 'eyeType=' + eyeType[Math.floor(Math.random() * (eyeType.length - 1))];

            //adding eyebrowType
            urlString += '&' + 'eyebrowType=' + eyebrowType[Math.floor(Math.random() * (eyebrowType.length - 1))];

            //adding mouthType
            urlString += '&' + 'mouthType=' + mouthType[Math.floor(Math.random() * (mouthType.length - 1))];

            //adding skinColor
            urlString += '&' + 'skinColor=' + skinColor[Math.floor(Math.random() * (skinColor.length - 1))];

            return urlString;
}

//If profile / ad was deleted successfully, the modal will show
$(window).on('load', function() {
    $('#profile-delete-success-modal').modal('show');
    $('#ad-delete-success-modal').modal('show');
});

// Show/hide ads with pictures on toggle    
$(document).ready(function(){
    $(document).on('change', '#filter-picture', function img_find() {

        var imgs = document.getElementsByTagName("img");
        var demoImg = "http://localhost/web_project/img/book_icon_add.png";
            
        for(var i = 0; i < imgs.length; i++) {
            if(imgs[i].src == demoImg){

                //to get a [ADDED AFTER ADDING MODALS FOR IMAGES]
                var parent = imgs[i].parentElement;

                //to get span
                parent = parent.parentElement;

                //to get div
                parent = parent.parentElement;

                //to get li
                parent = parent.parentElement;

                if (parent.style.display === "none") {
                    parent.style.display = "block";
                } 
                else {
                    parent.style.display = "none";
                }
            }
        }             
    });
});

//Show/hide ads with region on select  
$(document).ready(function(){
    $(document).on('change', '#region-filter-select', function () {
        var select = document.getElementById("region-filter-select").value;                

        //array of regions in ads
        var ads = document.getElementsByClassName('list-ad-region');

        for(var i = 0; i < ads.length; i++) {

            //to get span
            var parent = ads[i].parentElement;

            //to get div
            parent = parent.parentElement;

            //to get li
            parent = parent.parentElement;
            
            if(select == ''){
                parent.style.display = "block";
            }
            else if(ads[i].innerHTML != select){
                parent.style.display = "none";
            }
            else {
                parent.style.display = "block";
            }                    
        }         
    });
});

//Add ADS to CART
function addToCart(element){
    var idAd = element.previousElementSibling.value;
    var nameBooks = element.previousElementSibling.previousElementSibling.value;
    var priceAd = element.previousElementSibling.previousElementSibling.previousElementSibling.value;
    var uidUsers = element.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.value;

    $.ajax({
      url    : 'includes/update-cart.inc.php',
      method : 'post',
      data   : {
                  idAd : idAd,
                  nameBooks: nameBooks,
                  priceAd: priceAd,
                  uidUsers: uidUsers
                },
      success : function(data){                  
                    //console.log(data);
                    $('#selected-ads').html(data);
                }
      });
}

//Remove AD from CART
function removeFromCart(element){
    var idAd = element.previousElementSibling.children[0].value;
    console.log(idAd);
    $.ajax({
      url    : 'includes/remove-from-cart.inc.php',
      method : 'post',
      data   : {
                  idAd : idAd
                },
      success : function(data){                  
                    //console.log(data);
                    $('#selected-ads').html(data);
                }
      });
}

//Populate CART on load
function showCart(){

    //to show all ads on load we mock removing by seding idAd = 0, script will just return session ads
    var idAd = 'mock';

    $.ajax({
      url    : 'includes/remove-from-cart.inc.php',
      method : 'post',
      data   : {
                  idAd : idAd
                },
      success : function(data){
                    $('#selected-ads').html(data);
                }
      });
}
document.onload = showCart();

//Remove from cart on CHECKOUT
function removeFromCartCheckout(element){
    var idAd = element.previousElementSibling.value;
    console.log(idAd);

    $.ajax({
      url    : 'includes/remove-from-cart.inc.php',
      method : 'post',
      data   : {
                  idAd : idAd
                },
      success : function(data){ 
                    location.reload();
                }
      });
}


//Rating
$(document).ready(function(){    
    $(document).on('click', '#modal-rate', function(){
        var idoglasa = $(this).attr('name');
        $('#oglasid').val(idoglasa);
        //console.log(idoglasa);
    });

    $('#rate-submit').click(function(){
        var ocijena = 0;

        var elem = $('#star-1');
        if (elem .is(":checked")){
            ocijena =  1;
        }        
        var elem = $('#star-2');
        if (elem .is(":checked")){
            ocijena =  2;
        }
        var elem = $('#star-3');
        if (elem .is(":checked")){
            ocijena =  3;
        }
        var elem = $('#star-4');
        if (elem .is(":checked")){
            ocijena =  4;
        }
        var elem = $('#star-5');
        if (elem .is(":checked")){
            ocijena =  5;
        }

        var idoglasa = $('#oglasid').val();

        $.ajax({
            url    : 'includes/rate-user.inc.php',
            method : 'post',
            data   : {
                          ocijena: ocijena,
                          idAdd : idoglasa
                        },
            success : function(){
                        //disable button
                        var tmp = $('[name="' + idoglasa + '"]').addClass('sr-only');
                      }
          });

    });
})

//Eth transaction verify
$(document).ready(function(){
    $(document).on('click', '#eth-submit', function(){
        var ethAddress = $(this).prev().val();

        //creating spinner and appending it
        var spinner =   '<div class="spinner-border ml-2" role="status" style="width: 2rem; height: 2rem;" id="spinner-wait"><span class="sr-only">Loading...</span></div>';
        $(this).append(spinner);


        $.ajax({
            url     :   'includes/checkout-eth.inc.php',
            method  :   'post',
            data    :   {
                            ethAddress: ethAddress                        
                        },
            success :   function(data){                           
                            if(data == '1') {
                                //transaction verified
                                //removing spinner and appending submit
                                $('#spinner-wait').addClass('sr-only');
                                $('#eth-submit').addClass('sr-only');

                                var button = '<form action="includes/checkout-finalise.inc.php" method="post"><button type="submit" name="checkout-submit" class="btn btn-lg btn-success mt-4" title="Klikni za nastavak">Potvrđeno <i class="fas fa-check"></i></button></form>';
                                $('#eth-submit').after(button);
                            }
                            else {
                                console.log('fail');

                                //transaction failed
                                //removing spinner and appending button
                                $('#spinner-wait').addClass('sr-only');
                                $('#eth-submit').addClass('sr-only');

                                var button = '<button disabled type="button" class="btn btn-lg btn-secondary mt-4">Kupovina neuspješna <i class="fas fa-times"></i></button>';
                                $('#eth-submit').after(button);
                            }
                        }
        })
    })
})


//Ad image modals
$(".image-modal").on("click", function() {
   $('#modalForImages-body').attr('src', $(this).children().attr('src')); // here asign the image to the modal when the user click the enlarge link
});


//Signup errors
$(document).ready(function(){
    if(document.URL.indexOf("signup.php?error=taken") >= 0){ 
        alert("Registracija nije uspjela, email ili oib se već koriste.");
    }

    if(document.URL.indexOf("signup.php?error=sqlerror") >= 0){
        alert("Registracije nije uspjela, grška s bazom podataka.");
    }

    if(document.URL.indexOf("signup.php?error=usernametaken") >= 0){
        alert("Registracije nije uspjela, korisničko ime se već koristi.");
    }

    if(window.location.href.indexOf("error") > -1) {
       alert("Registracije nije uspjela.");
    }
});


// Validations
$(document).ready(function(){

    // Require them all
    if(window.location.href.indexOf("signup") > -1){
        document.getElementById("username-input").required = true;
        document.getElementById("email-input").required = true;
        document.getElementById("oib-input").required = true;
    }

    // Username
    $('#username-input').focusout(function() {
        var input = $(this);
        var query = $(this).val();
            
        if(query != ''){
            $.ajax({
                url: "includes/valitade-username.inc.php",
                method: "GET",
                data: {query:query},
                success:    function(data){
                                if(data == 1){
                                    input.addClass('is-invalid');
                                    $('#signup-submit-button').attr('disabled', true);
                                    $('#usernameError').attr('hidden', false);
                                }
                                else {
                                    input.removeClass('is-invalid');
                                    $('#signup-submit-button').attr('disabled', false);
                                    $('#usernameError').attr('hidden', true);
                                }
                            }
            })
        }        
    });


    // Email
    $('#email-input').focusout(function() {
        var input = $(this);
        var query = $(this).val();
            
        if(query != ''){
            $.ajax({
                url: "includes/validate-email.inc.php",
                method: "GET",
                data: {query:query},
                success:    function(data){
                                if(data == 1){
                                    input.addClass('is-invalid');
                                    $('#signup-submit-button').attr('disabled', true);
                                    $('#emailError').attr('hidden', false);
                                }
                                else {
                                    input.removeClass('is-invalid');
                                    $('#signup-submit-button').attr('disabled', false);
                                    $('#emailError').attr('hidden', true);
                                }
                            }
            })
        }        
    }); 

    // Oib
    $('#oib-input').focusout(function() {
        var input = $(this);
        var query = $(this).val();
        
        // Calculating control num
        var sum = 10;
        for(var i = 0; i < 10; i++) {
            sum += parseInt(query[i]);
            sum %= 10;
            if(sum == 0) sum = 10;
            sum *= 2;
            sum %= 11;          
        }
        sum = 11 - sum;
        if(sum == 10) sum = 0;

        if(sum != parseInt(query[10]) || query[11] != undefined){
            input.addClass('is-invalid');
            $('#signup-submit-button').attr('disabled', true);
            $('#oibError').attr('hidden', false);
        }
        else {
            input.removeClass('is-invalid');
            $('#signup-submit-button').attr('disabled', false);
            $('#oibError').attr('hidden', true);
        }
       
    });    

});
