<script src="/quill/quill-emoji.js" async></script>

<script type="text/javascript">
    function setMediaProperties(mediaType, mediaPreview) {
    @this.set('media_preview', mediaPreview);
    @this.set('mediaType', mediaType);
    @this.set('hide_media', false);
    }

    function getMediaProcessingStatus() {
        return @this.isMediaProcessed();
    }
</script>

<div class="card-element bg-white m-2 rounded-xl shadow self-start">
    <div class="card-element-editor-content rounded-xl">
        <!-- <image src="/card_themes/gift3.png" class="w-full card-element-media rounded-xl">
            <a href="#" class="m-auto flex justify-center align-middle flex-col text-center sm:w-1/3 p-1 text-blue-600 "> Add Media </a>  -->
        <form class="m-0">
            <div
                x-init="checkMediaProcessing()"
                @video-uploaded-{{$cardElement->id}}.window="checkMediaProcessing(true)"
                @load-vimeo-video-{{$cardElement->id}}.window="loadVimeoVideo(true)"
                class="w-full card-element-media rounded-t-xl"
                x-data="{
                    fileSize: null,
                    fileType: '',
                    mediaName: null,
                    mediaPreview: null,
                    videoPreview: '',
                    upload: null,
                    mediaProcessed: true,
                    startOrResumeUpload(upload) {
                        upload.findPreviousUploads().then(function (previousUploads) {
                            if (previousUploads.length) {
                                upload.resumeFromPreviousUpload(previousUploads[0])
                            }

                            upload.start()
                        })
                    },
                    loadVimeoVideo(processingCompleted = false) {
                        videoId = @this.get('video_id');

                        if(processingCompleted) {
                            mediaProcessed = true;
                        }

                        if (videoId !== null && videoId && !isNaN(videoId) && mediaProcessed) {
                            let options = {
                                id: videoId,
                                responsive: true,
                                title: false
                                //loop: true
                            };

                            let player = new Vimeo.Player('vimeo-video-player', options);
                        }
                    },
                    checkMediaProcessi ng(recentlyUploaded = false) {
                        mediaProcessed = recentlyUploaded ? false : @this.get('media_processed');

                        if (! mediaProcessed) {
                            document.getElementById('loader-wrapper').classList.remove('hidden');

                            let interval = setInterval(function() {
                                getMediaProcessingStatus().then(response => {
                                    document.getElementById('loader-wrapper').classList.remove('hidden');

                                    if (response) {
                                        clearInterval(interval);

                                        document.getElementById('loader-wrapper').classList.add('hidden');
                                    }
                                });
                            }, 2000);
                        } else {
                            this.loadVimeoVideo();
                        }
                    }
                }"
            >
                <input type="file"
                       class="hidden"
                       accept="image/*, video/*"
                       x-ref="media"
                       x-on:change="
                            if($event.target.files && $event.target.files.length) {
                                document.getElementById('loader-wrapper').classList.remove('hidden');

                                let file = $event.target.files[0];
                                mediaName = file.name;
                                fileType = file.type;
                                fileSize = file.size; //bytes

                                @this.set('mediaType', (fileType.includes('video')) ? 'video' : 'image');

                                if(! fileType.includes('video')) {
                                    @this.set('media_preview', URL.createObjectURL(file));
                                    @this.set('hide_media', false);

                                    $wire.upload(
                                        'media',
                                        file,
                                        finishCallback = (uploadedFilename) => {
                                            $wire.uploadCardMedia();
                                        },
                                        errorCallback = () => {},
                                        progressCallback = (event) => {}
                                    )
                                } else {
                                    let uploadUrl = await @this.createVideoFile(fileSize);
                                    let videoId = await @this.get('video_id');
                                    document.getElementById('video-percentage').innerText = 'uploading 0%';

                                    // Create a new tus upload
                                    upload = new tus.Upload(file, {
                                        uploadUrl: uploadUrl,
                                        retryDelays: [0, 3000, 5000, 10000, 20000],
                                        metadata: {
                                            filename: file.name,
                                            filetype: file.type
                                        },
                                        onError: function(error) {
                                            document.getElementById('loader-wrapper').classList.add('hidden');
                                            document.getElementById('video-percentage').innerText = '';
                                        },
                                        onProgress: function(bytesUploaded, bytesTotal) {
                                            let percentage = Math.round(bytesUploaded / bytesTotal * 100);
                                            document.getElementById('loader-wrapper').classList.remove('hidden');
                                            document.getElementById('video-percentage').innerText = 'uploading ' + percentage + '%';
                                        },
                                        onSuccess: function() {
                                            @this.updateCardVideoUrl('{{$cardElement->id}}', videoId);
                                            document.getElementById('loader-wrapper').classList.remove('hidden');
                                            document.getElementById('video-percentage').innerText = 'processing...';

    {{--                                        console.log('Download %s from %s', upload.file.name, upload.url);--}}

                       {{--                                        $dispatch('notify', {'message': 'Video Uploaded'})--}}
                           }
                       })

                       upload.findPreviousUploads().then(function (previousUploads) {
                           if (previousUploads.length) {
                               upload.resumeFromPreviousUpload(previousUploads[0]);
                           }

                           upload.start();
                       })
                   }
               }
