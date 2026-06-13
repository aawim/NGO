<x-mail::message>
# Welcome to the team, {{ $user->name }}!

Thank you for applying to be a volunteer. We have received your application and our team will review it shortly.

In the meantime, we have automatically created an account for you so you can track your application and access our volunteer portal.

**Your Login Credentials:**
* **Email:** {{ $user->email }}
* **Temporary Password:** {{ $tempPassword }}

<x-mail::button :url="route('login')">
Login to your Account
</x-mail::button>

*Note: We highly recommend changing your password after your first login.*

Thank you for making a difference,<br>
The {{ config('app.name') }} Team
</x-mail::message>