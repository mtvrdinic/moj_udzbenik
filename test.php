<?php
    

//SELECT imageAdd, phoneNumUsers, regionUsers, adds.*, nameBooks, authorsBooks, subjectLink FROM grade JOIN school USING (idSchool) JOIN link USING (idGrade) JOIN books USING (idBooks) JOIN adds USING (idBooks) JOIN users USING (uidUsers) LEFT JOIN img USING (idAdd) WHERE nameSchool='OSNOVNA ŠKOLA JOSIPA ZORIĆA' AND numGrade=2




require "header.php";

echo '<main>';

{
    $prilagodi =    '
                    <div class="container col-lg-5 text-center my-1">           
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Prilagodi pretragu
                        </button>           
                        
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <div>
                                    <div class="d-flex flex-column">
                                        <select class="custom-select my-1 mr-sm-2 text-center" id="region-filter-select">
                                            <option value="" selected>Sve županije</option>
                                            <option value="Zagrebačka">Zagrebačka</option>
                                            <option value="Krapinsko-zagorska">Krapinsko-zagorska</option>
                                            <option value="Sisačko-moslavačka">Sisačko-moslavačka</option>
                                            <option value="Karlovačka">Karlovačka</option>
                                            <option value="Varaždinska">Varaždinska</option>
                                            <option value="Koprivničko-križevačka">Koprivničko-križevačka</option>
                                            <option value="Bjelovarsko-bilogorska">Bjelovarsko-bilogorska</option>
                                            <option value="Primorsko-goranska">Primorsko-goranska</option>
                                            <option value="Ličko-senjska">Ličko-senjska</option>
                                            <option value="Virovitičko-podravska">Virovitičko-podravska</option>
                                            <option value="Požeško-slavonska">Požeško-slavonska</option>
                                            <option value="Brodsko-posavska">Brodsko-posavska</option>
                                            <option value="Zadarska">Zadarska</option>
                                            <option value="Osječko-baranjska">Osječko-baranjska</option>
                                            <option value="Šibensko-kninska">Šibensko-kninska</option>
                                            <option value="Vukovarsko-srijemska">Vukovarsko-srijemska</option>
                                            <option value="Splitsko-dalmatinska">Splitsko-dalmatinska</option>
                                            <option value="Istarska">Istarska</option>
                                            <option value="Dubrovačko-neretvanska">Dubrovačko-neretvanska</option>
                                            <option value="Međimurska">Međimurska</option>
                                            <option value="Grad Zagreb">Grad Zagreb</option>
                                        </select>
                                    </div>                    

                                    <div class="btn-group btn-group-toggle mt-1" data-toggle="buttons" id="filter-picture">
                                        <label class="btn btn-secondary active">
                                            <input type="radio" name="options" id="filter-picture-all" autocomplete="off" checked> Svi oglasi
                                        </label>
                                        <label class="btn btn-secondary mr-sm-2">
                                            <input type="radio" name="options" id="filter-picture-only" autocomplete="off"> Oglasi sa slikom    
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
}

