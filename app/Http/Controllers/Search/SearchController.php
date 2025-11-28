<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Domain\Search\ViewModel\SearchViewModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{

    public function search(Request $request):View
    {

        if($request->all()) {
        // dump($request->all());

                $search =($request->search)?trim($request->search):'';
                if($search) {
                $items = SearchViewModel::make()->search($search);

                }


        }
        return view('search.search', [
            'search' => (isset($search)) ? $search : '',
            'items' => (isset($items)) ? $items : []
        ]);

    }

}
