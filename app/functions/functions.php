<?php
namespace App\functions;
use View, Input, Redirect;
use DB;
use App\ForgotPass;
class functions {


	function generateRandomString($length ) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}
	
	
		function checkUserVerification($mail)
	{
		if ((DB::table('users')->where('email',$mail)->value('emailverified'))===0)
		{
		
	
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function verification ($mail)
	{
			DB::table('users')
            ->where('email', $mail)
            ->update(['emailverified' => 1]);	
			return true;
	}
	
	function addNewPass($email,$pass){
		
			DB::table('users')
            ->where('email', $email)
            ->update(['password' => $pass]);	
			return true;
		
		}
		
		function changeName($email,$username){
			DB::table('users')
            ->where('email', $email)
            ->update(['name' => $username]);	
			return true;
			
			
			}
			
		function getID($email){
			$user = DB::table('users')->where('email',$email)->pluck('id');
			
			return  $user[0];
			
			
			}	
			
		 
		 function checkEmail($email){
		
		$user = DB::table('users')->where('email',$email)->pluck('id');
		
		if($user[0]>0){
			
		/////////////valide user to send email//////////////////	
		
		return true;
			
		}
		
		else{
			
		return false;
			
			}
		
		}	
		
		
		function checkRandom($value){
			
		$user = DB::table('forgot')->where('random',$value)->pluck('id');
		
		if($user[0]>0){
			
		/////////////valide user to send email//////////////////	
		
		return true;
			
		}
		
		else{
			
		return false;
			
		}
		
		}
		
		function addRandom($email,$value){
			
			DB::table('forgot')->insert(
    		['email' => $email, 'random' => $value]
			);
			
			}
			
		function getEmail($value){
			
			$user = DB::table('forgot')->where('random',$value)->pluck('email');
			
			return $user[0];
			}	

}
?>