//check if the users actually clicked the SUBMIT button - school search
if (isset($_GET['schoolsearch-submit'])) {

    //run the connection to DATABASE
    require 'includes/dbh.inc.php';   //now we got access to variable CONN - connection to the database

    //we want Č Ć Š Ž and other chars!
    mysqli_set_charset($conn, "utf8");

    //grabbing values
    $nameSchool = $_GET['schoolsearch'];
    $numGrade = $_GET['classsearch'];
    $idSchool;
    $idGrade;
    $subjectLink;
    $idBooks;
    $subjectArray;



    //SMARTBUY MODAL - getting subjects
    $sql = "SELECT DISTINCT subjectLink FROM school JOIN grade USING (idSchool) JOIN link USING (idGrade) WHERE nameSchool = ? AND numGrade = ?";

    //initializing statement
    $stmt = mysqli_stmt_init($conn);

    //is the statement okay?
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "This won't work!";
        exit();
    }
    else{
        //binding
        mysqli_stmt_bind_param($stmt, "si", $nameSchool, $numGrade);
        
        //execute parameters
        mysqli_stmt_execute($stmt);

        //grabbing the results woohoo
        $result = mysqli_stmt_get_result($stmt);
    }

    if(mysqli_num_rows($result)){

        echo    '
                    <div class="modal fade" id="smartbuy-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="exampleModalLabel">Odaberi predmete</h5>
                                    <button type="button btn-white" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" class="text-white">&times;</span>
                                    </button>
                                </div>
                                <form action="includes/smartbuy.inc.php" method="post">
                                    <div class="modal-body">            
                    ';

        while($row = mysqli_fetch_array($result)){
            $subjectLink = $row['subjectLink'];
            echo    '
                                        <a class="dropdown-item disabled" id="hideSubDrop" href="#">
                                            <span id="hideSubSpan">'.$subjectLink.'</span>
                                            <div class="material-switch float-right">
                                                        <input id="smartbuy-option-'.$subjectLink.'" name="check_list[]" type="checkbox" value="'.$subjectLink.'" checked/>
                                                        <label for="smartbuy-option-'.$subjectLink.'" class="label-default"></label>
                                            </div>
                                        </a>     
                    ';
        }

        echo    '                   
                                    <input class="sr-only" name="school" value="'. $nameSchool .'">
                                    <input class="sr-only" name="grade" value="'. $numGrade .'">

                                    </div>
                                    
                                    <div class="modal-footer mt-3">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>                          
                                        <button type="submit" class="btn btn-primary" name=""> <i class="fas fa-brain ml-2 mr-2"></i> </button>                       
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                ';
        
    }
    else{
        echo "Fetching failed, data not found :(";
        exit();
    }


    //we got nameSchool, but we actually need the ID of the school
    //statement that we want to send to DB
    $sql = "SELECT idSchool FROM school WHERE nameSchool=?";

    //initializing statement
    $stmt = mysqli_stmt_init($conn);

    //is the statement okay?
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "This won't work 1!";
        exit();
    }
    else{
        //binding
        mysqli_stmt_bind_param($stmt, "s", $nameSchool);
        
        //execute parameters
        mysqli_stmt_execute($stmt);

        //grabbing the results woohoo
        $result = mysqli_stmt_get_result($stmt);
    }

    if(mysqli_num_rows($result)){           
        $row = mysqli_fetch_array($result);
        $idSchool = $row["idSchool"];
    }
    else{
        echo "Fetching failed, school not found :(";
        exit();
    }

    //CHECKPOINT: now we got idSchool and numGrade, we can find idGrade!

    //statement that we want to send to DB
    $sql = "SELECT idGrade FROM grade WHERE idSchool=? AND numGrade=?";

    //initializing statement
    $stmt = mysqli_stmt_init($conn);

    //is the statement okay?
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "This won't work 2!";
        exit();
    }
    else{
        //binding
        mysqli_stmt_bind_param($stmt, "ii", $idSchool, $numGrade);
        
        //execute parameters
        mysqli_stmt_execute($stmt);

        //grabbing the results woohoo
        $result = mysqli_stmt_get_result($stmt);
    }

    if(mysqli_num_rows($result)){           
        $row = mysqli_fetch_array($result);
        $idGrade = $row["idGrade"];
    }
    else{
        echo "Fetching failed, grade not found :(";
        exit();
    }

    //CHECKPOINT: now we got idGrade, we can start searching for SUBJECTS!

    //finding all the subjects linked with a grade
    $sql = "SELECT DISTINCT subjectLink FROM link WHERE idGrade=?";

    //initializing statement
    $stmt = mysqli_stmt_init($conn);

    //is the statement okay?
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "This won't work 3!";
        exit();
    }
    else{
        //binding
        mysqli_stmt_bind_param($stmt, "i", $idGrade);
        
        //execute parameters
        mysqli_stmt_execute($stmt);

        //grabbing the results woohoo
        $result = mysqli_stmt_get_result($stmt);
    }

    if(mysqli_num_rows($result)){           
        echo    '
                <div class="container col-lg-9 text-center sticky-top">
                    <div class="btn-group" role="group" aria-label="Basic example">

                        <div class="dropdown">
                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton-cart" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-shopping-cart"></i> Vaša košarica
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton-cart">        
                                <table class="table table-borderless text-center" style="width:350px">
                                    <thead>
                                        <tr>
                                            <th>Naziv knjige</th>
                                            <th>Cijena</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody id="selected-ads">
                                        <!-- This is where selected ads will show -->
                                        
                                    </tbody>
                                </table>                                
                                
                                <button class="dropdown-item text-info text-center" type="button">
                                    <a href="checkout.php" class="text-info" name="checkout-submit"> Kupi knjige </a>
                                </button>         
                            </div>
                        </div>


                        <div class="dropdown">
                            <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Sakrij predmete
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                ';

        while($row = mysqli_fetch_array($result)){
            $subjectArray[] = $row;
            $subjectLink = $row['subjectLink'];

            echo    '
                                <a class="dropdown-item disabled" id="hideSubDrop" href="#">
                                    <span id="hideSubSpan">'.$subjectLink.'</span>
                                    <div class="material-switch float-right">
                                                <input id="someSwitchOptionDefault'.$subjectLink.'" name="someSwitchOption'.$subjectLink.'" type="checkbox" onchange="checkboxToggle(this)"/>
                                                <label for="someSwitchOptionDefault'.$subjectLink.'" class="label-default"></label>
                                    </div>
                                </a>
                    ';
        }
        echo    '           </div>
                        </div>
                    </div>
                </div>
                ';
    }
    else{
        echo "Fetching failed, subject not found :(";
        exit();
    }

    //button with filters
    echo $prilagodi;

    foreach ($subjectArray as $row){
            $subjectLink = $row['subjectLink'];

            //CHECKPOINT: time to search for every BOOK beloning to each of the subjects

            echo    '
                    <div class="container col-lg-9" id="someSwitchOption'.$subjectLink.'"> 
                        <div class="card">
                            <h5 class="card-header text-white" style="background-color: #00AA9E;">'.$subjectLink.'</h5>
                    ';

            //finding all the books linked with the same subject and grade id
            $sql = "SELECT idBooks FROM link WHERE idGrade=? AND subjectLink=?";

            //initializing statement
            $stmt = mysqli_stmt_init($conn);

            //is the statement okay?
            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo "This won't work 4!";
                exit();
            }
            else{
                //binding
                mysqli_stmt_bind_param($stmt, "is", $idGrade, $subjectLink);
                
                //execute parameters
                mysqli_stmt_execute($stmt);

                //grabbing the results woohoo
                $resultBook = mysqli_stmt_get_result($stmt);
            }

            if(mysqli_num_rows($resultBook)){           
                while($row = mysqli_fetch_array($resultBook)){
                    $idBooks = $row["idBooks"];                     

                    //CHECKPOINT: having idBooks, we can start searching for ADDS!!
                    $sql = "SELECT * FROM books WHERE idBooks=?";
                            
                    //initializing statement
                    $stmt = mysqli_stmt_init($conn);

                    //is the statement okay?
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        echo "This won't work 6!";
                        exit();
                    }
                    else{
                        //binding
                        mysqli_stmt_bind_param($stmt, "i", $idBooks);

                        //execute parameters
                        mysqli_stmt_execute($stmt);

                        //grabbing the results woohoo
                        $resultAddBook = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_array($resultAddBook);

                        $nameBooks = $row['nameBooks'];
                    }

                    echo    '
                            <h7 class="card-header">'.$row["nameBooks"].'<br><sub>'.$row["authorsBooks"].'</sub></h7>
                                <div class="card-body" style="overflow-y: scroll; height:300px;">
                                    
                                    <ul class="list-group">
                            ';

                    //finding all the adds of the selected book
                    $sql = "SELECT * FROM adds WHERE idBooks=? AND soldAdd = 0";

                    //initializing statement
                    $stmt = mysqli_stmt_init($conn);

                    //is the statement okay?
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        echo "This won't work 5!";
                        exit();
                    }
                    else{
                        //binding
                        mysqli_stmt_bind_param($stmt, "i", $idBooks);
                        
                        //execute parameters
                        mysqli_stmt_execute($stmt);

                        //grabbing the results woohoo
                        $resultAdd = mysqli_stmt_get_result($stmt);
                    }

                    if(mysqli_num_rows($resultAdd)){
                        while($row = mysqli_fetch_array($resultAdd)){
                            $idAdd = $row["idAdd"];                         

                            //CHECKPOINT: Let's print all these ADDS!
                            $sql = "SELECT * FROM users WHERE uidUsers=?";
                                    
                            //initializing statement
                            $stmt = mysqli_stmt_init($conn);

                            //is the statement okay?
                            if(!mysqli_stmt_prepare($stmt, $sql)){
                                echo "This won't work 6!";
                                exit();
                            }
                            else{
                                //binding
                                mysqli_stmt_bind_param($stmt, "s", $row['uidUsers']);

                                //execute parameters
                                mysqli_stmt_execute($stmt);

                                //grabbing the results woohoo
                                $resultAddUsers = mysqli_stmt_get_result($stmt);
                                $rowU = mysqli_fetch_array($resultAddUsers);
                            }


                            //is there an image associated with AD?
                            $sql = "SELECT * FROM img WHERE idAdd=$idAdd";
                            $resultImage = mysqli_query($conn, $sql);
                            $imagePath = '';

                            if (mysqli_num_rows($resultImage)) {
                                //there's an image, we should show it!
                                $rowAddImg = mysqli_fetch_assoc($resultImage);

                                //string starts with ../upl, gotta cut it
                                $imagePath = substr($rowAddImg["imageAdd"], 3); 
                                
                            }
                            else {
                                //there is no image, we go with stock
                                $imagePath = 'img/book_icon_add.png';
                            }

                            //RATING 
                            $tmp = $row['uidUsers'];
                            $sql = "SELECT ROUND(AVG(rating)) AS avgrating FROM sold_ads JOIN adds USING (idAdd) WHERE uidUsers='$tmp' AND adChecked=0 AND rating!=0 GROUP BY uidUsers";
                            $resultrate = mysqli_query($conn, $sql);

                            if(!$resultrate){
                                $rating['avgrating'] = 0;
                            }
                            else {
                                $rating = mysqli_fetch_assoc($resultrate);
                            }

                            $stars = '';
                            for($i = 0; $i < $rating['avgrating']; $i++){
                                $stars .= '<i class="fas fa-star text-primary"></i>';
                            }

                            echo    '
                                    <li class="list-group-item">
                                        <div class="row align-items-center">

                                            <span class="col-sm text-center mt-1">
                                                <img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">
                                            </span>

                                            <input class="sr-only" type="text" value="'.$row['uidUsers'].'">
                                            <input class="sr-only" type="text" value="'.$row['priceAdd'].'">
                                            <input class="sr-only" type="text" value="'.$nameBooks.'">
                                            <input class="sr-only" type="text" value="'.$row['idAdd'].'">

                                            <button type="button" class="btn btn-info" style="position:absolute; top:0; right:0;" onclick = "addToCart(this)" name="update-cart">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>   

                                            <span class="col-sm text-center mt-1">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                <strong>'.$row["yearAdd"].'</strong>
                                            </span>

                                            <span class="col-sm text-center mt-1">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                <strong class="list-ad-region">'. $rowU['regionUsers'] .'</strong>
                                            </span>

                                            <span class="col-sm text-center mt-1">
                                                <i class="fas fa-user mr-1"></i>
                                                <strong> '.$row["uidUsers"].' </strong>
                                                '. $stars .'
                                                <br>
                                                <div class="btn-group" role="group">
                                                    <h6>';
                                                    //disable poruke if not logged in
                                                    if (isset($_SESSION["userUid"])) {
                                                        echo '  <button     type="button"
                                                                        id="'.$row['uidUsers'].'"
                                                                        style="width:40px"
                                                                        class="btn btn-warning text-white send_msg_to_user">
                                                                <i class="far fa-envelope"></i> 
                                                            </button>';
                                                        }else{
                                                            echo'<button    type="button"
                                                                id="'.$row['uidUsers'].'"
                                                                disabled
                                                                style="width:40px"
                                                                class="btn btn-warning text-white send_msg_to_user">
                                                                <i class="far fa-envelope"></i> 
                                                            </button>';
                                                        }
                                                echo'</h6>
                                                    <h6> 
                                                        <button     type="button" 
                                                                    class="btn btn-info mx-1"
                                                                    role="group" 
                                                                    style="width:40px" 
                                                                    data-toggle="tooltip" 
                                                                    data-placement="top" 
                                                                    title=  "
                                                                            Tel: '.$rowU['phoneNumUsers'].'
                                                                            ">
                                                            <i class="fas fa-phone mr-1"></i>
                                                        </button>
                                                    </h6>
                                                </div>
                                            </span>

                                            <span class="col-sm text-center mt-1">
                                                <span class="badge badge-pill badge-primary text-center" style="width: 70px; height: 70px; vertical-align: middle; line-height: 60px">
                                                    <b style="font-size: 20px">'.$row["priceAdd"].'kn</b>
                                                </span>
                                            </span> 

                                        </div>
                                    </li>
                                    <br>
                                    <br>
                                    ';


                        }
                    }
                    else{
                        echo "Add not found :(";                    
                    }

                    echo    '
                                </ul>
                            </div>
                            ';
                }
            }
            else{
                echo "Fetching failed, book not found :(";
                exit();
            }

            echo    '
                        </div>
                    </div>
                    <br>
                    <br>
                    ';
        }   

        //closing connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
}


