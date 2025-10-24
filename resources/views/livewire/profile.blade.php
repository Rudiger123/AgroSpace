<div class="min-h-screen bg-agro-beige flex items-center justify-center">
    <div class="bg-agro-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-poppins text-agro-green mb-6">Your Profile</h2>
        <p class="text-agro-gray font-inter">Name: {{ auth()->user()->name }}</p>
        <p class="text-agro-gray font-inter">Email: {{ auth()->user()->email }}</p>
        <p class="text-agro-gray font-inter">Role: {{ ucfirst(auth()->user()->role->name) }}</p>
    </div>
</div>