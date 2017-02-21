<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Database\DataConnection;
use Illuminate\Support\Facades\Auth;
use App\Events\emailVerify;
use Illuminate\Support\Facades\Event;
use App\functions\functions;
use App\Mail\verification;
use App\Mail\forgotPassword;
use Hash;
use View;
Use DB;
use Session;


class UserController extends Controller{
	

////////////////////////// authenticating and welcome view////////////////////////////////////	
public function welcome()
{
		$user = Auth::user();
		
		//login  members will be redirected their dashboard according to their role
		
		if ($user->role=="admin"){
		 return redirect()->route('admindashboard');
	
		}
}


////////////////////////// sign Up ////////////////////////////////////
public function adminSignIn(Request $request)
	{	$this->validate($request,[
		   	'username' => 'required',
    		'email' => 'required',
    		'password' => 'required',
			'passwordreenter' => 'required|same:password',
			//'g-recaptcha-response' => 'required|captcha',
			]);
			
			$username =  $request['username'];
			$email =  $request['email'];
			$password =  $request['password'];
			$user= new User();
			$user->name = $username;
			$user->email= $email;
			$user->password = bcrypt($password);
			$user->emailverified = 0;
			$user->role ="admin";
			$user->save();
			
			//authenticating the user
			if(Auth::attempt(['email'=>$request['email'],'password'=>$request['password']])){
			
			
			return redirect()->route('admindashboard');
		}
		else
		{
		return redirect()->back()->withErrors(['authenticationFailed', 'Please re-enter your password']);
		}
			
		
	}
	
	
	////////////////////////// email verification after sign Up //////////////////////////////////// 
	public function admindashboard(Request $request){
		$user = Auth::user();
		$data ='https://localhost/estate/public/verifyMail?data='.$user->email;
		//\Mail::to ($user)->send(new verification($user,$data));
		return view('admindashboard')->with('data' ,$user);
	}
	
	
	////////////////////////// login /////////////////////////////////////////////////////////////
	public function logIn(Request $request)
	{
		$this->validate($request,[
    		'email' => 'required',
    		'password' => 'required'
			]);
			
		$email =  $request['email'];
		$password =  $request['password'];
		if(Auth::attempt(['email'=>$request['email'],'password'=>$request['password']])){
		
			return redirect()->route('admindashboard');
		}
		else
		{
		return redirect()->back()->withErrors(['authenticationFailed', 'Please re-enter your password']);
		}
	}
	
	////////////////////////// Sign Out/////////////////////////////////////
	public function signout(Request $request)
	{
		//flusing out the logged in user and then redirecting to the home page
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->to('/');
    }
	
	
	
	
	////////////////////////// verify email after sign Up/////////////////////////////////////
	
	public function verifyMail(Request $request)
	{
		$data= Input::get('data',false);
		$emailVerify = new functions();
		if($emailVerify->verification($data))
		{
			return view('emailverified');
		}
		{
			 return redirect()->to('/')->withErrors(['Verification Failed', 'Please retry']);
		}
	}
	
	////////////////////////// echeck sign Up email is availability/////////////////////////////////////
	
	public function emailCheck(Request $request)
	{
			$enteredEmail= $request['datafile'];
			if(DB::table('users')->where('email', '?')->setBindings([$enteredEmail])->exists())
			{
				echo '<div style="color: red;"> <b>'.$enteredEmail.'</b> is already in use! </div>|false';
			}
			else 
			{
				echo '<div style="color: green;"> <b>'.$enteredEmail.'</b> is avaialable! </div>|true';
			}	
	}
	
