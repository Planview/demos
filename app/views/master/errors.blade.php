@extends("master.layout")

@section("title")
    The Page You Requested Cannot Be Found
@stop

@section("content")
    <header class="page-header">
        <h1>The Page You Requested Cannot Be Found</h1>
    </header>
    <article>
    	<?php
		if (Auth::check()) {
			echo '<p>We&rsquo;re sorry. You have come across a page which does not exist or has been moved.</p>';
		} else {
			echo '<p>We&rsquo;re sorry. You have come across a page which does not exist or has been moved, or you may need to <a href="/" title="Login">login</a> to view the page.</p>';
		}
		?>
    </article>
@stop
