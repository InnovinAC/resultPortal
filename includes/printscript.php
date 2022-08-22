<script>
$(document).ready(function () {


		$("#printabl").click(function(){
			$("#printable").printMe({
				"path" : ["../css/bootstrap.min.css","../fontawesome/css/all.min.css?2","../css/dataTables.bootstrap5.min.css","../css/additional.css"]
			});
		});

		$("#example3").click(function(){
			$("#dataexample3").printMe({
				"path" : ["example.css"],
				"title" : "Document title"
			});
		});


	});
	</script>
