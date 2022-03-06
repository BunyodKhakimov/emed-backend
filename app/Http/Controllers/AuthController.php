<?php

namespace App\Http\Controllers;

use App\User;
use App\VerificationCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;

class AuthController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'string'],
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

        $user = User::create(array(
            'phone_number' => $request->phone_number,
            'isVerified' => true,
        ));

        // generate token
        // assign token to user
        // send token as response

        return response()->json([
            'message' => 'Verified successfully',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|regex:/^998[39][012345789][0-9]{7}$/',
        ]);

        // generate code
        $code = rand (1000, 9999);

        // create VerificationCode entity
        $verificationCode = new VerificationCode();
        $verificationCode->code = $code;
        $verificationCode->verifiable_by = $request->phone_number;
        $verificationCode->expires_at = Carbon::now()->addMinutes(2);

        // send message to mobile phone
        $basic  = new Basic("e2628475", "BoC73YOQUoMjjjp4");
        $client = new Client($basic);

        $response = $client->sms()->send(
            new SMS($request->phone_number, 'E-Med', "Your verification code is $code.\n")
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            $verificationCode->save();
            return response()->json([
                'message' => 'The message was sent successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'The message failed with status: ' . $message->getStatus(),
            ]);
        }

    }
}
