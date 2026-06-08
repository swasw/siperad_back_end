<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $data = Feedback::all();
        $title = 'Delete Feedback!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('admin/feedback/index', [
            'title' => 'Data Feedback',
            'data' => $data
        ]);
    }

    public function viewFeedback()
    {
        // $data = Feedback::all();
        return view('user/form/feedback', [
            // 'data' => $data
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'tgl_feedback' => 'required|date',
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string',
            'saran' => 'required|string',
        ]);

        Feedback::create($request->all());

        Alert::success('Berhasil', 'Feedback Anda telah dikirim.');

        return redirect()->route('user.home')
                ->with('success', 'Feedback Anda telah dikirim.');

        // return redirect()->back()->with('alert', [
        //     'title' => 'Berhasil',
        //     'text' => 'Feedback Anda telah dikirim.',
        //     'icon' => 'success'
        // ]);
    }

    public function destroy($id)
    {
        $data = Feedback::find($id);
        $data->delete();

        Alert::success('Berhasil', 'Feedback Berhasil Dihapus');

        return redirect()->route('feedback.index')
            ->with('success', 'Feedback berhasil dihapus!');
    }
}
