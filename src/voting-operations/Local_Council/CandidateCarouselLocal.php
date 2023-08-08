<?php
/*Function For Checking IF There Is At-least One Position In Database*/
function Make_Query_For_Position($connect,$campus){
    $output = '';
    $resultPosition = Make_Query_For_Local_Council_Position($connect,$campus);
    $resultCheckePosition = mysqli_num_rows($resultPosition);
    if($resultCheckePosition > 0){

    }else{
        $output.='
            <div class="text-center col-12">
              <img src="../../img/Error.gif" width="25%"  height="auto">
              <h2 class="text-danger">
                There\'s no available position at this moment.
              </h2>
              <b>Please try again later</b>
            </div>';
    }
    return $output;
}

/*Function For Local Council*/
function Make_Query_For_Local_Council($connect,$campus,$college,$program,$year,$position)
{
    if($campus == "Tagum"){
        if($position == "Senator" || $position == "Bussines Manager"){
            //Senator (2 per program)
            //dili kay kung siya lng isa
            $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND college ="'.$college.'" AND program ="'.$program.'"  AND indicator = "local council" ORDER BY id ASC ';
            $result = mysqli_query($connect, $query);
        }elseif($position == "Bussines Manager"){
            //Senator (2 per program)
            //dili kay kung siya lng isa
            $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND college ="'.$college.'" AND program ="'.$program.'"  AND indicator = "local council" ORDER BY id ASC ';
            $result = mysqli_query($connect, $query);
        }else{
            if($program == "BS in Agricultural and Biosystems Engineering" || $program == "Bachelor of Science in Agricultural Engineering"){
                //Society of Agricultural and Biosystem Engineering Students (SABES)
                $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND college ="'.$college.'" AND (program = "BS in Agricultural and Biosystems Engineering" OR program = "Bachelor of Science in Agricultural Engineering")  AND indicator = "local council" ORDER BY id ASC ';
                $result = mysqli_query($connect, $query);
                $lcname = "Society of Agricultural and Biosystem Engineering Students";
            }elseif($program == "Bachelor of Elementary Education" || $program == "Bachelor of Special Needs Education" || $program == "Bachelor of Early Childhood Education"){
                //Organization of Future Elementary Educators (OFEE)
                $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND college ="'.$college.'" AND (program = "Bachelor of Elementary Education" OR program = "Bachelor of Special Needs Education" OR program = "Bachelor of Early Childhood Education")  AND indicator = "local council" ORDER BY id ASC ';
                $result = mysqli_query($connect, $query);
                $lcname = "Organization of Future Elementary Educators";
            }elseif($program == "BSEd"|| $program == "Bachelor of Technical-vocational Teacher Education"){
                //Association of Future Secondary Teachers (AFSeT)
                $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND college ="'.$college.'" AND (program = "BSEd" OR program = "Bachelor of Technical-vocational Teacher Education")  AND indicator = "local council" ORDER BY id ASC ';
                $result = mysqli_query($connect, $query);
                $lcname = "Association of Future Secondary Teachers";
            }elseif($program == "Bachelor of Science in Information Technology"){
                //Society of Information and Technology Students
                $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND college ="'.$college.'" AND program ="'.$program.'"  AND indicator = "local council" ORDER BY id ASC ';
                $result = mysqli_query($connect, $query);
                $lcname = "Society of Information and Technology Students";
            }
        }
    }elseif($campus == "Mabini"){
        if($position == "Representative" ){
            $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND college ="'.$college.'" AND program ="'.$program.'" AND year ="'.$year.'"  AND indicator = "local council" ORDER BY id ASC ';
            $result = mysqli_query($connect, $query);
        }else{
            $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND college ="'.$college.'" AND program ="'.$program.'" AND indicator = "local council" ORDER BY id ASC ';
            $result = mysqli_query($connect, $query);
        }
        $lcname = $program;
    }
    else{
    }
    return $result;
}

/*Function For Getting The Local Council Position*/
function Make_Query_For_Local_Council_Position($connect,$campus)
{
    $query = 'SELECT DISTINCT position_name FROM tbposition WHERE campus = "'.$campus.'" ';
    $result = mysqli_query($connect, $query);

    return $result;
}

