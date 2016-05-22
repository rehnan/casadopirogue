
</div>
<footer>Footer Login</footer>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.12.3.min.js") ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.min.js") ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/owl.carousel.min.js") ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery.steps.min.js") ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/geral.js") ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/order.js") ?>"></script>


<!--  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGlXHsXhyU5qL9BfeUuh9VcsC8V6hgzxw"  type="text/javascript"></script> -->
<script type="text/javascript">

        $("#example-basic").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            autoFocus: true,
            labels: {
                cancel: "Cancelar",
                current: "Passo Atual:",
                pagination: "Pagination",
                finish: "Finalizar Pedido",
                next: "Próximo Passo",
                previous: "Voltar ",
                loading: "Carregando ..."
            }
        });

        //https://github.com/rstaib/jquery-steps/wiki/Settings
        //http://www.jquery-steps.com/GettingStarted#download


</script>

</body>
</html>