<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>
    <style>
        /* Center the container */
        .centered-card {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Card style for notifications */
        .reminder-card-container {
            width: 100%;
            max-width: 900px;
            background-color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .reminder-card-container:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        /* Mark All As Read link */
        .mark-as-all-read {
            display: block;
            text-align: right;
            color: #2563eb; /* Professional blue */
            font-weight: 500;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s ease;
        }

        .mark-as-all-read:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        /* Notification list */
        .notification-list {
            max-height: 600px;
            overflow-y: auto;
            padding-right: 8px;
        }

        /* Custom scrollbar for a polished look */
        .notification-list::-webkit-scrollbar {
            width: 8px;
        }

        .notification-list::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .notification-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .notification-list::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Notification item */
        .notification-item {
            display: flex;
            align-items: center;
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s ease;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item:hover {
            background-color: #f8fafc;
            border-radius: 8px;
        }

        /* Profile picture */
        .profile-pic {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 16px;
            border: 2px solid #e5e7eb;
        }

        /* Notification content */
        .notification-content {
            flex: 1;
        }

        .notification-content div:first-child {
            font-size: 16px;
            color: #1f2a44; /* Darker text for readability */
            font-weight: 500;
            line-height: 1.5;
        }

        .notification-content .time {
            font-size: 13px;
            color: #64748b;
            margin-top: 4px;
        }

        /* Empty state */
        .text-center {
            color: #64748b;
            font-size: 18px;
            font-weight: 400;
            margin: 40px 0;
        }

        /* HR divider */
        hr {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 16px 0;
        }

        /* Delete button (uncomment if used) */
        .delete-notification {
            background: none;
            border: none;
            color: #ef4444;
            font-size: 16px;
            cursor: pointer;
            padding: 8px;
            transition: color 0.2s ease;
        }

        .delete-notification:hover {
            color: #b91c1c;
        }

        /* Spinner animation (if needed elsewhere) */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .reminder-card-container {
                padding: 16px;
            }

            .notification-item {
                padding: 12px;
            }

            .profile-pic {
                width: 40px;
                height: 40px;
            }

            .notification-content div:first-child {
                font-size: 14px;
            }

            .notification-content .time {
                font-size: 12px;
            }
        }
    </style>

    <div class="centered-card mt-4">
        <div class="reminder-card-container">
            @if($all_notifications->isNotEmpty())
                <a href="#!"><span class="mark-as-all-read">Mark All As Read</span></a>
            @endif     
            <hr>
            <div class="notification-list" id="notification-list">
                <div class="notification-panel">
                    @foreach ($all_notifications as $all_notification)
                        <div class="notification-item d-flex align-items-center" data-notification_id="{{ $all_notification['id'] }}">
                            <img src="{{ asset(!empty($all_notification['image']) ? $all_notification['image'] : 'images/blank_profile_male.jpg') }}"
                                alt="Profile" class="profile-pic">
                            <div class="notification-content">
                                <div>{{ $all_notification['message'] }}</div>
                                <div class="time">{{ date('j F Y', strtotime($all_notification['created_at'])) .' at '. date('G:i', strtotime($all_notification['created_at'])) }}</div>
                            </div>
                            {{-- <button type="button" class="close delete-notification" data-dismiss="modal">×</button> --}}
                        </div>
                    @endforeach
                    @if($all_notifications->isEmpty())
                        <h3 class="text-center mt-4 mb-5">You have no notifications to show</h3>
                    @endif      
                </div>
            </div>
        </div>
    </div>
</x-app-layout>