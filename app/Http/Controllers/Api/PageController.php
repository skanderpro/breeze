<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::query()->paginate();

        return PageResource::collection($pages);
    }

    public function single(Page $page)
    {
        return new PageResource($page);
    }
}
