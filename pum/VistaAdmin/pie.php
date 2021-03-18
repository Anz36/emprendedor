 </section>
      </div>
    </div>
    <!-- Fin Page Content -->
  </div>
  <!-- Fin wrapper -->

  

  <!-- Bootstrap y JQuery -->
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> 
  <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>


</body>
  <!-- Abrir / cerrar menu -->
  <script>
    $("#menu-toggle").click(function (e) {
      e.preventDefault();
      $("#content-wrapper").toggleClass("toggled");
    });
  </script>

<script>
    let BtnItems = document.querySelectorAll('.item .btn-item');

    for(let i = 0 ; i <BtnItems.length ; i++){
        BtnItems[i].addEventListener('click', (e)=>{
            let btn = e.target;
            if(btn.classList == "btn-item active"){
                removerClase();
            }else{
                removerClase();
                btn.classList.add('active');
            }

        });
    }

    function removerClase(){
        for(let i = 0 ; i <BtnItems.length ; i++){
            BtnItems[i].classList.remove('active');
        }
    }
</script>
</body>

</html>