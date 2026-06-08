<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ResetController extends Controller
{
    public function postRequest(Request $request)

    {

        $input = $request->all();



        $this->validate($request, [

            'username' => 'required',

        ]);

        $validator = User::where('username', $request->username)->count();

        if ($validator > 0) {
            User::where('username', $request->username)
                ->update([
                    'password' => Hash::make("123456"),
                ]);
            Alert::success('Success Title', 'Password Anda berubah menjadi 123456');
            return redirect('/')->with('alert', [
                'title' => 'Success!',
                'text' => 'Password Anda 123456',
                'icon' => 'success'
            ]);
        } else {
            Alert::error('Error Title', 'User Tidak Ditemukan');
            return redirect()->back()->with('alert', [
                'title' => 'Error!',
                'text' => 'User Tidak Ditemukan',
                'icon' => 'error'
            ]);
        }
    }

    public function viewChangPass()
    {
        return view('auth/changepass', [
            'data' => auth()->user()
        ]);
    }

    public function postChangPass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required', 'min:6', 'different:old_password'],
            'confirm_password' => ['required', 'same:new_password'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('view.change.pass')
                ->withErrors($validator)
                ->withInput();
        }

        $user = auth()->user();

        // Verifikasi password lama
        if (!Hash::check($request->old_password, $user->password)) {
            Alert::error('Error', 'Password lama tidak sesuai');
            return redirect()->back()->with('alert', [
                'title' => 'Gagal!',
                'text' => 'Password lama tidak sesuai',
                'icon' => 'error'
            ]);
        }

        // Update password baru
        $user->password = Hash::make($request->new_password);
        $user->save();

        Alert::success('Sukses', 'Password berhasil diperbarui');
        return redirect()->route('user.home')->with('alert', [
            'title' => 'Berhasil!',
            'text' => 'Password berhasil diperbarui',
            'icon' => 'success'
        ]);
    }
}
