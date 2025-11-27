<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function edit()
    {
        $about = About::first();
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        // Debug: Log incoming request
        \Log::info('About Update Request:', [
            'title' => $request->input('title'),
            'content_length' => strlen($request->input('content', '')),
            'has_image' => $request->hasFile('image'),
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $about = About::first();

        if (!$about) {
            $about = new About();
        }

        $about->title = $request->input('title');
        $about->content = $request->input('content');

        // jika admin mengupload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($about->image && Storage::disk('public')->exists($about->image)) {
                Storage::disk('public')->delete($about->image);
            }
            
            $path = $request->file('image')->store('about_images', 'public');
            $about->image = $path;
        }

        $about->save();

        \Log::info('About Updated Successfully', ['id' => $about->id]);

        return redirect()->route('admin.about.edit')->with('success', 'Tentang Kami berhasil diperbarui!');
    }

}
