@extends('layouts.app')

@section('content')
    <?php $title = 'Pages <span>List</span>'; ?>
    <div class="container-fluid user">
        <div class="row">
            <div class="col-md-12">

                @if (session('message'))
                    <div class="flash-message">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            {{ session('message') }}
                        </div>
                    </div>
                @endif


                @foreach($pages as $page)

                    <div class="row user_entry">
                        <div class="col-md-2 user_entry_email">
                            <label class="main">Title</label>
                            {{ $page->title }}
                        </div>
                        <div class="col-md-2 user_entry_email">
                            <label class="main">Slug</label>
                            {{ $page->slug }}
                        </div>
                        <div class="col-md-2 user_entry_email">
                            <label class="main">Created At</label>
                            {{ $page->created_at?->format('d.m.Y') }}
                        </div>
                        <div class="col-md-2 user_entry_email">


                            <a href="{{ route('edit-page', ['page' => $page])  }}">
                                <img src="{{ asset('/images/edit.svg') }}" alt="Edit Page">
                            </a>

                        </div>
                    </div>
                @endforeach

                {{ $pages->links() }}
            </div>
        </div>
    </div>
@endsection
