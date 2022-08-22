        <script>  $(document).ready(function(){
$("span.toggler").click(changeClass);
 function changeClass() {
       $("#toggler-icon").toggleClass("fa-bars fa-times");
    }
    });</script>

<script>
   $(function () {
            $("#code").click(function () {
                $(this).toggleClass("bg-dark bg-white text-white text-dark border border-primary"); });
}); </script>
<script>
// prevent resubmission of data on reload
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

<div class="mt-4"><footer class="mt-25 py-2 pl-4 border-top text-left"><span class="d-flex justify-content-center">&copy;<?php echo date("Y");?> School Portal.</span><span class="d-flex innovin justify-content-center">Built With&nbsp;<span style="font-size:15px" class="text-danger">&#9829;</span>&nbsp;& <span class="px-1 rounded-circle mx-1 bg-dark text-white" id="code">&lt;&sol;&gt;</span> by&nbsp;<a rel="developer" class="text-teal-dark" href="https://wa.me/2348054841869"><span itemprop="name">Innovin Anuonye</span></a>.</span><center>(Version 1.1)<center><!--<span class="d-flex justify-content-center">A Product Of&nbsp;<a href="https://wa.me/2348054841869" class="text-teal-dark">ICK Optimum Services Nig. Ltd.</a></span>-->
</footer>
</div>
