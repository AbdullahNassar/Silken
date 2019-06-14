

<div class="row">
    <div class="col-md-4 col-md-push-8">
        <div class="rate-progress">
            <div class="rate-progress-head">
                <ul class="rate-list">
                    @php
                    $total = $product->master->total_reviews();
                    @endphp
                    @for($i=1 ; $i<=5 ;$i++)
                    @if($i <= $total)
                    <li> <i class="fa fa-star"></i> </li>
                    @else
                    <li> <i class="fa fa-star-o"></i> </li>
                    @endif
                    @endfor

                </ul><span>@if($total){{$total}}@endif</span>
                <span>{{$product->master->total_reviews_numbers()}} اصوات</span>
            </div><!-- End Rate-Progress-Head -->
            <div class="rate-progress-content">
                <div class="progress-item">
                    <span>5 نجوم</span>
                    <div class="progress">
                        <div style="
                             @if($product->master->total_reviews_numbers())
                             width: {{($product->master->total_reviews_numbers(5)/$product->master->total_reviews_numbers())*100}}%
                             @endif
                             " class="progress-bar prog-processing not-loaded" data-width="75"></div>
                    </div>
                    <span>{{$product->master->total_reviews_numbers(5)}}</span>
                </div><!-- End Progress-Item -->
                <div class="progress-item">
                    <span>4 نجوم</span>
                    <div class="progress">
                        <div style="
                             @if($product->master->total_reviews_numbers())
                             width: {{($product->master->total_reviews_numbers(4)/$product->master->total_reviews_numbers())*100}}%
                             @endif" class="progress-bar prog-processing not-loaded" data-width="75"></div>
                    </div>
                    <span>{{$product->master->total_reviews_numbers(4)}}</span>
                </div><!-- End Progress-Item -->
                <div class="progress-item">
                    <span>3 نجوم</span>
                    <div class="progress">
                        <div style="
                             @if($product->master->total_reviews_numbers())
                             width: {{($product->master->total_reviews_numbers(3)/$product->master->total_reviews_numbers())*100}}%
                             @endif
                             " class="progress-bar prog-processing not-loaded" data-width="75"></div>
                    </div>
                    <span>{{$product->master->total_reviews_numbers(3)}}</span>
                </div><!-- End Progress-Item -->
                <div class="progress-item">
                    <span>2 نجوم</span>
                    <div class="progress">
                        <div style="
                             @if($product->master->total_reviews_numbers())
                             width: {{($product->master->total_reviews_numbers(2)/$product->master->total_reviews_numbers())*100}}%
                             @endif
                             " class="progress-bar prog-processing not-loaded" data-width="75"></div>
                    </div>
                    <span>{{$product->master->total_reviews_numbers(2)}}</span>
                </div><!-- End Progress-Item -->
                <div class="progress-item">
                    <span>1 نجوم</span>
                    <div class="progress">
                        <div style="
                             @if($product->master->total_reviews_numbers())
                             width: {{($product->master->total_reviews_numbers(1)/$product->master->total_reviews_numbers())*100}}%
                             @endif
                             " class="progress-bar prog-processing not-loaded" data-width="75"></div>
                    </div>
                    <span>{{$product->master->total_reviews_numbers(1)}}</span>
                </div><!-- End Progress-Item -->
            </div><!-- End Rate-Progress-Content -->
        </div><!-- End Rate-Progress -->
    </div><!-- end col -->
    <div class="col-md-8 col-md-pull-4">
        <div class="comments">

            @foreach($product->master->reviews()->get() as $r)

            <div class="comment-item">

                <ul class="rate-list">
                    @if($r->rate != null)
                    @for($i=1 ; $i<=5 ;$i++)
                    @if($i <= $r->rate)
                    <li>
                        <i class="fa fa-star"></i>
                    </li>
                    @else
                    <li>
                        <i class="fa fa-star-o"></i>
                    </li>
                    @endif
                    @endfor
                    @endif

                </ul><!-- End Rate-List -->

                <h3 class="title">{{$r->member->name}}</h3>
                <span>{{$r->created_at->format('Y/m/d')}}</span>
                <p>
                    {{$r->review}}
                </p>        
            </div><!-- End C    omment-Item -->
            @endforeach


        </div><!-- End Comments -->


    </div><!-- end col -->
</div><!-- End row -->
