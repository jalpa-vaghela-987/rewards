
  <div style="height: 100%" class="area">

    @php 

    $box_count = 100;

    @endphp

    <div class="area" >
            <ul class="circles">
              @for($i=1;$i<$box_count;$i++)
              <li></li>
              @endFor
            </ul>
    </div >
  </div>
<style type="text/css">

#background_div{
  background: white !important;
}


.area{
    background: white;  
    background: -webkit-linear-gradient(to left, #8f94fb, #4e54c8);  
    width: 100%;
    height:100%
}

.circles{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.circles li{
    position: absolute;
    display: block;
    list-style: none;
    width: 20px;
    height: 20px;
    background: rgba(37, 99, 235, .25);
    animation: animate 25s linear infinite;
    bottom: 0px;
    z-index: 1;
    border-radius: 100%
}

@for($i=1;$i<$box_count;$i++)

.circles li:nth-child(@php echo $i @endphp){
    @php 
    $h = rand(50,100); 
    $w = rand(50,100);
    @endphp

    left: calc(@php echo rand(0,100) @endphp% - @php echo round($w/2) @endphppx);
    top: calc(@php echo rand(0,100) @endphp% + @php echo round($h/2) @endphppx);
    width: @php echo $w @endphppx;
    height: @php echo $h @endphppx;
    animation-delay: @php echo rand(0,60) @endphps;
    animation-duration: @php echo rand(45,60) @endphps;s;
    opacity: 0.1;
}
  
@endFor



@keyframes animate {

    /*0%{
        transform: translateY(0) rotate(0deg);
        opacity: .1;
    }

    100%{
        transform: translateY(-1000px) rotate(720deg);
        opacity: 0;
    }*/

}




</style>
    
