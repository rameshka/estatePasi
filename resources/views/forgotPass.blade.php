

<!DOCTYPE html>

    <head>
<meta name = "_token" content= "{{csrf_token()}}">
	</head>
    <body>
    
  <form action='{{route('forgot')}}' method="post">
 <label>Enter your email here:</label>
    <input type="email" name="email" required autocomplete="off"/><br>
    
      <input type="hidden" name="_token" value = "{{ csrf_token() }}" /><br>
     <input type="submit" value="Send" id="fPassword" ><br>
</form>



	<H2>Change Password</H2>
   <form action='{{route('forgotFinal')}}' method="post" style="margin-top:20px">
    <label> New Password:</label>
    <input type="password" name="newPassword1" id="password" required /><br>
    
     <label> Re-enter New Password:</label>
    <input type="password" name="newPassword2" id="password" required />
    
    <input type="email" name="email" value=<?php echo "rameshkafox@gmail.com" ?> hidden="" />
    
      <input type="hidden" name="_token" value = "{{ csrf_token() }}" /><br>
     <input type="submit" value="submit" id="submitPass" ><br>
</form>

    
    </body>
</html>