"/>

                <!-- Media Preview -->
                <div class="relative">
                    <div>
                        @if(($this->media_preview || $cardElement->media_path) && !$this->hide_media)
                            <div>
                                @if($this->mediaType === 'video')
                                    @if(is_numeric($cardElement->media_path))
                                        <div x-show="mediaProcessed" wire:ignore>
                                            <div id="vimeo-video-player"></div>
                                        </div>
                                    @else
                                        <video
                                            ref="video-card"
                                            id="my-video"
                                            class="video-js vjs-big-play-centered vjs-fluid rounded-t @if($this->hide_media) hidden @endif"
                                            style="height: unset"
                                            controls
                                            preload="auto"
                                            width="640"
                                            height="264"
                                            poster="/other/art.jpg"
                                            data-setup="{}"
                                        >
                                            <source src="{{ $this->media_preview ?? $cardElement->media_path }}"
                                                    type="video/mp4"/>

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
                                    <img
                                        class="w-full card-element-media rounded-t-xl @if($this->hide_media) hidden @endif"
                                        src="{{ $this->media_preview ?? $cardElement->media_path }}">
                                @endif

                                @if($this->media_processed)
                                    <div class="absolute top-1 right-0.5 z-50" wire:click="removeMedia"
                                         wire:target="media"
                                         wire:loading.remove>
                                    <span class="fa-stack bg-transparent cursor-pointer group text-xs">
                                        <i class="fas fa-circle fa-stack-2x text-black opacity-70 group-hover:opacity-100"></i>
                                        <i class="fas fa-times fa-stack-1x text-white"></i>
                                    </span>
                                    </div>
                                @endif
                            </div>
                    @endif

                    <!-- loader -->
                        <div id="loader-wrapper" class="h-52 hidden">
                            <div id="loader"
                                 class="absolute h-full w-full top-0 backdrop-blur-lg bg-gray-900" {{--style="backdrop-filter: brightness(0.3)"--}}>
                                <div
                                    class="select-none text-sm text-indigo-500 flex flex-1 items-center justify-center text-center p-4 flex-1"
                                    style="height: inherit">
                                    <svg class="animate-spin h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg"
                                         fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>

                                        <p id="video-percentage" class="ml-1">processing...</p>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="overflow-y-scroll w-full text-center shadow h-64 m-auto rounded-t-lg bg-black @if($this->hide_gifs) hidden @endif"
                        id="gif_scroll" style="min-height:275px;">
                        <div
                            class="flex pb-96 pt-12 w-full grid grid-cols-1 sm:grid-cols-5 lg:grid-cols-3 md:grid-cols-1 grid-flow-row auto-cols-max">
                            @foreach($this->gifs as $g)
                                <img src="{{ htmlentities($g) }}"
                                     class="xs border-black border-2 w-full h-full rounded cursor-pointer object-cover hover:border-blue-300"
                                     wire:click="selectGif('{{ htmlentities($g) }}')">
                            @endforeach
                        </div>
                    </div>


                    <div class="w-full m-auto flex justify-center mt-3">
                        <x-jet-secondary-button class="mx-2 w-60" type="button"
                                                x-on:click.prevent="$refs.media.click()">
                            {{ __('Upload Image or Video') }}
                        </x-jet-secondary-button>

                        <input wire:model.debounce.800ms="search" type="search" id="searchbar_gif"
                               autocomplete="off" placeholder="Search for the perfect Gif..."
                               class="focus:outline-none border-gray-200 p-1 m-auto rounded w-1/2 sm:w-3/4 md:3/4 lg:w-2/3"
                               style="border-top:none; border-left: none; border-right: none; height: 30px; margin-right: 10px"/>

                        @if (false)
                            <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                                {{ __('Remove Photo') }}
                            </x-jet-secondary-button>
                        @endif
                    </div>

                    <x-jet-input-error for="media" class="mt-2"/>
                </div>
            </div>
        </form>

        <form wire:submit.prevent="publishCardElement">
            <div class="card-element-text p-2">
                <div class="mt-2 bg-white" wire:ignore>
                    <div id="quill-editor"
                         class="rounded free_form font-handwriting tracking-wide text-lg"
                         style='font-size: 1.125rem; line-height: 1.75rem; font-family: Handlee, Annie Use Your Telescope, Architects Daughter, Shadows Into Light, cursive;'
                         x-data
                         x-ref="quillEditor"
                         x-init="
                             toolbarOptions = {
                               container: [
                                    ['bold', 'italic', 'underline', 'strike'],
                                    //['blockquote'],
                                    [{'list': 'bullet'}],
                                    //[{'indent': '-1'}, {'indent': '+1'}],
                                    [{'color': []}, {'background': []}],
                                    //[{'font': []}],
                                   // [{'align': []}],
                                    ['clean'],
                                    ['emoji'],
                                    ['link']
                                    //['link', 'image', 'video']
                                ],
                                handlers: {
                                  'emoji': function () {}
                                }
                              }

                              quill = new Quill($refs.quillEditor, {
                                modules: {
                                 'toolbar': toolbarOptions,
                                 'emoji-toolbar': true,
                                  'emoji-shortname': true,
                                  'emoji-textarea': true
                              },
                                placeholder: 'Write something amazing...',
                                theme: 'snow',
                              });

                               quill.on('text-change', function () {
                              $dispatch('quill-input', quill.root.innerHTML);
                             }); "
                         x-on:quill-input.debounce.1000ms="@this.set('text', $event.detail)"
                    >
                        {!! $text !!}
                    </div>
                </div>
            </div>
        </form>

        <div class="card-element-signature py-2 px-4 w-full text-right text-gray-600 italic text-lg">
            From {{Auth::user()->name}}
        </div>

        <div class="flex border-t border-gray-300">
            @if($this->cardElement->active)
                <div class="italic text-sm w-1/3 text-left m-2">
                    Published - AutoSaved
                </div>
            @else
                <div class="italic text-sm w-1/3 text-left m-2">
                    Not Published - Not Autosaved
                </div>
            @endif

            <div class="w-2/3 text-right fe">
                @if(Auth::user()->id == $this->card->creator->id)@endif

                @if(!$this->cardElement->active)
                    <x-jet-button wire:click="publishCardElement" class="m-3">
                        Publish
                    </x-jet-button>
                @else
                    <x-jet-secondary-button wire:click="unPublishCardElement" class="m-3">
                        Unpublish
                    </x-jet-secondary-button>
                @endif
            </div>
        </div>
    </div>
</div>
