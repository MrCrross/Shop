<?php

namespace App\Http\Controllers\API\v1;

use App\Logger\Converter;
use Illuminate\Http\Request;
use App\Services\SecurityService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;

class SecurityController extends Controller
{
    /**
     * @var SecurityService
     */
    private $securityService;

    public function __construct()
    {
        $this->securityService = new SecurityService();
    }

    /**
     * @param ChangeEmailRequest $request
     */
    public function changeEmail(ChangeEmailRequest $request)
    {
        $changed = $this->securityService->changeEmail(
            $request->input('email'),
            $request->input('token')
        );

        Log::info('Try to change email', [
            'user'      => auth()->id(),
            'new_email' => $request->input('email'),
            'changed'   => $changed
        ]);

        return response()->json([
            'changed' => $changed
        ]);
    }

    /**
     * @param ChangePasswordRequest $request
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $changed = $this->securityService->changePassword(
            $request->input('new_password'),
            $request->input('token')
        );

        Log::info('Try to change password', [
            'user'      => auth()->id(),
            'changed'   => $changed
        ]);

        return response()->json([
            'changed' => $changed
        ]);
    }
}
