	<html>
		<head>
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<style>
			#newnotedata{
			font: normal 15px 'Courgette', cursive;
			line-height: 17px;
			color:#444;
			background-color:#eeeeee;
			display: block;
			border: none;
			width: 329px;
			min-height: 170px;
			overflow: hidden;
			resize: none;
			outline: 0px;
			padding: 10px;
		}
		</style>
		</head>
		<body>
			<div class="panel-body">
					<h2>Your Notes</h2>
					<div class="">
						<form id="saveNote" action="#">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<textarea name="updated_content" id="newnotedata"></textarea>
							<button type="submit">Save Note</button>
						</form>
					</div>       
		    </div>
		    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		    <script>
		    		$.ajaxSetup({
		    			headers: {
		    				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    			}
		    		});
		    		$(document).ready(function(){
		    			$.ajax({
			    				type: "GET",
			    				url: '{{ route('newnote.store') }}',
			    				dataType: 'json',
			    				success: function(data){
			    					for (var x = 0; x < data.length; x++) {
                						content = data[x].note_content;
                						$('#newnotedata').append(content); 
			    					}
			    				}
			    			});

		    			function saveNote(){
			    			var newtext = $('#newnotedata').val();
			    		
			    			var newcontent = "note_content="+newtext;
			    			$.ajax({
			    				type: "POST",
			    				url: '{{ route('newnote.store') }}',
			    				data: newcontent,
			    				success: function(data){
			    					console.log(data);
			    					alert('Note Saved!');
			    				}
			    			});
			    		}

			    		$('#saveNote').submit(function(){
			    			saveNote();
			    			return false;
			    		});
			    		
		    		});
	   		</script>
	   	</body>
</html>