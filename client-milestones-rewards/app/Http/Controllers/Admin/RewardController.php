<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Reward;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::orderByDesc('id')->get();
        return view('admin.pages.rewards', compact('rewards'));
    }

    public function create()
    {
        return view('admin.pages.rewards-create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'instructions' => ['required', 'string'],
            'one_time' => ['nullable'],
        ]);

        Reward::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'instructions' => $data['instructions'],
            'one_time' => $request->boolean('one_time'),
        ]);

        return redirect('/admin/rewards')->with('success', 'Reward created.');
    }

    public function edit($id)
    {
        $reward = Reward::findOrFail($id);
        return view('admin.pages.rewards-edit', compact('reward'));
    }

    public function update(Request $request, $id)
    {
        $reward = Reward::findOrFail($id);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'instructions' => ['required', 'string'],
            'one_time' => ['nullable'],
        ]);

        $reward->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'instructions' => $data['instructions'],
            'one_time' => $request->boolean('one_time'),
        ]);

        return redirect('/admin/rewards')->with('success', 'Reward updated.');
    }

    public function destroy($id)
    {
        $reward = Reward::findOrFail($id);
        $reward->delete();

        return redirect('/admin/rewards')->with('success', 'Reward deleted.');
    }
}
