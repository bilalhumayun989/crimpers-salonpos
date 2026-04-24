<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TwoFactorController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Security: Non-admins don't do 2FA
        if ($user->role !== 'admin' && $user->email !== 'safullahzafar@gmail.com') {
            return redirect()->route('admin.index');
        }

        $google2fa = new Google2FA();

        // If user doesn't have a secret, create one
        if (!$user->google2fa_secret) {
            $user->google2fa_secret = $google2fa->generateSecretKey();
            $user->save();
        }

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );

        $renderer = new ImageRenderer(
            new RendererStyle(250),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeImage = $writer->writeString($qrCodeUrl);

        return view('auth.two-factor', [
            'qrCodeImage' => $qrCodeImage,
            'secret' => $user->google2fa_secret
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required',
        ]);

        $user = auth()->user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->one_time_password);

        if ($valid) {
            $request->session()->put('2fa_verified', true);
            return redirect()->route('admin.index');
        }

        return redirect()->back()->withErrors(['one_time_password' => 'The verification code is incorrect. Please try again.']);
    }

    public function resend()
    {
        // Not needed for TOTP, but keeping the route consistent
        return redirect()->back()->with('status', 'Please use your Google Authenticator app.');
    }
}
