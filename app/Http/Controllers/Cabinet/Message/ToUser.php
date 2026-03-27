<?php

namespace App\Http\Controllers\Cabinet\Message;

use App\Http\Controllers\Controller;
use Domain\User\ViewModels\UserViewModel;
use Illuminate\Http\Request;

class ToUser extends Controller
{
    public function toUser(Request $request)
    {
        $action = $request->action;

        if ($action === 'published') {
            UserViewModel::make()->userSetPublished($request->user_id);
            flash()->info(config('message_flash.info.user_published'));
        } elseif ($action === 'blocked') {
            UserViewModel::make()->userSetBlocked($request->user_id);
            flash()->alert(config('message_flash.alert.user_blocked'));
        }

        return redirect()->back();
    }

}
