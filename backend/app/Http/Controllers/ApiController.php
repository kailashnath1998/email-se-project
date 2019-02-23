<?php
 
namespace App\Http\Controllers;
 
use App\Http\Requests\RegisterAuthRequest;
use App\User;
use App\Admins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Mail;
use Log;
 
class ApiController extends Controller
{

    public function check()
    {
        return response()->json(["success" => true,
                                'message' => 'API Works'
                                ],200);
    }

    public $loginAfterSignUp = false;
 
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(),[
             'username' => 'required|unique:users',
             'password' => 'required|min:6',
             'name' => 'required',
             'phoneNumber' => 'required|digits:10',
         ]);
 
         if ($validator->fails()) {
 
             return response()->json(["success" => false, "error" =>$validator->errors()->first()],400);
         }


        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->phoneNumber = $request->phoneNumber;
        $user->role = 1;
        $user->save();

 
        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }
 
        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }
 
    public function login(Request $request)
    {
        $input = $request->only('username', 'password');
        $jwt_token = null;
 
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }
 
        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ]);
    }
 
    public function logout(Request $request)
    {
        $this->validate($request, [
            'Authorization' => 'required'
        ]);
 
        try {

            $request->token = preg_split('Bearer ', ($request->Authorization))[0];

            error_log($request->token);

            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }
 

    public function conatctAdmin(Request $request) {
        
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $username = env('MAIL_USERNAME', NULL);

        if(!($username))
            return response()->json([
                'success' => false,
                'message' => 'Sorry, The mail settings are not configured'
            ], 500);

        $message_ = (string) $request->name  . '<br>' . (string) $request->email . '<br>' . (string)$request->subject . '<br>' . (string)$request->message;

        $admins = Admins::all();


        foreach ($admins as $admin) {
            error_log($username);
            try {
                Mail::send([], [], function ($message) use ($admin, $message_, $username) {
                    $message->from($username, 'MAIL HANGER');
                    $message->to($admin->email);
                    $message->subject('Message from User');
                    $message->setBody($message_ , 'text/html');
                    $message->priority(3);
                });
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, The mail was not sent to all admins'
                ], 500);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Mail sent successfuly'
        ], 500);

    }

    public function getAuthUser(Request $request)
    {
        return response()->json(['user' => $request->user, 'role' => $request->user->role]);
    }
}