<div class="card-element bg-white m-2 rounded-xl shadow self-start">
    @if($ce->media_path)
        <div class="card-element-content rounded-t-xl" wire:ignore
             x-init="loadVimeoVideo()"
             x-data="{
                videoId: '',
                loadVimeoVideo() {
                    videoId = '{{$ce->media_path}}';
                    console.log('this is calling', videoId)
                    if (videoId && !isNaN(videoId)) {
                        let options = {
                            id: videoId,
                            responsive: true,
                            title: false
                            //loop: true
                        };

                        let player = new Vimeo.Player('vimeo-video-player', options);
                    }
                },
             }"
        >
            @if($ce->media_type === 'video')
                @if(is_numeric($ce->media_path))
{{--                    <div x-show="mediaProcessed">--}}
                        <div id="vimeo-video-player"></div>
{{--                    </div>--}}
                @else
                    <video
                        ref="video-card"
                        id="my-video"
                        class="video-js vjs-big-play-centered vjs-fluid rounded-t"
                        style="height: unset"
                        controls
                        preload="auto"
                        width="640"
                        height="264"
                        poster="/other/art.jpg"
                        data-setup="{}"
                    >
                        <source src="{{ $ce->media_path }}" type="video/mp4"/>

                        <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a
                            web browser that
                            <a href="https://videojs.com/html5-video-support/" target="_blank">
                                supports HTML5 video
                            </a>
                        </p>
                    </video>
                @endif
            @else
                <image src="{{$ce->media_path ?? ''}}" class="w-full card-element-media rounded-t-xl" />
            @endif
        </div>
    @endif

    <div class="card-element-text p-2 font-handwriting tracking-wide text-lg">
        {!! html_entity_decode(htmlspecialchars_decode($ce->text)) !!}
    </div>

    <div class="card-element-signature py-2 px-4 w-full text-right text-gray-600 italic text-lg">
        From {{$ce->user->name}}
    </div>
</div>