/*Function For Local Council Making a Carousel*/
function Make_Slides_For_Local_Council($connect,$campus,$college,$program,$year){
    $output = '';
    $resultPosition = Make_Query_For_Local_Council_Position($connect,$campus);
    $resultCheckePosition = mysqli_num_rows($resultPosition);
    if($resultCheckePosition > 0){
        $count = 1;
        while($rowPosition = mysqli_fetch_array($resultPosition)){

            $resultCandidate = Make_Query_For_Local_Council($connect,$campus,$college,$program,$year,$rowPosition["position_name"]);
            $resultChecke = mysqli_num_rows($resultCandidate);

            if($resultChecke > 0){
                if($rowPosition["position_name"] == "Business Manager" && $campus == "Tagum"){
                    $output.='<div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="text-center styles_Card ">
                      <h2 class="text-responsive font-weight-bold">
                        '.$rowPosition["position_name"].'
                      </h2>
                      <div class="x-100 y-100">
                        <div id="Carousel11" class="position-relative ChooseYourCandidate" >
                          <div class="position-relative text-center rounded mx-auto d-block w-100 h-100 p-5 m-5 bg-white" id="ChooseYourCandidate11" >
                            <h2>
                              Choose Your Candidate
                            </h2>
                          </div>
                          <ul id="flip-items11" class="flip-items position-absolute">                
                            <li data-id="0" data-start="0" id="NoVote">
                              <div class="crop">
                                <img class="rounded mx-auto d-block img-fluid mb-5" src="../uploads/Abstain.jpg" />
                              </div>
                            </li>';
                    $countStart = 1;
                    $resultCandidate = Make_Query_For_Local_Council($connect,$campus,$college,$program,$year,$rowPosition["position_name"]);
                    $resultChecke = mysqli_num_rows($resultCandidate);

                    while($rowCandidate = mysqli_fetch_array($resultCandidate)){
                        $output .= '<li data-id="'.$rowCandidate["id"].'" data-start="'.$countStart.'">
                            <div class="crop">';
                        if (file_exists('../uploads/'.$rowCandidate["image"])) {
                            $output.='<img class="rounded mx-auto d-block img-fluid" src="../uploads/'.$rowCandidate["image"].'" />';
                        } else {
                            $output.='<img class="rounded mx-auto d-block img-fluid"  src="../img/No_picture_available.png" />';
                        }
                        $output.='  </div>
                            <div class="bg-light">
                              <h5 class="text-uppercase">'.$rowCandidate["fname"].' '.$rowCandidate["lname"].'</h5>
                              <h6 class="font-italic mt-n2 text-uppercase">'.$rowCandidate["party"].'</h6>
                            </div>
                          </li>
                        ';
                        $countStart++;
                    }
                    $output.='</ul>
                    </div>
                  </div>
                </div>
              </div>';
                    $count ++;
                    //Above 2 Available candidate
                    if(mysqli_num_rows($resultCandidate) > 1 ){
                        $output.='<div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="text-center styles_Card h-100">
                      <h2 class="text-responsive font-weight-bold text-uppercase">
                        '.$rowPosition["position_name"].'
                      </h2>
                      <div class="x-100 y-100">
                        <div id="Carousel12" class="position-relative ChooseYourCandidate" >
                          <div class="position-relative text-center rounded mx-auto d-block w-100 h-100 p-5 m-5 bg-white" id="ChooseYourCandidate12" >
                            <h2>
                              Choose Your Candidate
                            </h2>
                          </div>
                          <ul id="flip-items12" class="flip-items position-absolute">                
                            <li data-id="0" data-start="0" id="NoVote">
                              <div class="crop">
                                <img class="rounded mx-auto d-block img-fluid mb-5" src="../uploads/Abstain.jpg" />
                              </div>
                            </li>';
                        $countStart = 1;
                        $resultCandidate = Make_Query_For_Local_Council($connect,$campus,$college,$program,$year,$rowPosition["position_name"]);
                        $resultChecke = mysqli_num_rows($resultCandidate);

                        while($rowCandidate = mysqli_fetch_array($resultCandidate)){
                            $output .= '<li data-id="'.$rowCandidate["id"].'" data-start="'.$countStart.'">
                              <div class="crop">';
                            if (file_exists('../uploads/'.$rowCandidate["image"])) {
                                $output.='<img class="rounded mx-auto d-block img-fluid" src="../uploads/'.$rowCandidate["image"].'" />';
                            } else {
                                $output.='<img class="rounded mx-auto d-block img-fluid"  src="../img/No_picture_available.png" />';
                            }
                            $output.='</div>
                                <div class="bg-light">
                                  <h5 class="text-uppercase">'.$rowCandidate["fname"].' '.$rowCandidate["lname"].'</h5>
                                  <h6 class="font-italic mt-n2 text-uppercase">'.$rowCandidate["party"].'</h6>
                                </div>
                            </li>
                          ';
                            $countStart++;
                        }
                        $output.='</ul>
                      </div>
                    </div>
                  </div>
                </div>';
                        $count ++;
                    }
                }elseif($rowPosition["position_name"] == "Senator" && $campus == "Tagum"){
                    $output.='<div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="text-center styles_Card h-100">
                      <h2 class="text-responsive font-weight-bold text-uppercase">
                        '.$rowPosition["position_name"].'
                      </h2>
                      <div class="x-100 y-100">
                        <div id="Carousel13" class="position-relative ChooseYourCandidate" >
                          <div class="position-relative text-center rounded mx-auto d-block w-100 h-100 p-5 m-5 bg-white" id="ChooseYourCandidate13" >
                            <h2>
                              Choose Your Candidate
                            </h2>
                          </div>
                          <ul id="flip-items13" class="flip-items position-absolute">                
                            <li data-id="0" data-start="0" id="NoVote">
                              <div class="crop">
                                <img class="rounded mx-auto d-block img-fluid mb-5" src="../uploads/Abstain.jpg" />
                              </div>
                            </li>';
                    $countStart = 1;
                    $resultCandidate = Make_Query_For_Local_Council($connect,$campus,$college,$program,$year,$rowPosition["position_name"]);
                    $resultChecke = mysqli_num_rows($resultCandidate);

                    while($rowCandidate = mysqli_fetch_array($resultCandidate)){
                        $output .= '<li data-id="'.$rowCandidate["id"].'" data-start="'.$countStart.'">
                            <div class="crop">';
                        if (file_exists('../uploads/'.$rowCandidate["image"])) {
                            $output.='<img class="rounded mx-auto d-block img-fluid" src="../uploads/'.$rowCandidate["image"].'" />';
                        } else {
                            $output.='<img class="rounded mx-auto d-block img-fluid"  src="../img/No_picture_available.png" />';
                        }
                        $output.='</div>
                              <div class="bg-light">
                                <h5 class="text-uppercase">'.$rowCandidate["fname"].' '.$rowCandidate["lname"].'</h5>
                                <h6 class="font-italic mt-n2 text-uppercase">'.$rowCandidate["party"].'</h6>
                              </div>
                          </li>
                        ';
                        $countStart++;
                    }
                    $output.='</ul>
                    </div>
                  </div>
                </div>
              </div>';
                    $count ++;

                    //Above Two Available Candidate
                    if(mysqli_num_rows($resultCandidate) >= 2 ){
                        $output.='<div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="text-center styles_Card h-100">
                      <h2 class="text-responsive font-weight-bold text-uppercase">
                        '.$rowPosition["position_name"].'
                      </h2>
                      <div class="x-100 y-100">
                        <div id="Carousel14" class="position-relative ChooseYourCandidate" >
                          <div class="position-relative text-center rounded mx-auto d-block w-100 h-100 p-5 m-5 bg-white" id="ChooseYourCandidate14" >
                            <h2>
                              Choose Your Candidate
                            </h2>
                          </div>
                          <ul id="flip-items14" class="flip-items position-absolute">                
                            <li data-id="0" data-start="0" id="NoVote">
                              <div class="crop">
                                <img class="rounded mx-auto d-block img-fluid mb-5" src="../uploads/Abstain.jpg" />
                              </div>
                            </li>';
                        $countStart = 1;
                        $resultCandidate = Make_Query_For_Local_Council($connect,$campus,$college,$program,$year,$rowPosition["position_name"]);
                        $resultChecke = mysqli_num_rows($resultCandidate);

                        while($rowCandidate = mysqli_fetch_array($resultCandidate)){
                            $output .= '<li data-id="'.$rowCandidate["id"].'" data-start="'.$countStart.'">
                              <div class="crop">';
                            if (file_exists('../uploads/'.$rowCandidate["image"])) {
                                $output.='<img class="rounded mx-auto d-block img-fluid" src="../uploads/'.$rowCandidate["image"].'" />';
                            } else {
                                $output.='<img class="rounded mx-auto d-block img-fluid"  src="../img/No_picture_available.png" />';
                            }
                            $output.='</div>
                                <div class="bg-light">
                                  <h5 class="text-uppercase">'.$rowCandidate["fname"].' '.$rowCandidate["lname"].'</h5>
                                  <h6 class="font-italic mt-n2 text-uppercase">'.$rowCandidate["party"].'</h6>
                                </div>
                            </li>
                          ';
                            $countStart++;
                        }
                        $output.='</ul>
                      </div>
                    </div>
                  </div>
                </div>';
                        $count ++;
                    }
                    //Above 3 Available Candidate
                    if(mysqli_num_rows($resultCandidate) >= 3 ){
                        $output.='<div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="text-center styles_Card h-100">
                      <h2 class="text-responsive font-weight-bold text-uppercase">
                        '.$rowPosition["position_name"].'
                      </h2>
                      <div class="x-100 y-100">
                        <div id="Carousel15" class="position-relative ChooseYourCandidate" >
                          <div class="position-relative text-center rounded mx-auto d-block w-100 h-100 p-5 m-5 bg-white" id="ChooseYourCandidate15" >
                            <h2>
                              Choose Your Candidate
                            </h2>
                          </div>
                          <ul id="flip-items15" class="flip-items position-absolute">                
                            <li data-id="0" data-start="0" id="NoVote">
                              <div class="crop">
                                <img class="rounded mx-auto d-block img-fluid mb-5" src="../uploads/Abstain.jpg" />
                              </div>
                            </li>';
                        $countStart = 1;
                        $resultCandidate = Make_Query_For_Local_Council($connect,$campus,$college,$program,$year,$rowPosition["position_name"]);
                        $resultChecke = mysqli_num_rows($resultCandidate);

                        while($rowCandidate = mysqli_fetch_array($resultCandidate)){
                            $output .= '<li data-id="'.$rowCandidate["id"].'" data-start="'.$countStart.'">
                              <div class="crop">';
                            if (file_exists('../uploads/'.$rowCandidate["image"])) {
                                $output.='<img class="rounded mx-auto d-block img-fluid" src="../uploads/'.$rowCandidate["image"].'" />';
                            } else {
                                $output.='<img class="rounded mx-auto d-block img-fluid"  src="../img/No_picture_available.png" />';
                            }
                            $output.='</div>
                                <div class="bg-light">
                                  <h5 class="text-uppercase">'.$rowCandidate["fname"].' '.$rowCandidate["lname"].'</h5>
                                  <h6 class="font-italic mt-n2 text-uppercase">'.$rowCandidate["party"].'</h6>
                                </div>
                            </li>
                          ';
                            $countStart++;
                        }
                        $output.='</ul>
                      </div>
                    </div>
                  </div>
                </div>';
                        $count ++;
                    }
                }else{
                    $output.='<div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="text-center styles_Card h-100">
                      <h2 class="text-responsive font-weight-bold text-uppercase">
                        '.$rowPosition["position_name"].'
                      </h2>
                      <div class="x-100 y-100">
                        <div id="Carousel'.$count.'" class="position-relative ChooseYourCandidate" >
                          <div class="position-relative text-center rounded mx-auto d-block w-100 h-100 p-5 m-5 bg-white" id="ChooseYourCandidate'.$count.'" >
                            <h2>
                              Choose Your Candidate
                            </h2>
                          </div>
                          <ul id="flip-items'.$count.'" class="flip-items position-absolute">                
                            <li data-id="0" data-start="0" id="NoVote">
                              <div class="crop">
                                <img class="rounded mx-auto d-block img-fluid mb-5" src="../uploads/Abstain.jpg" />
                              </div>
                            </li>';
                    $countStart = 1;
                    while($rowCandidate = mysqli_fetch_array($resultCandidate)){
                        $output .= '<li data-id="'.$rowCandidate["id"].'" data-start="'.$countStart.'">
                        <div class="crop">';
                        if (file_exists('../uploads/'.$rowCandidate["image"])) {
                            $output.='<img class="rounded mx-auto d-block img-fluid" src="../uploads/'.$rowCandidate["image"].'" />';
                        } else {
                            $output.='<img class="rounded mx-auto d-block img-fluid"  src="../img/No_picture_available.png" />';
                        }
                        $output.='</div>
                          <div class="bg-light">
                            <h5 class="text-uppercase">'.$rowCandidate["fname"].' '.$rowCandidate["lname"].'</h5>
                            <h6 class="font-italic mt-n2 text-uppercase">'.$rowCandidate["party"].'</h6>
                          </div>
                      </li>
                    ';
                        $countStart++;
                    }
                    $output.='</ul>
                    </div>
                  </div>
                </div>
              </div>';
                    $count++;
                }

            }else{
                $output.='<div class="form-group col-lg-4 col-md-6 col-sm-12">
                    <div class="text-center styles_Card h-100">
                      <h2 class="text-responsive font-weight-bold text-uppercase">
                        '.$rowPosition["position_name"].'
                      </h2>
                      <div class="x-100 y-100">
                        <div class="position-relative text-center rounded mx-auto d-block w-100 h-100 p-5 m-5 bg-white">
                            <h2 class="text-danger">
                              No Candidate
                            </h2>
                          </div>
                      </div>
                    </div>
                  </div>';
                $count++;
            }
        }
        $output.='
    <div class="form-group col-12">
      <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1">

        </div>
        <div class="col-lg-7 col-md-5 col-sm-5 col-xs-3">
          <button id="back" type="button" class="btn text-white mb-1 px-4 py-3">Back</button>
        </div>
        <div class="col-lg-3 col-md-5 col-sm-6 col-xs-3">
          <button id="submit" class="btn btn-success mb-1 text-center p-3">Submit Your Vote</button>
        </div>
        <div class="col-lg-1 col-md-1">

        </div>
      </div>
    </div>';

        return $output;
    }else{

    }

}
/*End Function For Local Council*/
?>