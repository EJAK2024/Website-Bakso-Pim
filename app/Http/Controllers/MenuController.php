<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menu.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:makanan,minuman',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_available' => 'boolean',
        ]);

        $validated['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('menu', 'public');
        } else {
            unset($validated['image']);
        }

        Menu::create($validated);

        return redirect('/admin/menu')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        return view('admin.menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:makanan,minuman',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_available' => 'boolean',
        ]);

        $validated['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            if ($menu->image && \Storage::disk('public')->exists($menu->image)) {
                \Storage::disk('public')->delete($menu->image);
            }
            $validated['image'] = $request->file('image')->store('menu', 'public');
        } else {
            unset($validated['image']);
        }

        $menu->update($validated);

        return redirect('/admin/menu')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->image && \Storage::disk('public')->exists($menu->image)) {
            \Storage::disk('public')->delete($menu->image);
        }
        $menu->delete();
        return redirect('/admin/menu')->with('success', 'Menu berhasil dihapus.');
    }
}
