<?php
namespace App\Http\Middleware;
use App\functions\functions;
use Closure;

class emailMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       $mail = $request->input('data');
	   $value = new functions();
	   
	   
	   if(strpos($mail, '@'))
	   {
      		 
	   		if ($value->checkUserVerification($mail))
			{
		 	}
		 	else {
			 	$message= "Your account already verified!";
				return redirect()->route('home')->with('message',$message);
			 }
		}
		
		else{
			
			if ($value->checkRandom($mail))
			{
		 	}
		 	else {
			 	$message= "URl expired!";
				return redirect()->route('home')->with('message',$message);
			 }
			
			
			
			}
 

        return $next($request);
    
    }
}
