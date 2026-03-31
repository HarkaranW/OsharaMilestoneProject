<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Milestone;
use App\Models\Reward;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    public function index()
    {
        $milestones = Milestone::query()
            ->with('reward')
            ->orderBy('name')
            ->get();

        return view('admin.pages.milestones', compact('milestones'));
    }

    public function create()
    {
        $rewards = Reward::query()->orderBy('title')->get();
        return view('admin.pages.milestones-create', compact('rewards'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:time,performance'],
            'trigger_condition' => ['required', 'string', 'max:255'],
            'reward_id' => ['nullable', 'integer', 'exists:rewards,id'],
        ]);

        Milestone::create($data);

        return redirect('/admin/milestones')->with('success', 'Milestone created.');
    }

    public function edit(Milestone $milestone)
    {
        $rewards = Reward::query()->orderBy('title')->get();
        return view('admin.pages.milestones-edit', compact('milestone', 'rewards'));
    }

    public function update(Request $request, Milestone $milestone)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:time,performance'],
            'trigger_condition' => ['required', 'string', 'max:255'],
            'reward_id' => ['nullable', 'integer', 'exists:rewards,id'],
        ]);

        $milestone->update($data);

        return redirect('/admin/milestones')->with('success', 'Milestone updated.');
    }

    public function destroy(Milestone $milestone)
    {
        $milestone->delete();

        return redirect('/admin/milestones')->with('success', 'Milestone deleted.');
    }
}