<?php 
return [
    'number' => '<li class="page-item"><a class="page-link" href="{{url}}"><small>{{text}}</small></a></li>',
    'current' => '<li class="page-item active"><a class="page-link" href="{{url}}"><small>{{text}}</small></a></li>',
    'first' => '<li class="page-item first"><a class="page-link" href="{{url}}"><small>{{text}}</small></a></li>',
    'last' => '<li class="page-item last"><a class="page-link" href="{{url}}"><small>{{text}}</small></a></li>',
    'nextActive' => '<li class="page-item next"><a class="page-link" aria-label="Next" href="{{url}}"><small>{{text}}</small></a></li>',
    'nextDisabled' => '<li class="page-item next disabled"><a class="page-link" aria-label="Next"><span aria-hidden="true">»</span></a></li>',
    'prevActive' => '<li class="page-item prev"><a class="page-link" aria-label="Previous" href="{{url}}"><small>{{text}}</small></a></li>',
    'prevDisabled' => '<li class="page-item prev disabled"><a class="page-link" aria-label="Previous"><span aria-hidden="true">«</span></a></li>'
];
?>