var college2 = {
    "College of Arts and Sciences":["AB in Literature and Cultural Studies",
        "BS in Biology",
        "BS in Statistics",
        "BS in Mathematics",
        ],
    "College of Technology":["Diploma of Technology major in Electronics Technology",
        "Bachelor of Industrial Technology major in Electrical Technology",
        "Bachelor of Industrial Technology Electronics Technology",
        "Bachelor of Technical Teacher Education major in Computer Technology",
        "Bachelor of Technical Teacher Education major in Electronics Technology",
        "Bachelor of Technical Teacher Education major in Mechanical Technology",
        "Bachelor of Science in Computer Technology",
        ],
    "College of Education":["BSEd in Mathematics",
        "BSEd in English",
        "BSEd in Science",
        "Bachelor of Elementary Education",
        "Bachelor of Early Childhood Education",
        "Bachelor of Special Needs Education",
        "Bachelor of Physical Education",
        "Bachelor of Technology and Livelihood Education in Home Economics",
        "Bachelor of Technical-Vocational Teacher Education",
        ],
    "College of Engineering":["BS in Mining Engineering",
        "BS in Mechanical Engineering",
        "BS in Electronics Engineering",
        "BS in Electrical Engineering",
        "BS in Civil Engineering",
        "BS in Sanitary Engineering",
        "BS in Geology",
        "BS in Geodetic Engineering",
        ],
    "College of Information and Computing":["BS in Information Technology",
        "BS in Computer Science",
        "Bachelor of Library and Information Science",
        ],

    "College of Applied Economics":["BS in Economics",
       
    ],
    "College of Business Administration":[
        "BS in Business Administration",
        "BS in Hospitality Management",
        "BS in Entrepreneurship",
        "BS in Accountancy",
    ],
    "College of Development Management":[
        "BS in Agricultural Economics ",
        "BS in Agricultural Business",
        "BS in Community Development",
        "Bachelor of Public Administration",
        "BS in Development Anthropology",
    ],
    "College of Teacher Education and Technology":[
        "Bachelor of Elementary Education",
        "Bachelor of Special Needs Education",
        "Bachelor of Early Childhood Education",
        "BSEd in Mathematics",
        "BSEd in English",
        "BS Information Technology",
        "Bachelor of Technical-vocational Teacher Education in Agricultural Crops Technology",
        "Bachelor of Technical-vocational Teacher Education in Animal Production",
    ],
    "College of Agriculture and Related Sciences":[
        "BS in Agriculture",
        "BS in Forestry",
        "BS in Agricultural and Biosystems",
    ],
    "New College":[
        "Choose Program..."
    ]
  
}

var menu2 = document.getElementById("newCollege");
var sub2 = document.getElementById("newProgram");   

menu2.addEventListener('change',function(){

    var selected_option = college2[this.value];
    // selected_option = college['cic']
    console.log("dsd");
    console.log(selected_option);
    while(sub2.options.length >0){
        sub2.options.remove(0);
    }

    Array.from(selected_option).forEach(function(el){
        let option = new Option(el,el);
        sub2.appendChild(option);
    });

});
