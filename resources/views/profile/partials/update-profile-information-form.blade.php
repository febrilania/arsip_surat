<section class="bg-white p-6 rounded-lg shadow-md">
    <header class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Profile Information</h2>
        <p class="mt-1 text-sm text-gray-600">Update your account's profile information and email address.</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Profile Picture Preview -->
        <div class="flex items-start gap-6">
            <label for="profile_photo" class="cursor-pointer">
                <img id="profilePreview" src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('default-avatar.png') }}" 
                     class="w-48 h-48 rounded-lg border-4 border-gray-300 object-cover shadow-md">
            </label>
            <input id="profile_photo" name="profile_photo" type="file" class="hidden" accept="image/*" onchange="previewImage(event)">
        </div>
        <p class="text-sm text-gray-500">Click the image to change profile picture</p>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
        </div>

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required autocomplete="username" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const imgElement = document.getElementById('profilePreview');
            imgElement.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
