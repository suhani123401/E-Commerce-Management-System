<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("darkToggle");
    if(localStorage.getItem("darkMode") === "on"){
        document.body.classList.add("dark-mode");
        if(toggle) toggle.checked = true;
    }
    if(toggle){
        toggle.addEventListener("change", function(){
            if(this.checked){
                document.body.classList.add("dark-mode");
                localStorage.setItem("darkMode","on");
            } else {
                document.body.classList.remove("dark-mode");
                localStorage.setItem("darkMode","off");
            }
        });
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
