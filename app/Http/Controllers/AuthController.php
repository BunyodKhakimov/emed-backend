<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use App\VerificationCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'verify']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['phone_number', 'password']);

        if (! $token = auth()->guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        } elseif (! auth()->user()->isVerified) {
            return response()->json(['error' => 'Unverified'], 403);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|numeric',
            'phone_number' => 'required|numeric',
        ]);

        if (!VerificationCode::where('verifiable_by', $request->phone_number)
            ->where('code', $request->verification_code)
            ->where('expires_at', '<=', Carbon::now())
            ->get())
        {
            return response()->json([
                'message' => 'Verification failed',
            ]);
        }

        User::where('phone_number', $request->phone_number)->update(['isVerified' => true]);

        return response()->json([
            'message' => 'Verified successfully',
        ]);
    }

    public function register(UserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        User::firstOrCreate(
            ['phone_number' => $data['phone_number']],
            $data
        );

        return $this->sendMessageResponse($data['phone_number']);

    }

    private function sendMessageResponse($phone_number)
    {
        // generate code
        $code = rand(1000, 9999);

        // create VerificationCode entity
        $verificationCode = new VerificationCode();
        $verificationCode->code = $code;
        $verificationCode->verifiable_by = $phone_number;
        $verificationCode->expires_at = Carbon::now()->addMinutes(2);

        // send message to mobile phone
        $basic  = new Basic("e2628475", "BoC73YOQUoMjjjp4");
        $client = new Client($basic);

        $response = $client->sms()->send(
            new SMS($phone_number, 'E-Med', "Your verification code is $code.\n")
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            $verificationCode->save();
            return response()->json(['message' => 'The message was sent successfully']);
        } else {
            return response()->json(['message' => 'The message failed']);
        }
    }
}
