<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\UserInvitation;
use Livewire\Component;

class UserInvites extends Component
{
    public $search;
    public $selectedInvitation;
    public $confirmDeleteInvitation = false;
    public $showInvitationUpdateModal = false;

    protected $listeners = [
        'invitationUpdated' => 'resetEditInvitationModal',
    ];

    public function render()
    {
        return view('livewire.user-invites', [
            'users' => User::active()
                ->company(auth()->user()->company_id)
                ->whereHas('invitation')
                ->when($this->search, function ($q) {
                    $q->where(function ($q) {
                        $q->where('users.first_name', 'like', "$this->search%")
                            ->orWhere('users.last_name', 'like', "$this->search%")
                            ->orWhere('users.email', 'like', "$this->search%");
                    });
                })
                ->orderBy('signed_up_at')
                ->orderByDesc('created_at')
                ->paginate(),
        ]);
    }

    public function getInvitationStatus($invitation_sent_at, $sign_up_at = null)
    {
        $statuses = [
            'Joined' => ['status' => 'Joined', 'color' => 'green'],
            'Expired' => ['status' => 'Expired', 'color' => 'yellow'],
            'Pending' => ['status' => 'Pending', 'color' => 'gray'],
        ];

        if ($sign_up_at) {
            return $statuses['Joined'];
        }

        if ($this->isInvitationExpired($invitation_sent_at)) {
            return $statuses['Expired'];
        }

        return $statuses['Pending'];
    }

    public function isInvitationExpired($invitation_sent_at): bool
    {
        return $invitation_sent_at &&
            now()->diffInDays($invitation_sent_at) >
            INVITATION_EXPIRE_AFTER_DAYS;
    }

    public function getInvitation($email)
    {
        $invitation = UserInvitation::where('email', $email)->first();

        return $invitation &&
        $invitation->ghost_user &&
        ! $invitation->ghost_user->signed_up_at
            ? $invitation
            : null;
    }

    //-------- delete --------//
    public function confirmDeletingInvitation($email)
    {
        $this->selectedInvitation = $this->getInvitation($email);

        if ($this->selectedInvitation) {
            $this->confirmDeleteInvitation = true;
        } else {
            $this->reset('selectedInvitation');
        }
    }

    public function cancelDeletingInvitation()
    {
        $this->reset(['selectedInvitation', 'confirmDeleteInvitation']);
    }

    public function deleteInvitation()
    {
        if ($this->selectedInvitation) {
            $this->selectedInvitation->ghost_user->teams()->sync([]);
            $this->selectedInvitation->ghost_user
                ->forceFill([
                    'active' => 0,
                ])
                ->save();
            //            $this->selectedInvitation->ghost_user->delete();
            $this->selectedInvitation->delete();

            $this->reset(['selectedInvitation', 'confirmDeleteInvitation']);

            $this->dispatchBrowserEvent('notify', [
                'message' => 'Invitation Deleted',
            ]);
        }
    }

    //-------- edit --------//
    public function editInvitation($email)
    {
        $invitation = $this->getInvitation($email);

        $this->redirectRoute('company.invitation.edit', [
            'invitation' => $invitation,
        ]);
    }

    public function confirmEditingInvitation($email)
    {
        $this->selectedInvitation = $this->getInvitation($email);

        if ($this->selectedInvitation) {
            $this->showInvitationUpdateModal = true;
        } else {
            $this->resetEditInvitationModal();
        }
    }

    public function resetEditInvitationModal()
    {
        $this->reset(['selectedInvitation', 'showInvitationUpdateModal']);
    }

    public function resendInvitation($email)
    {
        $invitation = $this->getInvitation($email);

        if ($invitation) {
            $invitation->send_invite();

            $invitation->created_at = now();
            $invitation->save();

            $invitation->ghost_user->created_at = now();
            $invitation->ghost_user->save();

            session()->flash('flash.banner', 'Invitation Resent');

            $this->redirectRoute('company.manage-invites');
        }
    }

    public function inviteNewUser()
    {
        $this->redirectRoute('company.manage.users');
    }

    public function bulkInvite()
    {
        $this->redirectRoute('company.users.bulk-invite');
    }
}
