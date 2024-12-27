<?php

namespace Acelle\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Acelle\Model\Keyword;

class KeywordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure user is authenticated
    }

    /**
     * Keywords list.
     */
    public function keywordsListing(Request $request)
    {
        $user = $request->user();

        // Check if the user is authenticated
        if (!$user) {
            return redirect()->route('login'); // Redirect to login page
        }

        // Check if the user is authorized to view keywords
        if (!Gate::allows('viewKeywords', $user->customer)) {
            return abort(403, trans('messages.not_authorized')); // Forbidden
        }

        // Fetch the keywords for the logged-in user based on uid
        $keywords = $user->keywords() // Use the relationship defined in the User model
                          ->orderBy('created_at', 'desc')
                          ->paginate(25);

        return view('account.keywords_listing', [
            'keywords' => $keywords, // Pass the keywords to the view
            'user' => $user,
        ]);
    }

    public function index(Request $request)
    {
        $user = $request->user();

        // Check if the user is authenticated
        if (!$user) {
            return redirect()->route('login'); // Redirect to login page
        }

        // Fetch keywords with filtering and sorting
        $keywords = Keyword::where('uid', $user->id)
            ->when($request->keyword, function ($query, $keyword) {
                return $query->where('keyword', 'like', '%' . $keyword . '%');
            })
            ->when($request->sort_order, function ($query, $sortOrder) use ($request) {
                return $query->orderBy($sortOrder, $request->sort_direction ?? 'asc');
            }, function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->paginate(25);

        return view('account.index', [
            'keywords' => $keywords,
        ]);
    }

    /**
     * Keyword Histories list.
     */
    public function keywordHistoryListing(Request $request)
    {
        $user = $request->user();  // Get the authenticated user

        // Check if the user is authorized to view keyword histories
        if (!Gate::allows('viewKeywords', $user->customer)) {
            return abort(403, trans('messages.not_authorized'));  // Forbidden
        }

        $keyword_histories = \Acelle\Model\KeywordHistory::search($request)->paginate($request->per_page);

        return view('account.keywordhistory_listing', [
            'keyword_histories' => $keyword_histories,
        ]);
    }
}
