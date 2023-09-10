<?php

/*Function For Checking IF There Is Atleat One Position In Database*/
function Make_Query_For_Position($connect){
  $output = '';
  $resultPosition = Make_Query_For_SSG_Position($connect);
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

/*Function For SSG*/
function Make_Query_For_SSG($connect,$position)
{
  $query = 'SELECT * FROM tbssgnominees WHERE position = "'.$position.'"';
  $result = mysqli_query($connect, $query);
  
  return $result;
}

/*Function For Getting The SSG Position*/
function Make_Query_For_SSG_Position($connect)
{
 $query = 'SELECT DISTINCT position_name FROM tbssgposition';
 $result = mysqli_query($connect, $query);

 return $result;
}

/*Function For SSG Making a Carousel*/
function Make_Slides_For_SSG($connect){
 $output = '';
 $resultPosition = Make_Query_For_SSG_Position($connect);
 $resultCheckePosition = mysqli_num_rows($resultPosition);
  if($resultCheckePosition > 0){
    $count = 1;
    while($rowPosition = mysqli_fetch_array($resultPosition)){
      $resultCandidate = Make_Query_For_SSG($connect,$rowPosition["position_name"]);
      $resultChecke = mysqli_num_rows($resultCandidate);
      
        if($resultChecke > 0){
          $output.='<div class="form-group col-lg-4 col-md-6 col-sm-12">
                      <div class="text-center styles_Card ">
                        <h2 class="text-responsive font-weight-bold">
                          '.$rowPosition["position_name"].'
                        </h2>
                        <div class="x-100 y-100">
                          <div id="Carousel'.$count.'" class="position-relative ChooseYourCandidate" >
                            <div class="position-relative text-center rounded mx-auto d-block w-100 h-100 p-5 m-5 bg-white" id="ChooseYourCandidate'.$count.'" >
                              <h2>
                                Choose Your Candidate
                              </h2>
                            </div>
                            <ul id="flip-items'.$count. '" class="flip-items position-absolute">                
                              <li data-id="0" data-start="0" id="NoVote">
                                <div class="crop">
                                  <img class="rounded mx-auto d-block img-fluid mb-5" src="../../uploads/Abstain.jpg" />
                                </div>
                              </li>';
          $countStart = 1;

          while($rowCandidate = mysqli_fetch_array($resultCandidate))
          {
            $output .= '<li data-id="'.$rowCandidate["stud_id"].'" data-start="'.$countStart.'">
                          <div class="crop">';
                  if (file_exists('../uploads/'.$rowCandidate["image"])) {
                    $output.='<img class="rounded img-fluid" src="../uploads/'.$rowCandidate["image"].'" />';
                  } else {
                    $output.='<img class="rounded img-fluid"  src="../img/No_picture_available.png" />';
                  }
                $output.='</div>
                            <div class="bg-light">
                              <h5>'.$rowCandidate["fname"].' '.$rowCandidate["lname"].'</h5>
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
        }else{
          $output.='<div class="form-group offset-3 col-6 align-self-center">
                      <div class="text-center styles_Card ">
                        <h2 class="text-responsive font-weight-bold">
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
    return $output;
  }else{
    
  }
}
/* End Function For SSG */
?>