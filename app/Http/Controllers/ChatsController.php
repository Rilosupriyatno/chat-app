<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ChatsController extends Controller
{
    //
    public function index()
    {
        return view('dashboard');
    }
    public function chat()
    {
        $users = User::all();
        $auth = User::where('id', '!=', Auth::user()->id)->get();


        return view('chats.chat', compact('auth'));
    }
    public function messages($id)
    {
        $senderId = auth()->user()->id;
        $recipient = User::findOrFail($id);
        $recipientId = $recipient->id;

        // Ambil pesan antara dua pengguna
        $chats = Chat::where(function ($query) use ($senderId, $recipientId) {
            $query->where('sender_id', $senderId)
                ->where('recipient_id', $recipientId);
        })->orWhere(function ($query) use ($senderId, $recipientId) {
            $query->where('sender_id', $recipientId)
                ->where('recipient_id', $senderId);
        })->orderBy('created_at', 'asc')->get();

        // Kembalikan view dengan data yang relevan
        return view('chats.messages', compact('recipient', 'chats'));
    }
    public function createChat(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
            'recipient_id' => 'required|integer|exists:users,id',
            'recipient_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $message = $request->input('message');
        $recipient_id = $request->input('recipient_id');
        $recipient_name = $request->input('recipient_name');

        $chat = new Chat([
            'sender_id' => auth()->user()->id,
            'sender_name' => auth()->user()->name,
            'recipient_id' => $recipient_id,
            'recipient_name' => $recipient_name,
            'message' => $message
        ]);

        // Kirim notifikasi ke penerima
        $sender_id = auth()->user()->id;
        $this->sendNotification($recipient_id, $sender_id, auth()->user()->name, $message);

        // Simpan pesan chat
        $chat->save();


        return redirect()->back()->with('success', 'Message sent successfully');
    }
    private function sendNotification($recipientId, $sender_id, $senderName, $message)
    {
        // Ambil FCM token penerima
        $recipient = User::findOrFail($recipientId);
        $recipientToken = $recipient->fcm_token;

        if ($recipientToken) {
            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60 * 20);

            $notificationBuilder = new PayloadNotificationBuilder('New message from: ' . $senderName);
            $notificationBuilder->setBody($message)
                ->setSound('default')
                ->setClickAction(url('/backNotif/' . $sender_id));

            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData([
                'sender_name' => $senderName,
                'message' => $message
            ]);

            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $data = $dataBuilder->build();

            $downstreamResponse = FCM::sendTo($recipientToken, $option, $notification, $data);

            return $downstreamResponse->numberSuccess();
        }
    }
    public function backNotif($sender_id)
    {
        session()->flash('message', 'Action was successful!');

        // Redirect ke rute messages dengan recipient_id
        return redirect()->route('messages', ['id' => $sender_id]);
    }
}
