<x-mail::message>
# Hello {{ $contactMessage->name }},

Thank you for reaching out to us regarding your {{ strtolower($contactMessage->request_type) }}.

{!! nl2br(e($replyText)) !!}

Best regards,<br>
The {{ config('app.name') }} Team
</x-mail::message>
