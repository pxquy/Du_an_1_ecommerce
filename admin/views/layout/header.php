<header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
    <!-- Toggle Sidebar -->
    <button id="sidebarToggle" class="text-gray-600 text-xl p-2 rounded hover:bg-gray-100 focus:outline-none">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Header Right -->
    <div class="flex items-center gap-4">
        <!-- Search (ẩn trên mobile) -->
        <div class="relative hidden md:block">
            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="search" placeholder="Search..."
                class="pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-64" />
        </div>

        <!-- Notification -->
        <button class="relative text-gray-600 hover:text-indigo-600 p-2 rounded focus:outline-none">
            <i class="fas fa-bell text-xl"></i>
            <span class="absolute top-1 right-1 w-2 h-2 bg-indigo-600 rounded-full"></span>
        </button>

        <!-- Mobile Avatar (hiện trên mobile, ẩn trên md+) -->
        <div class="md:hidden w-8 h-8 rounded-full overflow-hidden">
            <img src="https://via.placeholder.com/32" alt="User" class="w-full h-full object-cover" />
        </div>
    </div>
</header>