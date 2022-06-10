@extends('layouts.app')

@section('content')
    <div class="box">
        <h1 class="title">Resource Managements</h1>
        <b-tabs>
            <b-tab-item label="Files" icon="file-pdf-box">
                <pdf-list />
            </b-tab-item>
            <b-tab-item label="HTML Snippet" icon="code-tags">
                <snippet-list />
            </b-tab-item>
            <b-tab-item label="Links" icon="link">
                <link-list />
            </b-tab-item>
        </b-tabs>
        
    </div>
@endsection