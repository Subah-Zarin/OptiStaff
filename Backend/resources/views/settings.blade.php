@extends('layouts.app')

@section('title', 'Settings - OptiStaff')

@section('content')
<div class="bg-gray-100 min-h-screen py-10">

    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-10 text-center shadow-md rounded-lg mb-10">
        <h1 class="text-3xl font-bold">Settings</h1>
        <p class="text-gray-200 mt-2">Manage your account and system preferences</p>
    </div>

    <!-- Settings Container -->
    <div class="container mx-auto max-w-4xl bg-white rounded-lg shadow-md p-8 space-y-10">

        <!-- Profile Settings -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Profile Settings</h2>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="John Doe">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="john@example.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="+880 123456789">
                </div>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">Save Changes</button>
            </form>
        </div>

        <!-- Security Settings -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Security</h2>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input type="password" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <input type="password" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500">
                </div>
                <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition">Update Password</button>
            </form>
        </div>

        <!-- Notification Settings -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Notifications</h2>
            <form class="space-y-3">
                <div class="flex items-center">
                    <input type="checkbox" id="emailNotifications" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label for="emailNotifications" class="ml-2 text-gray-700">Email Notifications</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="smsNotifications" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label for="smsNotifications" class="ml-2 text-gray-700">SMS Notifications</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="systemAlerts" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label for="systemAlerts" class="ml-2 text-gray-700">System Alerts</label>
                </div>
                <button type="submit" class="mt-4 px-6 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">Save Preferences</button>
            </form>
        </div>

        <!-- System Preferences -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4">System Preferences</h2>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Language</label>
                    <select class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option>English</option>
                        <option>Bangla</option>
                        <option>Hindi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Timezone</label>
                    <select class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option>GMT +6 (Bangladesh)</option>
                        <option>GMT +5:30 (India)</option>
                        <option>GMT +8 (Singapore)</option>
                    </select>
                </div>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">Update Preferences</button>
            </form>
        </div>

    </div>
</div>
@endsection
