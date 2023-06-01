<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Category::create($request->all());

        return redirect('admin/settings')->with('success', 'Category created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->input('name');
        $category->save();

        return redirect('admin/settings')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Request $request)
    {
        $categoryIds = $request->input('categories');

        if (empty($categoryIds)) {
            return redirect('admin/settings')->with('error', 'Tidak ada kategori yang dipilih');
        }

        Category::whereIn('id', $categoryIds)->delete();

        return redirect('admin/settings')->with('success', 'Kategori berhasil dihapus');
    }
}
