<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;


class PageController extends Controller
{

    public function create()
    {
        return view('create-page');
    }

    public function edit(Page $page)
    {
        return view('create-page', [
            'page' => $page,
        ]);
    }

    public function store(Request $request)
    {

        $payload = $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
        ]);
        $payload['slug'] = Str::slug($payload['title']);

        Page::create($payload);

        return to_route('pages')->with('message', 'Page successfully added');

    }

    public function index()
    {
        $pages = Page::query()->paginate(25);

        return view('pages-list', [
            'pages' => $pages,
        ]);
    }


    public function update(Page $page, Request $request)
    {

        $payload = $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
        ]);
        $payload['slug'] = Str::slug($payload['title']);

        $page->fill($payload)->save();

        return to_route('pages')->with('message', 'Page updated added');

    }
}
