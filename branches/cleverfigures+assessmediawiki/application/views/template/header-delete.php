	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
	<script>
	 $(document).ready(function(){
	   $(".delete-link").click(function(event){
		 var answer = confirm('Seguro que quieres borrar?');
		 return answer; 
	   });
	 });
	</script>