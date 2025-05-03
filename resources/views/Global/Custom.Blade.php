<!DOCTYPE html>
<html>

<head>
    <title>Page Title</title>
</head>

<body>


</body>
<!-- resources/views/vendor/pagination/custom.blade.php -->

<div class="pagination">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <span class="disabled">&laquo;</span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
    @if (is_string($element))
    <span class="ellipsis">{{ $element }}</span>
    @elseif (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <span class="current">{{ $page }}</span>
    @else
    <a href="{{ $url }}">{{ $page }}</a>
    @endif
    @endforeach
    @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
    @else
    <span class="disabled">&raquo;</span>
    @endif
</div>


</html>
