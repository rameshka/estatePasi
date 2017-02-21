<!DOCTYPE html>

    <head>
		<meta name = "_token" content= "{{csrf_token()}}">
        
        <style>
		div.cropbox .btn-file {
    		position: relative;
    		overflow: hidden;
		}
		div.cropbox .btn-file input[type=file] {
   			 position: absolute;
    		top: 0;
    		right: 0;
    		min-width: 100%;
    		min-height: 100%;
    		font-size: 100px;
    		text-align: right;
    		filter: alpha(opacity=0);
    		opacity: 0;
    		outline: none;
    		background: white;
    		cursor: inherit;
    		display: block;
		}
	div.cropbox .cropped {
   			 margin-top: 10px;
		}

</style>

	<link href="ImageUpload/jquery.cropbox.min.css" rel="stylesheet" type="text/css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
	<script src="https://superal.github.io/canvas2image/canvas2image.js"></script>
	<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
	</head>
    <body>
    
    
    
<?php echo $data->name; ?>
    <H1> welcome to admin dashboard </H1>
    
    
     <a href="{{ URL::route('paypal') }}"><button>Go to paypal </button></a>
     
    <a href="{{ URL::route('signout') }}"><button>Sign Out </button></a>
    
    <br>
    
    
    
    <H2>Change Password</H2>
   <form action='{{route('changePass')}}' method="post" style="margin-top:20px">
 <label>Password</label>
    <input type="password" name="oldPassword" required /><br>
    <label> New Password:</label>
    <input type="password" name="newPassword1" id="password" required /><br>
    
     <label> Re-enter New Password:</label>
    <input type="password" name="newPassword2" id="password" required />
      <input type="hidden" name="_token" value = "{{ csrf_token() }}" /><br>
     <input type="submit" value="submit" id="submitPass" ><br>
</form>


    <H2>Change Username</H2>
   <form action='{{route('changeName')}}' method="post" style="margin-top:20px">
 	
    <label>Username:</label>
    <input type="text" name="username" required /><br>


      <input type="hidden" name="_token" value = "{{ csrf_token() }}" /><br>
     <input type="submit" value="submit" id="submitName" ><br>
</form>



    <H2>Add Picture</H2>
   <!--form action='{{route('addImage')}}' method="post" enctype="multipart/form-data" style="margin-top:20px">
 	
    <label>Upload Image Here:</label>
    <input type="file" name="image" required /><br>


      <input type="hidden" name="_token" value = "{{ csrf_token() }}" /><br>
     <input type="submit" value="upload" id="uploadImage" ><br>
</form---------->


<!----------------------------------------------------------------------------------------->
<div id="message" class="alert alert-info"></div> 
<div id="plugin" class="cropbox">
    <div class="workarea-cropbox">
        <div class="bg-cropbox">
            <img class="image-cropbox">
            <div class="membrane-cropbox"></div>
        </div>
        <div class="frame-cropbox">
            <div class="resize-cropbox"></div>
        </div>
    </div>
    <div class="btn-group">
        <span class="btn btn-primary btn-file">
            <i class="glyphicon glyphicon-folder-open"></i>
            Browse <input type="file" accept="image/*">
        </span>
        <button type="button" class="btn btn-success btn-crop" disabled="">
            <i class="glyphicon glyphicon-scissors"></i> Crop
        </button>
        <button type="button" class="btn btn-warning btn-reset">
            <i class="glyphicon glyphicon-repeat"></i> Reset
        </button>
    </div>
    <div class="cropped panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Result of cropping</h3></div>
        <div class="panel-body" id="widget">...</div>
    </div>
    <div class="form-group">
        <label>Info of cropping</label>
        <textarea class="data form-control" rows="5"></textarea>
        <button id= "show">Show</button>
    </div>
</div>

<input type="file" id="bannerImg"  />

<div id="res"></div>
<script src="ImageUpload/jquery.cropbox.min.js"></script>
<script>
$('#plugin').cropbox({
    selectors: {
        inputInfo: '#plugin textarea.data',
        inputFile: '#plugin input[type="file"]',
        btnCrop: '#plugin .btn-crop',
        btnReset: '#plugin .btn-reset',
        resultContainer: '#plugin .cropped .panel-body',
        messageBlock: '#message'
    },
    imageOptions: {
        class: 'img-thumbnail',
		id:'pasi',
        style: 'margin-right: 5px; margin-bottom: 5px'
    },
    variants: [
        {
            width: 200,
            height: 200,
            minWidth: 180,
            minHeight: 200,
            maxWidth: 350,
            maxHeight: 350
        },
        {
            width: 150,
            height: 200
        }
    ],
    messages: [
        'Crop a middle image.',
        'Crop a small image.'
    ]
});

</script>
<script>
$(function() { 
    $("#show").click(function() { 
       // html2canvas($("#widget"), {
            //onrendered: function(canvas) {
              //  theCanvas = canvas;
                //document.body.appendChild(canvas);

                // Convert and download as image 
                //Canvas2Image.saveAsPNG(canvas); 
				// var image = Canvas2Image.convertToPNG(canvas);
               var image_data = $("#pasi").attr('src');
			   var token = $('meta[name="_token"]').attr('content');
				var urlData='{{route("addImage")}}';
				$.ajax({
    			type: "POST",
    			url: urlData ,
    			data: { _token:token , 'datafile':image_data},
    			cache: false,
    			success: function(data)
    				{	
    				}
    			});
			   //console.log(image);
                //$("#img-out").append(canvas);
                // Clean up 
                //document.body.removeChild(canvas);
         //   }
       // });
    });
}); 
</script>

</body>

</html>