	///////////////////////////////change Password//////////////////////////////////////////////////////////

	
	public function changePass(Request $request){
		
		$this->validate($request,[
    		'oldPassword' => 'required',
    		'newPassword1' => 'required',
			'newPassword2' => 'required|same:newPassword1'
			]);
			
		$oldPass =  $request['oldPassword'];
		$newPass =  $request['newPassword1'];
		
		$user = Auth::user();
		$email=$user->email;
		
		//checking if the old password is correct
		if(Auth::attempt(['email'=>$email,'password'=>$oldPass])){
			
			
			$savingP= new functions();
			
			if($savingP->addNewPass($email,bcrypt($newPass)))
			
			{
				echo "Password changed successfully";
				//if password change success
			}
			
			else {
				
				//if password change not success
				
				}
			
			
		}
		
		}
		
		
	///////////////////////////////change UserName//////////////////////////////////////////////////////////	
	public function changeName(Request $request){
			
			$this->validate($request,[
    		'username' => 'required'
			]);
			
			$username= $request['username'];
			
			$email= Auth::user()->email;
			$savingN = new functions();
			
			if($savingN-> changeName($email,$username))
			
			{
				//if username change success
				echo "Name changed successfully";
				
			}
			
			else 
			{
				//if username change not success
				
			}
			
			}
			
			
	///////////////////////////////add Image/////////////////////////////////////////////////////////		
	/*	public function addImage(Request $request){
			
			$this->validate($request,[
    		'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
			]);
			
     		$file = $request->file('image');
			
			//echo 'File Name: '.$file->getClientOriginalName();
   
      	//Move Uploaded File
      	$destinationPath = 'upload/';
		
		$name= $file->getClientOriginalName();
		$extenT= explode('.',$name);
		$extension = $extenT[count($extenT)-1];
		
		$user = Auth::user();
		$email=$user->email;
		
		$func = new functions();
      	//$file->move($destinationPath,$file->getClientOriginalName());
		$temp= $func -> getID($email);
	
		
		Input::file('image')->move($destinationPath, $temp.'.'.$extension);
			}	
		
		*/
		
		public function addImage(Request $request){
			$data = $request['datafile'];
			/*
			$this->validate($request,[
    		'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
			]);
			*/
     		//$file = $request->file('datafile');
			
			//echo 'File Name: '.$file->getClientOriginalName();
   /*
      	//Move Uploaded File
      	$destinationPath = 'upload/';
		
		$name= $file->getClientOriginalName();
		$extenT= explode('.',$name);
		$extension = $extenT[count($extenT)-1];
		
		
      	//$file->move($destinationPath,$file->getClientOriginalName());
		$temp= $func -> getID($email);
	
		
		Input::file('datafile')->move($destinationPath, $temp.'.'.$extension);
		*/
		
		$user = Auth::user();
		$email=$user->email;
		
		$func = new functions();
		$temp= $func -> getID($email);
		
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);

		file_put_contents('image.png', $data);
		
			}
		
		
		///////////////////////////////forget Password//////////////////////////////////////////////////////////
		public function forgot(Request $request){
		
			$this->validate($request,[
    		'email' => 'required',
    		
			]);
		
			$email = $request['email'];
			$emailCheck = new functions();
		
		if($emailCheck -> checkEmail($email)){
			
			
			//send email to this email
			
			$random=$emailCheck->generateRandomString(10);
			
			$emailCheck->addRandom($email,$random);
			
			$user = new user();
			$user->email= $email;
			
			$data ='https://localhost/estate/public/forgotPassword?data='.$random;
			\Mail::to ($user)->send(new forgotPassword($data));
			
			}
			
		else {
			
			//give error that email doesn not exist in the databse
			}	
		
		}
		
		
		///////////////////////////////change forget Password/////////////////////////////////////////////////////////
		
		public function forgotPassword(Request $request){
				$data= Input::get('data',false);
				//check random verified and send email address to change the password
			
				$func = new functions();
				
				$email=$func->getEmail($data);
				
				return view('forgotPass')->with('data' ,$email);
				
			
			}	
			
		public function forgotFinal(){
			
			echo "save to the database and kick";
			
			
			}	
			

	
}

?>