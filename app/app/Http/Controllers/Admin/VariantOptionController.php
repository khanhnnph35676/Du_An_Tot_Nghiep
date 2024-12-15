<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VariantOption;
use App\Models\MessOrder;

use Illuminate\Http\Request;

class VariantOptionController extends Controller
{
    public function index()
    {
        $messages = MessOrder::with('user', 'order')->get();
        $variantOptions = VariantOption::with('productVariants')->get();
        return view('admin.variant_options.index', compact('variantOptions', 'messages'));
    }

    public function create()
    {
        return view('admin.variant_options.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'option_name' => 'required|string|max:255',
            'option_value' => 'required|string|max:255',
            'image_variant' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image_variant')) {
            $validated['image_variant'] = $request->file('image_variant')->store('variant_images', 'public');
        }

        VariantOption::create($validated);

        return redirect()->route('admin.variant-options.index')->with('success', 'Variant option created successfully.');
    }

    public function edit($id)
    {
        $variantOption = VariantOption::findOrFail($id);
        $messages = MessOrder::with('user', 'order')->get();
        return view('admin.variant_options.edit', compact('variantOption', 'messages'));
    }

    public function update(Request $request, $id)
    {
        $variantOption = VariantOption::findOrFail($id);

        $validated = $request->validate([
            'option_name' => 'required|string|max:255',
            'option_value' => 'required|string|max:255',
            'image_variant' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image_variant')) {
            $validated['image_variant'] = $request->file('image_variant')->store('variant_images', 'public');
        }

        $variantOption->update($validated);

        return redirect()->route('admin.variant-options.index')->with('success', 'Thêm thành công.');
    }


    public function destroy(VariantOption $variantOption)
    {
        $variantOption->delete();
        return redirect()->route('admin.variant-options.index')->with('success', 'Xoá thành công.');
    }
}
