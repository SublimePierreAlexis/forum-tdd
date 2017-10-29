<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Reply;
use App\Thread;
use Illuminate\Http\Response;

class RepliesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => 'index',
        ]);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }

    /**
     * @param integer           $channelId
     * @param Thread            $thread
     * @param CreatePostRequest $form
     *
     * @return Thread|\Illuminate\Database\Eloquent\Model
     */
    public function store($channelId, Thread $thread, CreatePostRequest $form)
    {
        return $thread->addReply([
            'body'    => request('body'),
            'user_id' => auth()->id(),
        ])->load('owner');
    }

    /**
     * @param Reply $reply
     *
     * @return null|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            $this->validate(request(), ['body' => 'required|spamfree']);
            $reply->update(request(['body']));
        } catch (\Exception $e) {
            return response('Sorry, you reply could not be save at this time.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @param Reply $reply
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted.']);
        }

        return back();
    }
}
