const form = document.getElementById('myForm');
const fname = document.getElementById('firstName');
const lname = document.getElementById('lastName');
const voterCollege = document.getElementById('college');
const year = document.getElementById('year');
const studID = document.getElementById('studID');
const password = document.getElementById('pass');
const email = document.getElementById('email');


//error
const errorFname = document.getElementById('errorFirstName');
const errorLname = document.getElementById('errorLastName');
const errorCollege = document.getElementById('errorCollege');
const errorID = document.getElementById('errorID');
const errorPassword = document.getElementById('errorPassword');
const errorYearLevel = document.getElementById('errorYearLevel');
const errorEmail = document.getElementById('errorEmail');

form.addEventListener ('submit', (e) => {
    let messages =[];
    var regexAlpha = /^[a-zA-Z ]*$/;
    var regexID = /^[0-9]{4}[-][0-9]{5}$/;
    var regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var regexPass = /^(0?[1-9]|1[0-2])\-(0?[1-9]|1\d|2\d|3[01])\-(19|20)\d{2}$/;

    var fnameResult = regexAlpha.test(fname.value);
    var lnameResult = regexAlpha.test(lname.value);
    var idResult = regexID.test(studID.value);
    var emailResult = regexEmail.test(email.value);
    var passwordResult = regexPass.test(password.value);


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
    if(voterCollege.options[voterCollege.selectedIndex].text == 'Choose College...'){
        e.preventDefault();
        errorCollege.innerHTML = "Required Field";
        voterCollege.focus();
        return false;
    }else{
        errorCollege.innerHTML ="";
    }

    if(year.options[year.selectedIndex].text == 'Choose Year Level...'){
        e.preventDefault();
        errorYearLevel.innerHTML = "Required Field";
        year.focus();
        return false;
    }else{
        errorYearLevel.innerHTML ="";
    }

    if(studID.value == ""){
        e.preventDefault();
        errorID.innerHTML = "Required Field";
        studID.focus();
        return false;
    }else{
        errorID.innerHTML = " ";
    }

    if(password.value == ""){
        e.preventDefault();
        errorPassword.innerHTML = "Required Field";
        password.focus();
        return false;
    }else if(passwordResult == false){
        e.preventDefault();
        errorPassword.innerHTML = "Birthday is not valid";
        password.focus();
        return false;
    }else{
        errorPassword.innerHTML=  "";
    }
     if(email.value == ""){
        e.preventDefault();
        errorEmail.innerHTML = "Required Field";
        email.focus();
        return false;
    }else{
        errorEmail.innerHTML = " ";
    }

    

});