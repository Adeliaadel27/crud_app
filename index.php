<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fontawesome-free-6.4.2-web\css\all.css">
    <script src="fontawesome-free-6.4.2-web\css\all.css" crossorigin="anonymous"></script>
    <title>CRUD Application</title>
</head>
<body style="color: white; background-color: #1d2630;">
    <div class="container mt-5" id="content-contact">
        <div class="text-center">
            <h1 class="display-5 mb-5"><strong>CRUD Application</strong></h1>
        </div>
        <div class="main row justify-content-center">
        <form action="" id="student-form" class="row justify-content-center mb-4" autocomplete="off">
         <label for="firstName">First Name</label>
         <div class="input-group coll-10 mb-3">
                <input class="form-control" id="firstName" type="text" placeholder="Enter First Name" onkeyup="validatefirstname()">
                <span id="firstname-error"></span>
            </div>
             <label for="lastName">Last Name</label>
                <div class="input-group coll-10 mb-3">
                <input class="form-control" id="lastName" type="text" placeholder="Enter Last Name" onkeyup="validatelastname()">
                <span id="lastname-error"></span>
            </div>
             <label for="rollNo">Roll No</label>
                <div class="input-group coll-10 mb-3">
                <input class="form-control" id="rollNo" type="tel" placeholder="Enter Roll No" onkeyup="validaterollNo()">
                <span id="rollNo-error"></span>
            </div>
            <div class="col-15">
                <input class="btn btn-success add-btn" type="submit" value="Submit" onclick="return validateform()">
                <span id="submit-error"></span>
            </div>
        </form>
        <div class="col-13 mt-5">
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Roll No</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="student-list">
                    <tr>
                        <td>Dear</td>
                        <td>Programmer</td>
                        <td>25</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm edit">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm delete">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
var selectedRow = null;
var firstnameError = document.getElementById('firstname-error');
var lastnameError = document.getElementById('lastname-error');
var rollNoError = document.getElementById('rollNo-error');
var submitError = document.getElementById('submit-error');

function validatefirstname(){
    var firstname = document.getElementById('firstName').value;

    if(firstname.length == 0){
        firstnameError.innerHTML = 'Name is required';
        return false;
    }
    if(!firstname.match(/^[A-Za-z]*\s{1}[A-Za-z]*$/)){
        firstnameError.innerHTML = 'Write first name';
        return false;
    }
    firstnameError.innerHTML = '<i class="fas fa-check-circle"></i>';
    return true;
}
function validatelastname(){
    var lastname = document.getElementById('lastName').value;

    if(lastname.length == 0){
        lastnameError.innerHTML = 'Name is required';
        return false;
    }
    if(!lastname.match(/^[A-Za-z]*\s{1}[A-Za-z]*$/)){
        lastnameError.innerHTML = 'Write last name';
        return false;
    }
    lastnameError.innerHTML = '<i class="fas fa-check-circle"></i>';
    return true;
}
function validaterollNo(){
    var rollNo = document.getElementById('rollNo').value;

    if(rollNo.length == 0){
        rollNoError.innerHTML = 'number is required';
        return false;
    }
    if(rollNo.length !== 10){
        rollNoError.innerHTML = 'number should be 10 digits';
        return false;
    }
    if(!rollNo.match(/^[0-9]{10}$/)){
        rollNoError.innerHTML = 'Only digits please.';
        return false;
    }
    rollNoError.innerHTML = '<i class="fas fa-check-circle"></i>';
    return true;
}
function validateform(){
    if(!validatefirstname() || !validatelastname() || !validaterollNo()){
        submitError.style.display = 'block';
        submitError.innerHTML = 'Please fix error to submit';
        setTimeout(function(){submitError.style.display = 'none';}, 3000);
        return false;
    }
}
function showAlert(message, className){
    const div = document.createElement("div");
    div.className = `alert alert-${className}`;

    div.appendChild(document.createTextNode(message));
    const container = document.querySelector(".container");
    const main = document.querySelector(".main");
    container.insertBefore(div, main);

    setTimeout(() => document.querySelector(".alert").remove(), 3000);
}

function clearFields(){
    document.querySelector("#firstName").value = "";
    document.querySelector("#lastName").value = "";
    document.querySelector("#rollNo").value = "";
}

document.querySelector("#student-form").addEventListener("submit", (e) =>{
    e.preventDefault();

    const firstName = document.querySelector("#firstName").value;
    const lastName = document.querySelector("#lastName").value;
    const rollNo = document.querySelector("#rollNo").value;

    if(firstName == "" || lastName == "" || rollNo == ""){
        showAlert("Please fill in all fields", "danger");
    }
    else{
        if(selectedRow == null){
            const list = document.querySelector("#student-list");
            const row = document.createElement("tr");

            row.innerHTML = `
            <td>${firstName}</td>
            <td>${lastName}</td>
            <td>${rollNo}</td>
            <td>
            <a href="#" class="btn btn-warning btn-sm edit">Edit</a>
            <a href="#" class="btn btn-danger btn-sm delete">Delete</a>
            `;
            list.appendChild(row);
            selectedRow = null;
            showAlert("Student Added", "success");
        }
        else{
            selectedRow.children[0].textContent = firstName;
            selectedRow.children[1].textContent = lastName;
            selectedRow.children[2].textContent = rollNo;
            selectedRow = null;
            showAlert("Student Info Edited", "info");
        }
        
        clearFields();
    }
});

    document.querySelector("#student-list").addEventListener("click", (e) =>{
        target = e.target;
        if(target.classList.contains("edit")){
            selectedRow = target.parentElement.parentElement;
            document.querySelector("#firstName").value = selectedRow.children[0].textContent;
            document.querySelector("#lastName").value = selectedRow.children[1].textContent;
            document.querySelector("#rollNo").value = selectedRow.children[2].textContent;
        }
});

document.querySelector("#student-list").addEventListener("click", (e) =>{
    target = e.target;
    if(target.classList.contains("delete")){
        target.parentElement.parentElement.remove();
        showAlert("Student Data Deleted", "danger");
    }
}); 
</script>
</body>
</html>