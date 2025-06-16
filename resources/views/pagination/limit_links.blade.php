<?php
// config
$link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
?>

@if ($paginator->lastPage() > 1)
    <div class="pagination" style="display:inline-block; margin-top: -14px">
        <div class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}" style="float: left; color: black; padding: 8px 16px;  text-decoration: none;">
            <a href="{{ $paginator->url(1) }}#rightContent">&laquo;</a>
         </div>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <?php
            $half_total_links = floor($link_limit / 2);
            $from = $paginator->currentPage() - $half_total_links;
            $to = $paginator->currentPage() + $half_total_links;
            if ($paginator->currentPage() < $half_total_links) {
               $to += $half_total_links - $paginator->currentPage();
            }
            if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
            }
            ?>
            @if ($from < $i && $i < $to)
                <div class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}" style="float: left; color: black; padding: 8px 16px;  text-decoration: none; {{ ($paginator->currentPage() == $i) ? 'background-color: #9873b1;' : ''}}">
                    <a href="{{ $paginator->url($i) }}#rightContent">{{ $i }}</a>
                </div>
            @endif
        @endfor
        <div class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}" style="float: left; color: black; padding: 8px 16px;  text-decoration: none;">
            <a href="{{ $paginator->url($paginator->lastPage()) }}#rightContent">&raquo;</a>
        </div>
    </div>
@endif
