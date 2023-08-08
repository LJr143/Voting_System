const form = document.getElementById('addNomineeForm');
const fname = document.getElementById('firstName');
const lname = document.getElementById('lastName');
const studID = document.getElementById('studID');
const photoUpload = document.getElementById('photoLabel');
const studCollege = document.getElementById('college');
const program = document.getElementById('program');
const yearLevel = document.getElementById('year');
const party = document.getElementById('party');
const position = document.getElementById('position');


//error 
const errorFname = document.getElementById('errorFirstName');
const errorLname = document.getElementById('errorLastName');
const errorID = document.getElementById('errorID');
const errorPhotoUpload = document.getElementById('errorPhotoUpload');
const errorCollege = document.getElementById('errorCollege');
const errorProgram = document.getElementById('errorProgram');
const errorYearLevel = document.getElementById('errorYearLevel');
const errorParty = document.getElementById('errorParty');
const errorPosition = document.getElementById('errorPosition');

form.addEventListener ('submit', (e) => {
    let messages =[];
    var regexAlpha = /^[a-zA-Z ]*$/;
    var regexID = /^[0-9]{4}[-][0-9]{5}$/;

    var fnameResult = regexAlpha.test(fname.value);
    var lnameResult = regexAlpha.test(lname.value);
    var idResult = regexID.test(studID.value);

    if(fnameResult == false){
        e.preventDefault();
        errorFname.innerHTML = "Invalid First Name";
        fname.focus();
        return false;
    }else if(fname.value == ""){
        e.preventDefault();
        errorFname.innerHTML = "Required Field";
        fname.focus();
        return false;
    }else{
        errorFname.innerHTML = " ";
    }

    
    if(lnameResult == false){
        e.preventDefault();
        errorLname.innerHTML = "Invalid Last Name";
        lname.focus();
        return false;
    }else if(lname.value == ""){
        e.preventDefault();
        errorLname.innerHTML = "Required Field";
        lname.focus();
        return false;
    }else{
        errorLname.innerHTML = " ";
    }

    
    if(studCollege.options[studCollege.selectedIndex].text == 'Choose College...'){
        e.preventDefault();
        errorCollege.innerHTML = "Required Field";
        studCollege.focus();
        return false;
    }else{
        errorCollege.innerHTML ="";
    }
    
    if(program.options[program.selectedIndex].text == 'Choose Program...'){
        e.preventDefault();
        errorProgram.innerHTML = "Required Field";
        program.focus();
        return false;
    }else{
        errorProgram.innerHTML ="";
    }
     
    if(yearLevel.options[yearLevel.selectedIndex].text == 'Choose Year Level...'){
        e.preventDefault();
        errorYearLevel.innerHTML = "Required Field";
        yearLevel.focus();
        return false;
    }else{
        errorYearLevel.innerHTML ="";
    }

    if(party.options[party.selectedIndex].text == 'Choose Party...'){
        e.preventDefault();
        errorParty.innerHTML = "Required Field";
        party.focus();
        return false;
    }else{
        errorParty.innerHTML ="";
    }

    if(position.options[position.selectedIndex].text == 'Choose Position...'){
        e.preventDefault();
        errorPosition.innerHTML = "Required Field";
        position.focus();
        return false;
    }else{
        errorPosition.innerHTML ="";
    }
    

    if(studID.value == ""){
        e.preventDefault();
        errorID.innerHTML = "Required Field";
        studID.focus();
        return false;
    }else{
        errorID.innerHTML = " ";
    }

    if(photoUpload.innerText == "Upload Photo"){
        e.preventDefault();
        errorPhotoUpload.innerHTML = "Attach an image";
        photoUpload.focus();
        return false;
    }else{
        errorPhotoUpload.innerHTML = "";
    }

})