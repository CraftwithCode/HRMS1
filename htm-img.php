<!DOCTYPE html> 
<html> 
  
<head>
	<title> How to convert an HTML element or document into image ?</title>       
    <script src= "https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
    <script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script>
    <style>
    	.certificate {
    		background-color: #f6f6f6;
    		width: 800px;
    		background-image: url(assets/certificate.png);
    		background-repeat: no-repeat;
    		background-size: 100% 100%;
    		padding: 20px 50px;
    	}
    	.certificate h2 {
			color: #1f8dbf;
			margin: 10px;
			font-size: 40px;
			letter-spacing: 1.2px;
		}
    </style> 
</head>  
<body> 
    <center>
    	<div id="html-content-holder" class="certificate">  
	        <h2 style="color: #3e4b51;">Certificate</h2>
	        <hr style="width: 700px;" />
	        <p style="color: #3e4b51;">This is to certify that Mr. / Ms. [EMPLOYEE] successfully completed the course with on certificate for [COURSE].</p>
	        <p class="sign">[OWNER]</p>
	        <p class="sign"><?=date('d M Y',time())?></p>
	    </div>
	    <input id="btn-Preview-Image" type="button" value="Preview" />
	    <a id="btn-Convert-Html2Image" href="#">Download</a> 
	    <br/>
	    
	    <div id="previewImage"></div>
	    <script> 
	        $(document).ready(function() { 
	            // Global variable 
	            var element = $("#html-content-holder");
	            // Global variable 
	            var getCanvas;
	            // $("#btn-Preview-Image").on('click', function() { 
	                html2canvas(element, { 
	                    onrendered: function(canvas) { 
	                        $("#previewImage").append(canvas); 
	                        getCanvas = canvas; 
	                    } 
	                }); 
	            // });
	            $("#btn-Convert-Html2Image").on('click', function() { 
	                var imgageData =  
	                getCanvas.toDataURL("image/png");
	                // Now browser starts downloading 
	                // it instead of just showing it 
	                var newData = imgageData.replace( 
	                /^data:image\/png/, "data:application/octet-stream"); 
	                $("#btn-Convert-Html2Image").attr("download", "Certificate.png").attr("href", newData); 
	            }); 
	        }); 
	    </script> 
    </center> 
</body> 
  
</html> 