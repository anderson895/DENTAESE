<!-- User Modal -->
<div id="userModal" class="fixed inset-0 hidden z-50 bg-black bg-opacity-50 flex items-center justify-center overflow-y-auto">
    <div class="bg-gray-50 w-full max-w-6xl p-6 rounded-xl relative max-h-screen overflow-y-auto">
        <button onclick="closeUserModal()" class="absolute top-2 right-4 text-2xl text-gray-600 hover:text-red-500">&times;</button>

        <h1 class="text-xl font-semibold mb-4 text-gray-800">View User Details</h1>
        <div id="userModalContent">
            <!-- You will dynamically inject the inner content using JS here -->
            <p class="text-center text-gray-500">Loading...</p>
        </div>
    </div>
</div>