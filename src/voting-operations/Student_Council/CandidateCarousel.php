<?php
/*Function For Checking IF There Is Atleat One Position In Database*/
function Make_Query_For_Position($connect,$campus){
  $output = '';
  $resultPosition = Make_Query_For_Student_Council_Position($connect,$campus);
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

/*Function For Student Council*/
function Make_Query_For_Student_Council($connect,$campus,$year,$position)
{
  if($campus == "Mabini" && $position == "Representative" ){
    $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND year ="'.$year.'"  AND indicator = "student council" ORDER BY id ASC ';
    $result = mysqli_query($connect, $query);
  }else{
    $query = 'SELECT * FROM tbnominees WHERE position = "'.$position.'" AND campus = "'.$campus.'" AND indicator = "student council"  ORDER BY id ASC ';
    $result = mysqli_query($connect, $query);
  }
 return $result;
}

/*Function For Getting The Student Council Position*/
function Make_Query_For_Student_Council_Position($connect,$campus)
{
 $query = 'SELECT DISTINCT position_name FROM tbcouncil WHERE campus = "'.$campus.'" ';
 $result = mysqli_query($connect, $query);

 return $result;
}

/*Function For Student Council Making a Carousel*/
function Make_Slides_For_Student_Council($connect,$campus,$college,$program,$year){
 $output = '';
 $resultPosition = Make_Query_For_Student_Council_Position($connect,$campus);
 $resultCheckePosition = mysqli_num_rows($resultPosition);
  if($resultCheckePosition > 0){
    $count = 1;
    while($rowPosition = mysqli_fetch_array($resultPosition)){
      $resultCandidate = Make_Query_For_Student_Council($connect,$campus,$year,$rowPosition["position_name"]);
      $resultChecke = mysqli_num_rows($resultCandidate);
      
        if($resultChecke > 0){
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

                while($rowCandidate = mysqli_fetch_array($resultCandidate))
                {
                    $output .= '<li data-id="'.$rowCandidate["id"].'" data-start="'.$countStart.'">
                                    <div class="crop">';
                        if (file_exists('../uploads/'.$rowCandidate["image"])) {
                            $output.='<img class="rounded img-fluid" src="../uploads/'.$rowCandidate["image"].'" />';
                        } else {
                            $output.='<img class="rounded img-fluid"  src="../img/No_picture_available.png" />';
                        }
                            $output.='</div>
                                    <div class="bg-light">
                                        <h5 class="text-uppercase">'.$rowCandidate["fname"].' '.$rowCandidate["lname"].'</h5>
                                        <h6 class="font-italic mt-n2 text-uppercase">'.$rowCandidate["party"].'</h6>
                                    </div>
                                </li>';
            $countStart++;
          }
            $output.='</ul>
                      </div>
                    </div>
                  </div>
                </div>';
                
          $count++;
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

    if($campus == "Mintal" && $college == "PAMULAAN"){
      $output.='<div class="form-group col-lg-12">
                  <div class="row">
                    <div class="col-lg-8 col-md-7 col-xs-6">

                    </div>
                    <div id="hide" class="col-lg-3 col-md-4 col-xs-5">
                      <button id="vote" class="btn btn-success mb-1 text-center p-3">Submit Your Vote</button>
                    </div>
                    <div class="col-lg-1 col-md-1 col-xs-1">

                    </div>
                  </div>
                </div>';
    }else{
      $output.='<div class="form-group col-lg-12">
                  <div class="row">
                    <div class="col-lg-8 col-md-7 col-xs-6">

                    </div>
                    <div id="hide" class="col-lg-3 col-md-4 col-xs-5">
                      <button id="submit" class="btn btn-success text-center p-3 ">Proceed to College Local Council</button>
                    </div>
                    <div class="col-lg-1 col-md-1 col-xs-1">
                    </div>
                  </div>
                </div>';
    }
    return $output;
  }else{
    
  }
}
/* End Function For Student Council */
?>