<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function lire(string $id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return redirect()->route('amis.index');
    }

    public function toutLire()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('succes', 'Toutes les notifications ont été lues.');
    }
}
