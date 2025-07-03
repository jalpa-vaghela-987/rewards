<div>
    <div>
        @forelse($points as $point)
            @include('components.social-card', ['point' => $point])
        @empty
            <div class="p-4 text-gray-500">
                No {{ getReplacedWordOfKudos() }}
            </div>
        @endforelse
    </div>

    @if($hasMorePages)
    <div
        x-data="{
            observe () {
                let observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            @this.call('loadMore')
                        }
                    })
                }, {
                    root: null
                })

                observer.observe(this.$el)
            }
        }"
        x-init="observe"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-4"
    ></div>
    @endif

    <x-jet-dialog-modal wire:model="showKudosUpdateModal">
        <x-slot name="title">
            {{ __('Edit ' . getReplacedWordOfKudos()) }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-2 bg-white" id="quillhKudosEdit" @if($kudosText) wire:ignore @endif>
                <div
                    class="rounded free_form font-handwriting tracking-wide text-lg"
                    style="font-size: 1.125rem; line-height: 1.75rem; min-height: 150px;"
                    x-data="{}"
                    x-ref="quillEditorKudosEdit"
                    x-init="
                        toolbarOptions = {
                            container: [
                                ['bold', 'italic', 'underline', 'strike'],
                                [{'list': 'bullet'}],
                                [{'color': []}, {'background': []}],
                                ['clean'],
                                ['emoji'],
                                ['link']
                            ],
                            handlers: {
                                'emoji': function () {
                                }
                            }
                        }
                        quill = new Quill($refs.quillEditorKudosEdit, {
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
                        });
                    "
                    x-on:quill-input.defer="@this.set('kudosText', $event.detail)"
                >

                    {!! html_entity_decode(htmlspecialchars_decode($kudosText)) !!}
                </div>
            </div>

            <x-jet-input-error for="message" class="mt-2"/>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="resetEditKudosModal">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-link-button class="ml-2" x-on:click="$wire.updateKudos()" id="updateKudosButton1">
                {{ __('Update') }}
            </x-link-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