//check if the users actually clicked the SUBMIT button - book search
if (isset($_GET['booksearch-submit'])) {

    //run the connection to DATABASE
    require 'includes/dbh.inc.php';   //now we got access to variable CONN - connection to the database

    //we want Č Ć Š Ž and other chars!
    mysqli_set_charset($conn, "utf8");

    //grabbing values
    $nameBooks = $_GET['booksearch'];
    
    //statement that we want to send to DB
    $sql = "SELECT * FROM books WHERE nameBooks = ?";

    //initializing statement
    $stmt = mysqli_stmt_init($conn);

    //is the statement okay?
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "This won't work!";
        exit();
    }
    else{
        //binding
        mysqli_stmt_bind_param($stmt, "s", $nameBooks);
        
        //execute parameters
        mysqli_stmt_execute($stmt);

        //grabbing the results
        $result = mysqli_stmt_get_result($stmt);
    }

    if(mysqli_num_rows($result)){           
        $row = mysqli_fetch_array($result);
        $idBooks = $row['idBooks'];
        $authorsBooks = $row['authorsBooks'];
    }
    else{
        echo "Fetching failed, book not found :(";
        exit();
    }

    //CHEKPOINT: idBooks
    //searching for ADS, img too *second join works without "left"
    $sql = "SELECT adds.*, img.imageAdd, users.* FROM adds LEFT JOIN img ON adds.idAdd = img.idAdd JOIN users on adds.uidUsers = users.uidUsers WHERE idBooks = $idBooks AND soldAdd = 0";

    //initializing statement
    $stmt = mysqli_stmt_init($conn);

    //is the statement okay?
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "This won't work 2!";
        exit();
    }
    else{
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }

    //this string will contain all the info from DB
    echo $prilagodi;
    $output =   '
                <div class="container col-lg-9 text-center sticky-top">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton-cart" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-shopping-cart"></i> Vaša košarica
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton-cart">        
                                <table class="table table-borderless text-center" style="width:350px">
                                    <thead>
                                        <tr>
                                            <th>Naziv knjige</th>
                                            <th>Cijena</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody id="selected-ads">
                                        <!-- This is where selected ads will show -->
                                        
                                    </tbody>
                                </table>                                
                                
                                <button class="dropdown-item text-info text-center" type="button">
                                    <a href="checkout.php" class="text-info" name="checkout-submit"> Kupi knjige </a>
                                </button>         
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container col-lg-9"> 
                        <div class="card shadow-cool">                          
                            <h7 class="card-header text-white" style="background-color: #00AA9E;">'.$nameBooks.'<br><sub>'.$authorsBooks.'</sub></h7>                           
                            <ul class="list-group list-group-flush mb-5 bg-white rounded" style="overflow-y: scroll; max-height:700px;">

                ';
    
    if(mysqli_num_rows($result)){           
        while($row = mysqli_fetch_array($result)){
            
            //CHECKPOINT: ADS
            //printing ads
            $imagePath = '';
            if($row['imageAdd'] != NULL){
                $imagePath = $row['imageAdd'];

                //string starts with ../upl, gotta cut it
                $imagePath = substr($imagePath, 3);
            }
            else {
                $imagePath = 'img/book_icon_add.png';
            }

            $output .=  '      
                        <li class="list-group-item">
                            <div class="row align-items-center">
                                <span class="col-sm text-center mt-1">
                                    <img src="'.$imagePath.'" style="max-height:100px; width: 100px;" alt="Nema slike">
                                </span>                     
                                <span class="col-sm text-center mt-1">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    <strong>'.$row['yearAdd'].'</strong>
                                </span>
                                <span class="col-sm text-center mt-1">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    <strong class="list-ad-region">'. $row['regionUsers'] .'</strong>
                                </span>
                                <span class="col-sm text-center mt-1">
                                    <i class="fas fa-user mr-1"></i>
                                    <strong> '.$row['uidUsers'].' </strong>
                                    <br>
                                    <h6>';

                                    //disable poruke if not logged in
                                    if (isset($_SESSION["userUid"])) {
                                        $output .= '    <button     type="button"
                                                            id="'.$row['uidUsers'].'"
                                                            style="width:40px"
                                                            class="btn btn-warning text-white send_msg_to_user">
                                                            <i class="far fa-envelope"></i> 
                                                        </button>';
                                    }else{
                                        $output .=' <button     type="button"
                                                        id="'.$row['uidUsers'].'"
                                                        disabled
                                                        style="width:40px"
                                                        class="btn btn-warning text-white send_msg_to_user">
                                                        <i class="far fa-envelope"></i> 
                                                    </button>';
                                    }

                                    $output .=  '<button    type="button" 
                                                    class="btn btn-info mx-1" 
                                                    data-toggle="tooltip" 
                                                    data-placement="top" 
                                                    title=  "
                                                            Tel: '.$row['phoneNumUsers'].'
                                                            ">
                                            <i class="fas fa-phone mr-1"></i> INFO
                                        </button>
                                    </h6>
                                </span>
                                <span class="col-sm text-center mt-1">
                                    <span class="badge badge-pill badge-primary text-center" style="width: 70px; height: 70px; vertical-align: middle; line-height: 60px">
                                        <b style="font-size: 20px">'.$row['priceAdd'].'kn</b>
                                    </span>
                                </span> 

                                <input class="sr-only" type="text" value="'.$row['uidUsers'].'">
                                <input class="sr-only" type="text" value="'.$row['priceAdd'].'">
                                <input class="sr-only" type="text" value="'.$nameBooks.'">
                                <input class="sr-only" type="text" value="'.$row['idAdd'].'">

                                <button type="button" class="btn btn-info" style="position:absolute; top:0; right:0;" onclick = "addToCart(this)" name="update-cart">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </li>
                        ';
        }

        echo $output .= '
                                </ul>
                            </div>
                        </div>
                        <br>
                        ';
    }
    else{
        echo "Fetching failed, ad not found :(";
        exit();
    }


}


echo '</main>';

require "footer.php";