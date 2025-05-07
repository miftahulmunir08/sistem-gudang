<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
 

class AuthController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()) {
            return redirect()->route('dashboard');
        }

        return view('auth/login');
    }
    

    /**
     * @OA\Post(
     *   path="/api/login",
     *   tags={"Auth"},
     *   summary="User login",
     *   description="Authenticate user and generate token",
     *   @OA\RequestBody(
     *     required=true,
     *     description="User credentials",
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *         @OA\Property(property="email", type="string", format="email", example="admin@gmail.com"),
     *         @OA\Property(property="password", type="string", format="password", example="password")
     *       )
     *     )
     *   ),
     *   @OA\Response(response="200", description="A list with products"),
     *   @OA\Response(response="201", description="Successful operation"),
     *   @OA\Response(response="400", description="Bad Request"),
     *   @OA\Response(response="401", description="Unauthenticated"),
     *   @OA\Response(response="403", description="Forbidden"),
     * )
     */

    public function check_login_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:4'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            return response()->json([
                'status' => 'error',
                'message' => $errors
            ], 422);

            // return redirect()->back()->withErrors($errors);
        } else {
            if (Auth::attempt($request->only('email', 'password'))) {
                $user = User::where('email', $request->email)->firstOrFail();
                $token = $user->createToken('api-token')->plainTextToken;

                return response()->json([
                    'status' => 'success',
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'token' => $token,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials'
                ], 401);
            }
        }
    }

    public function check_login_web(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:5'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            dd($errors);
            return redirect()->back()->withErrors($errors);
        } else {

            if (Auth::attempt($request->only('email', 'password'))) {
                $user = User::where('email', $request->email)->firstOrFail();
                if ($user->is_active === '0') {
                    $errors = "Your account still inactive. Please wait until you received approval";
                    return redirect()->back()->withErrors($errors);
                }
                // Buat token API menggunakan Sanctum
                $token = $user->createToken('api-token')->plainTextToken;

                // Simpan token di session untuk digunakan dalam API request berikutnya
                $request->session()->put('api_token', $token);

                // Regenerasi session ID untuk keamanan
                $request->session()->regenerate();

                // Redirect ke halaman cashier atau sesuai kebutuhan
                return redirect()->route('dashboard');
            } else {

                $errors = "Kombinasi User dan Password tidak dapat ditemukan";
                return redirect()->back()->withErrors($errors);
            }
        }
    }

    public function getUser(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'user' => $request->user(), // otomatis diambil dari token
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function logout(Request $request)
    {

        if (!$request->user() || !$request->user()->currentAccessToken()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or missing token',
            ], 401);
        } else {

            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out'
            ]);
        }
    }


    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
