function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
    
  }
  
  function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
  }

// var addNewRow = document.querySelector(".addNewRow");

// addNewRow.addEventListener('click', function(e){
//   addNewRow.innerHTML = "<select name='tillDept' id='sales_overrings_till_dept'> " +
//   "<option value=''></option>" +
//   "<option value='&#8593';>&#8593;</option>" +
//   "<option value='&#8595;'>&#8595;</option>" +
//   "</select>" +
//   "<select name='cOrV' id=''>" +
//   "<option value=''></option>" +
//   "<option value='C'>C</option>" +
//   "<option value='V'>V</option>" +
//   "</select>" +
//   "<input type='number' class='numberInput'>"
//   addNewRow.classList.add('.sheetBodyContainer', '.salesOverRing');
//   e.preventDefault();
// });
