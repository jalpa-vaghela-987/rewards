<div class="bhrForm bhrForm--inline2 js-bhrForm" id="js-homepage-signup"
      aria-label="Try {{ appName() }} free form" __bizdiag="96619420"
      __biza="WJ__">
    <div class="bhrForm__left">
        <div class="bhrForm__inputWrapper">
            <input type="email" wire:model="email" wire:keydown.enter="sendMail"
                   class="bhrForm__input js-bhrForm-input js-bhrForm-email bg-white"
                   id="bhrform-email"
                   aria-label="Enter your email here to try {{ appName() }} free">
            <label for="bhrform-email" class="bhrForm__label js-bhrForm-label">Email Address</label>
        </div>
    </div>

    <div class="bhrForm__right">
        <button wire:click="sendMail" class="ps_color1_background bhrcolor-white bhrForm__submit" aria-label="Click here to submit the form">
            Submit!
        </button>
    </div>
</div>
