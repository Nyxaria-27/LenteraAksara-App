<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
 
    public function adminIndex()
    {
        $categories = Category::withCount('books')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Category::create($request->only('name'));
        return redirect()->back()->with('success', 'Kategori ditambahkan.');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(['name' => 'required']);

        $categories = Category::find($id);





        $categories->update($data);


        return redirect()->route('admin.categories.index')->with('success', 'Buku berhasil diupdate.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->books()->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh buku.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori dihapus.');
    }
}
