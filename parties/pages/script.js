const forms= document.querySelector(".forms"),
         pwShowHide = document.querySelectorAll(".icon-hid"),
         links = document.querySelectorAll(".link");

 pwShowHide.forEach(eyeIcon => {

    eyeIcon.addEventListener("click", () => {
        let pwFields = eyeIcon.parentElement.parentElement.querySelectorAll(".password");
        pwFields.forEach(password => {
              if(password.type === "password"){
                  password.type = "text";
                  icon-hid.classList.replace("bx-hide","bx-show");
                  return;
              }
              password.type = "password";
              icon-hid.classList.replace("bx-show","bx-hide");
        })

   
    })
 })

 links.forEach(link => {

      link.addEventListener("click", e =>{
            e.preventDefault();
            forms.classList.toggle("show-format")

      })

 })