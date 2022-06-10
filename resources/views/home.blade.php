@extends('layouts.app')

@section('content')
    
<div class="box">
    <h4 class="title">Files</h4>
    <home-files />
</div>
<div class="box">
    <h4 class="title">Snippets</h4>
    <home-snippets />
</div>
<div class="box">
    <h4 class="title">Links</h4>
    <home-links />
</div>
@endsection