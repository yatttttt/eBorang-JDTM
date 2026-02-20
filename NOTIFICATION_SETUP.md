# Real-Time Notification System Setup Guide

## Overview

This system provides real-time notifications that **exactly match** your existing email notification logic. Whoever receives an email will also receive a system notification automatically.

## Features

✅ **Three Channels**: Mail, Database, and Broadcast (real-time)  
✅ **Bell Icon** with red badge showing unread count  
✅ **Dropdown** showing all notifications  
✅ **Unread notifications** are bold  
✅ **Auto-mark as read** when bell is clicked  
✅ **Links to permohonan** pages based on user role  
✅ **Real-time updates** via Laravel Echo + Pusher (no page refresh)  

## Installation Steps

### 1. Run Database Migration

```bash
php artisan migrate
```

This creates the `notifications` table.

### 2. Install NPM Dependencies

```bash
npm install
```

This installs:
- `laravel-echo` - Laravel's real-time library
- `pusher-js` - WebSocket client for Pusher

### 3. Configure Broadcasting

#### Option A: Using Pusher (Recommended for Production)

1. Sign up at [pusher.com](https://pusher.com) (free tier available)
2. Create a new app
3. Get your credentials (App ID, Key, Secret, Cluster)

#### Option B: Using Laravel WebSockets (For Local Development)

1. Install Laravel WebSockets: `composer require beyondcode/laravel-websockets`
2. Publish config: `php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider"`
3. Run migrations: `php artisan migrate`
4. Start WebSocket server: `php artisan websockets:serve`

### 4. Update .env File

Add these to your `.env` file:

```env
# Broadcasting Configuration
BROADCAST_DRIVER=pusher
# OR for Laravel WebSockets: BROADCAST_DRIVER=pusher

# Pusher Configuration (if using Pusher)
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=mt1
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https

# Vite Environment Variables (for frontend)
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### 5. Build Frontend Assets

```bash
npm run dev
# OR for production:
npm run build
```

### 6. Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## How It Works

### Notification Flow

1. **Trigger**: When a permohonan status changes (via `NotificationHelper`)
2. **Send**: Notification is sent via 3 channels simultaneously:
   - **Mail**: Email notification (existing functionality)
   - **Database**: Stored in `notifications` table
   - **Broadcast**: Real-time via Laravel Echo/Pusher
3. **Display**: Notification appears instantly in the bell dropdown
4. **Read**: Clicking the bell marks all notifications as read

### Recipient Logic

The system **exactly matches** your email notification logic:

- **notifyAdmins()**: Sends to all users with `peranan = 'admin'`
- **notifyNextReviewer()**: Sends to all users with the specified role (pengarah, pegawai, pentadbir_sistem)
- **notifyApplicationCompleted()**: Sends to all admins when Pentadbir Sistem approves
- **notifySpecificUser()**: Sends to a specific user (e.g., when assigned)

**Important**: Every email recipient automatically receives a system notification.

## File Structure

```
app/
├── Notifications/
│   └── NewPermohonanNotification.php    # Notification class (mail + database + broadcast)
├── Http/Controllers/
│   └── NotificationController.php      # API endpoints for notifications
└── Helpers/
    └── NotificationHelper.php          # Updated to send notifications

database/migrations/
└── 2025_12_20_000000_create_notifications_table.php

resources/
├── views/layout/
│   └── app.blade.php                    # Updated with bell icon and dropdown
└── js/
    └── bootstrap.js                     # Echo/Pusher configuration

routes/
├── web.php                              # Notification routes added
└── channels.php                         # Broadcast channel authorization
```

## Routes

- `GET /notifications` - Fetch all notifications
- `POST /notifications/mark-as-read` - Mark all as read
- `GET /notifications/unread-count` - Get unread count

## Customization

### Adding New Notification Types

1. Update `NewPermohonanNotification` class:
   - Add new case in `toMail()` method
   - Add new case in `toArray()` method

2. Update `NotificationHelper`:
   - Add new method or update existing ones
   - Call `$user->notify(new NewPermohonanNotification(...))`

### Changing Roles

To add/remove roles that receive notifications:

1. **In NotificationHelper.php**: Update the `where('peranan', ...)` queries
2. **In NewPermohonanNotification.php**: Update the `$roleNames` array
3. **In layout/app.blade.php**: Update `getPermohonanUrl()` function to include new role routes

### Styling

Notification styles are in `resources/views/layout/app.blade.php`:
- `.notification-bell` - Bell icon
- `.notification-badge` - Red badge
- `.notification-dropdown` - Dropdown container
- `.notification-item` - Individual notification
- `.notification-item.unread` - Unread notification styling

## Testing

### Test Email Notifications

1. Create a new permohonan as Admin
2. Check that Pengarah receives email AND system notification

### Test Real-Time Updates

1. Open two browser windows (or two different users)
2. In Window 1: Update a permohonan status
3. In Window 2: Notification should appear instantly without refresh

### Test Mark as Read

1. Click the bell icon
2. All notifications should be marked as read
3. Red badge should disappear

## Troubleshooting

### Notifications Not Appearing

1. **Check browser console** for JavaScript errors
2. **Check Laravel logs**: `storage/logs/laravel.log`
3. **Verify Pusher connection**: Check network tab for WebSocket connection
4. **Verify database**: Check `notifications` table has entries

### Real-Time Not Working

1. **Check .env**: Verify Pusher credentials are correct
2. **Check Echo**: Verify `window.Echo` is defined in browser console
3. **Check channel authorization**: Verify user can access private channel
4. **Check queue**: If using queues, run `php artisan queue:work`

### Badge Not Updating

1. **Check JavaScript**: Verify `fetchNotifications()` is called
2. **Check API**: Test `/notifications` endpoint directly
3. **Check CSRF token**: Verify meta tag is present in layout

## Production Checklist

- [ ] Set up Pusher account (or Laravel WebSockets)
- [ ] Update .env with production credentials
- [ ] Run `npm run build` for production assets
- [ ] Set up queue worker: `php artisan queue:work`
- [ ] Test notifications in production environment
- [ ] Monitor Laravel logs for errors
- [ ] Set up error tracking (Sentry, etc.)

## Support

For issues or questions:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check browser console for JavaScript errors
3. Verify all dependencies are installed
4. Ensure database migration has run

---

**Note**: This system is designed to work seamlessly with your existing email notification logic. No changes to email functionality are required - notifications are sent in addition to emails.

