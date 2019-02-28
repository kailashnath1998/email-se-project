<?php
 
namespace App\Http\Controllers;
 
use App\Http\Requests\RegisterAuthRequest;
use App\User;
use App\Admins;
use App\Email;
use App\Type;
use App\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
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

    public function changePassword(Request $request) {
        $validator = Validator::make($request->all(),[
            'crrpassword' => 'required|min:6',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
 
            return response()->json(["success" => false, "error" =>$validator->errors()->first()],400);
        }

        $user = User::where('username', $request->user->username)->first();
        if(Hash::check($request->crrpassword, $user->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'update successfull'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'password mismatch'
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


    public function send(Request $request) {

        $validator = Validator::make($request->all() + ['from' => $request->user->username],[
            'from' => 'required|exists:users,username',
            'to' => 'required|exists:users,username',
            'subject' => 'required|min:1',
            'message' => 'required|min:1',
        ]);


        if ($validator->fails()) {
 
            return response()->json(["success" => false, "error" =>$validator->errors()->first()],400);
        }

        $mail = new Email();

        $mail->from = $request->user->username;
        $mail->to = $request->to;
        $mail->subject = $request->subject;
        $mail->content = $request->message;
        $mail->type = 1;

        if($request->reply)
            $mail->reply = $request->reply;
        else
            $mail->reply = null;

        $mail->save();        

        return response()->json(['success' => true, 'message' => 'sent successfuly']);
    }

    public function recive(Request $request) {

        $request->to = $request->user->username;
        $request->type = 1;

        $mails = Email::where(['to', $request->to, 'is_draft' => false])
                        ->where('type', $request->type)->get();

        
        return response()->json(['success' => true, 'message' => $mails]);
    }

    public function message(Request $request) {
        $validator = Validator::make($request->all(),[
            'id' => 'required',
        ]);


        if ($validator->fails()) {
 
            return response()->json(["success" => false, "error" =>$validator->errors()->first()],400);
        }   

        $mail = Email::where([ 'id' => $request->id])
                ->where(function($query) use ($request)
                {
                    $query->where('from' , $request->user->username)
                            ->orWhere(['to' => $request->user->username, 'is_draft' => false]);
                })
                ->first();
        
        return response()->json(['success' => true, 'message' => $mail]);
    }


    public function draft(Request $request) {
        $validator = Validator::make($request->all() + ['from' => $request->user->username],[
            'from' => 'required|exists:users,username',
            'subject' => 'required|min:1',
            'message' => 'required|min:1',
        ]);


        if ($validator->fails()) {
 
            return response()->json(["success" => false, "error" =>$validator->errors()->first()],400);
        }

        $mail = new Email();

        $mail->from = $request->user->username;

        if($request->to)
            $mail->to = $request->to;

        $mail->subject = $request->subject;
        $mail->content = $request->message;
        $mail->type = 1;
        $mail->is_draft = true;

        if($request->reply)
            $mail->reply = $request->reply;
        else
            $mail->reply = null;

        $mail->save();        

        return response()->json(['success' => true, 'message' => 'sent successfuly']);
    }



    public function draftUpdate(Request $request) {
        $validator = Validator::make($request->all() + ['from' => $request->user->username],[
            'from' => 'required|exists:users,username',
            'subject' => 'required|min:1',
            'message' => 'required|min:1',
            'id' => 'required'
        ]);


        if ($validator->fails()) {
 
            return response()->json(["success" => false, "error" =>$validator->errors()->first()],400);
        }

        $mail = Email::where(['id' => $request->id, 'is_draft' => true])->first();

        if(!($mail))
            return response()->json(["success" => false, "error" => "Doesn't Exists"],400);

        if($request->to)
            $mail->to = $request->to;

        $mail->subject = $request->subject;
        $mail->content = $request->message;
        
        if($request->type)
            $mail->type = 1;

        $mail->save();
        
        return response()->json(['success' => true, 'message' => 'drafted successfuly']);

    }

    public function changeType(Request $request) {
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'type' => 'required'
        ]);

        if ($validator->fails()) {
 
            return response()->json(["success" => false, "error" =>$validator->errors()->first()],400);
        }

        $mail = Email::where(['to' => $request->user->username])->first();
        $typeNew = Type::where(['slug' => $request->type])->first();

        if($mail && $typeNew) {
            $mail->type = $typeNew->id;
            $mail->save();
            return response()->json(['success' => true, 'message' => 'changed successfuly']);
        }
        else
            return response()->json(['success' => false, 'message' => 'bad request'],400);
    }


    public function getAllDraft(Request $request) {

        $request->type = 1;

        $mails = Email::where(['from' => $request->user->username, 'is_draft' => true])
                        ->where('type', $request->type)->get();

        
        return response()->json(['success' => true, 'message' => $mails]);

    }

}

/*

SQLSTATE[42S22]: Column not found: 1054 Unknown column 'draft' in 'field list' (SQL: update `emails` set `updated_at` = 2019-02-28 07:13:43, `draft` = 1 where `id` = 4)

SQLSTATE[42S22]: Column not found: 1054 Unknown column 'draft' in 'field list' (SQL: update `emails` set `updated_at` = 2019-02-28 07:14:49, `draft` = 1 where `id` = 4)


*/