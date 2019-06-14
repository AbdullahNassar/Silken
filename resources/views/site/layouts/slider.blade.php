<div id="rev-slider">
    <ul class="rev_slider">
        @foreach($sliders as $slider)
        <li data-transition="random" data-slotamount="7" data-masterspeed="500" data-thumb="{{asset('storage/uploads/sliders/'.$slider->image)}}" data-saveperformance="off" data-title="من نحن">
            <img src="{{asset('storage/uploads/sliders/'.$slider->image)}}" alt="slider" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
            <!-- LAYER NR. 1 -->
            <div class="tp-caption sft excerpt-small-size" data-x="200" data-y="130" data-speed="800" data-start="2000" data-easing="Power3.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="500" style="z-index: 5;">
                {{$slider->translated()->title1}}
            </div>
            <!-- LAYER NR. 2 -->
            <div class="tp-caption sft excerpt-big" data-x="130" data-y="200" data-speed="1000" data-start="2500" data-easing="Power3.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 6;">
                {{$slider->translated()->title2}}
            </div>
            <!-- LAYER NR. 3 -->
            <div class="tp-caption sfb excerpt-small-size" data-x="350" data-y="320" data-speed="800" data-start="3800" data-easing="Power3.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="500" style="z-index: 7;">
                {{$slider->translated()->title3}}
            </div>
        </li>
        @endforeach

    </ul>
    <div class="tp-bannertimer"></div>
</div>
</div>