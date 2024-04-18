document.addEventListener("DOMContentLoaded", function() {

  // for displaying extra information within table
  $(document).ready(function() {
    $('tr').click(function() {
      $(this).next('.more-info').slideToggle('fast');
    });
  });
});
  // for modal

  // const addBtn = document.getElementById("add-btn");
  // const updateBtn = document.getElementById("update-btn");
  // const hiddenIn = document.getElementById("btnClicked");


//   // ran into bug where if preventDefault is done in eventlistener then no modal shows and if hiddenIn.value is set after modal then value is set to empty string
//   addBtn.addEventListener("click", function(e){   
//     // console.log("test");
//     // sendDataToServer('addBtn');
//     // ajxWhichBtn('addbtn');
//     displayModal(e);
//   });
//   updateBtn.addEventListener("click", function(e){   
//     // sendDataToServer('updateBtn');
//     // ajxWhichBtn('updateBtn');
//     displayModal(e);
//   });

//   function displayModal(e) {
//     e.preventDefault();
//     console.log("Displaying modal...")

//     const modal = document.getElementById("modal");
//     const span = document.getElementsByClassName("close")[0];
    
//     modal.style.display = "block";

//     span.onclick = function() {
//         modal.style.display = "none";
//     }

//     window.onclick = function(e) {
//         if (e.target == modal) {
//             modal.style.display = "none";
//         }
//     }
//   }
// });

// tried to use ajax but failed the data would send to page but wouldn't recognise it when operated on
// function sendVarToServer(varName, varData) {
//   var requestData = {};
//   requestData[varName] = varData;

//   $.ajax({
//       url: "index.php",
//       method: "POST",
//       data: requestData,
//       success: function(response) {
//           console.log("Data sent successfully!");
//       },
//       error: function(xhr, status, error) {
//           console.error("Error sending data: ", error);
//       }
//   });
// }

// const sendDataToServer = (buttonClicked) => {
//   const data = { btnClicked: buttonClicked };

//   fetch('../server/json-handle.php', {
//     method: 'POST',
//     headers: {
//       'Content-Type': 'application/json'
//     },
//     body: JSON.stringify(data)
//   })
//   .then(response => response.json())
//   .then(data => console.log(data))
//   .catch(error => console.error('There was an error!', error));
// }    ../components/buttons/add-updateBtns.php

// function ajxWhichBtn(buttonName) {
//   var xht = new XMLHttpRequest();
//   xht.open("POST", "../components/buttons/add-updateBtns.php", true);
//   xht.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//   xht.onreadystatechange = function() {
//     if(xht.readyState === XMLHttpRequest.DONE) {
//       if(xht === 200) {
//         console.log(xht.responseText);
//       } else {
//         console.log("Error: " + xht.status);
//       }
//     }
//   };
//   xht.send("buttonClicked="+buttonName);
// });