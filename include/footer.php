
<script>

  function handleClick(id){
    const form = document.getElementById(id)
    if(form.style.display=='none'){
      form.style.display ='';
    }else{
      form.style.display = 'none'
    }
  }


  document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("darkToggle");

    if (localStorage.getItem("darkMode") === "on") {
        document.body.classList.add("dark-mode");
        if (toggle) toggle.checked = true;
    }

    if (toggle) {
        toggle.addEventListener("change", function () {
            if (this.checked) {
                document.body.classList.add("dark-mode");
                localStorage.setItem("darkMode", "on");
            } else {
                document.body.classList.remove("dark-mode");
                localStorage.setItem("darkMode", "off");
            }
        });
    }
});


</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>



