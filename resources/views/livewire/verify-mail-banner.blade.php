@auth
    @if(!auth()->user()->hasVerifiedEmail())
        <div class="h-14 sm:h-10 p-2 sm:p-0 w-full bg-red-200 text-red-800 flex justify-center items-center">
            <div>
                You have not yet verified your email,
                <a href="javascript:void(0)" class="text-blue-800" wire:click="sendVerificationMail">
                    click here
                </a>
                to resend the verification email.
            </div>
        </div>
    @endif
@endauth
