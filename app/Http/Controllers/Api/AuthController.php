<?php
namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Models\FcmToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\Shared\Trend\Trend;

class AuthController extends Controller
{
    /**
     * login auth
     *
     * @param  Request $request
     */
    public function login(Request $request)
    {
        $request->validate([
            'credential' => 'required',
            'password'   => 'required|string',
            'fcm_token'  => 'nullable',
        ]);

        $customer = Customer::where('email', $request->credential)
            ->orWhere('phone', $request->credential)
            ->first();

        if ($customer) {
            if (Hash::check($request->password, $customer->password)) {
                $token = $customer->createToken('CustomerToken')->plainTextToken;
                if (isset ($request->fcm_token)) {
                    $this->insertToken($request->fcm_token, $customer->id);
                }

                return response()->json([
                    'success' => true,
                    'token'   => $token,
                    'data'    => $customer->refresh(),
                ])->header('Authorization', $token);
            }
            else {
                return response()->json([
                    'success' => false,
                    'code'    => 500,
                    'message' => 'Wrong password',
                ]);
            }
        }
        else {
            return response()->json([
                'success' => false,
                'code'    => 500,
                'message' => 'No user found with this credential',
            ]);
        }
    }

    /**
     * register auth
     *
     * @param  Request $request
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string',
            'email'     => 'required|email|unique:customers,email',
            'phone'     => 'required|numeric|unique:customers,phone',
            'password'  => 'required|string|min:4|confirmed',
            'fcm_token' => 'nullable',
        ]);

        $customer = Customer::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'original_email' => $request->email,
            'phone'          => $request->phone,
            'original_phone' => $request->phone,
            'password'       => Hash::make($request->password),
            'type'           => 'retail',
        ]);

        $token = $customer->createToken('CustomerToken')->plainTextToken;

        if (isset ($request->fcm_token)) {
            $this->insertToken($request->fcm_token, $customer->id);
        }

        return response()->json([
            'success' => true,
            'token'   => $token,
            'user'    => $customer->refresh(),
        ])
            ->header('Authorization', $token);
    }

    /**
     * auth User
     */
    public function authUser()
    {
        return response()->json([
            'success' => true,
            'user'    => Auth::user(),
        ]);
    }

    /**
     * Auth Logout
     *
     */
    public function logout()
    {
        request()->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out Successfully.',
        ]);
    }

    /**
     * insert token
     *
     * @param [type] $token
     * @param [type] $customer_id
     */
    public function insertToken($token, $customer_id)
    {
        //insert token
        $raw = FcmToken::where('customer_id', $customer_id);

        if ($raw->count() >= 5) {
            $oldToken = $raw->latest()->first();
            $oldToken->delete();
        }

        $newToken              = new FcmToken();
        $newToken->customer_id = $customer_id;
        $newToken->token       = $token;
        $newToken->save();

        return true;
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password'     => 'required|string|min:8',
        ]);

        $id = Auth::user()->id;
        if (Hash::check($request->old_password, Auth::user()->password)) {
            $auth           = Customer::find($id);
            $auth->password = Hash::make($request->password);
            $auth->update();

            return response()->json([
                'success' => true,
                'message' => 'Password changes successful',
            ]);
        }
        else {
            throw ValidationException::withMessages(['old_password' => "Old password is not invalid"]);
        }
    }

    public function edit(Request $request)
    {
        $id = $request->user()->id;
        $request->validate([
            'name'  => 'required|string',
            'email' => 'required|email|unique:customers,email,' . $id,
            'phone' => 'required|numeric|unique:customers,phone,' . $id,
        ]);

        $customer        = Customer::find($id);
        $customer->name  = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->update();

        return response()->json([
            'success' => true,
            'message' => 'Profile edit successful',
        ]);

    }
}
