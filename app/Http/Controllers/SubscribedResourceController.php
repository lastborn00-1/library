<?php

namespace App\Http\Controllers;

use App\Models\SubscribedResource;
use Illuminate\Http\Request;

class SubscribedResourceController extends Controller
{
    public function index()
    {
        $subscriptions = SubscribedResource::orderBy('order')->latest()->get();
        return view('settings.subscriptions.index', compact('subscriptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'url'         => 'required|url|max:2048',
            'description' => 'nullable|string|max:1000',
            'order'       => 'nullable|integer',
        ]);

        SubscribedResource::create([
            'title'       => $request->title,
            'url'         => $request->url,
            'description' => $request->description,
            'order'       => $request->order ?? 0,
        ]);

        return redirect()->route('settings.subscriptions.index')->with('success', 'Subscribed resource added successfully.');
    }

    public function destroy(SubscribedResource $subscription)
    {
        $subscription->delete();
        return redirect()->route('settings.subscriptions.index')->with('success', 'Subscribed resource removed.');
    }
}
