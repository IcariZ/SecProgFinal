<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class UserList extends Component
{
    use WithPagination;

    public $editingUserId = null;
    public $editingUsername = '';
    
    // New user form properties
    public $isCreating = false;
    public $newUser = [
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => ''
    ];

    protected $rules = [
        'newUser.name' => 'required|min:3',
        'newUser.email' => 'required|email|unique:users,email',
        'newUser.password' => 'required|min:8|confirmed'
    ];

    public function createUser()
    {
        $this->validate();

        User::create([
            'name' => $this->newUser['name'],
            'email' => $this->newUser['email'],
            'password' => Hash::make($this->newUser['password']),
            'is_admin' => false
        ]);

        $this->isCreating = false;
        $this->newUser = [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => ''
        ];
    }

    public function toggleCreateForm()
    {
        $this->isCreating = !$this->isCreating;
        $this->newUser = [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => ''
        ];
    }

    public function editUser(User $user)
    {
        abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, 403);
        
        $this->editingUserId = $user->id;
        $this->editingUsername = $user->name;
    }

    public function cancelEdit()
    {
        $this->editingUserId = null;
        $this->editingUsername = '';
    }

    public function saveUsername()
    {
        abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, 403);

        $this->validate([
            'editingUsername' => 'required|min:3'
        ]);

        $user = User::findOrFail($this->editingUserId);
        $user->update([
            'name' => $this->editingUsername
        ]);

        $this->editingUserId = null;
        $this->editingUsername = '';
    }

    public function delete(User $user)
    {
        abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, 403);

        if ($user->is_admin) {
            return;
        }

        $user->delete();
    }

    public function getSessionTimeLeft(User $user): string 
    {
        // Get session lifetime from config (in minutes)
        $lifetime = config('session.lifetime', 120);
        
        // Calculate remaining time
        $lastActivity = $user->last_activity ? strtotime($user->last_activity) : null;
        if (!$lastActivity) {
            return 'Session expired';
        }
        
        $expiresAt = $lastActivity + ($lifetime * 60);
        $remainingSeconds = $expiresAt - time();
        
        if ($remainingSeconds <= 0) {
            return 'Session expired';
        }
        
        // Convert to minutes and seconds
        $minutes = floor($remainingSeconds / 60);
        $seconds = $remainingSeconds % 60;

        return "{$minutes}m {$seconds}s";
    }

    public function getListeners()
    {
        return [
            '$refresh',
        ];
    }

    // Add polling every 5 seconds
    protected $polling = 5000;

    public function render(): View
    {
        $users = User::where('is_admin', false)->paginate();

        return view('livewire.admin.user-list', [
            'users' => $users
        ]);
    }
}